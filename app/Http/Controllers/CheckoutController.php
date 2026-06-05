<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Jobs\SendTicketEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Throwable;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validazione massiccia
        $validatedData = $request->validate([
            'payment_method' => 'required|in:stripe,paypal',
            'is_sports_association' => 'boolean',
            'association_name' => 'required_if:is_sports_association,1|nullable|string|max:255',
            'is_mutua_member' => 'boolean', 
            'tickets' => 'required|array|min:1',
            'tickets.*.first_name' => 'required|string|max:255',
            'tickets.*.last_name' => 'required|string|max:255',
            'tickets.*.codice_fiscale' => 'nullable|string|max:16', 
            'tickets.*.route_choice' => 'required|in:Partenza Rosa,Partenza Bianca,Partenza Gialla',
            'tickets.*.dob' => 'required|date',
            'tickets.*.birth_place' => 'required|string|max:255',
            'tickets.*.residence_address' => 'required|string|max:255',
            'tickets.*.city' => 'required|string|max:255',
            'tickets.*.zip_code' => 'required|string|max:20',
            'tickets.*.province' => 'required|string|max:255',
            'tickets.*.region' => 'required|string|max:255',
            'tickets.*.country' => 'required|string|max:255',
            'tickets.*.nationality' => 'required|string|max:2',
            'tickets.*.email' => 'required|email',
            'tickets.*.phone' => 'required|string|max:20',
            'tickets.*.tshirt_size' => 'required|in:XS,S,M,L,XL,XXL',
            'tickets.*.shuttle_needed' => 'required|boolean',
            'tickets.*.celiac' => 'required|boolean',
        ]);

        // 2. Calcolo del prezzo
        // Leggiamo il prezzo dal database. Se non dovesse esistere, usiamo 28.00 come paracadute.
        $basePrice = \App\Models\Setting::where('key', 'ticket_price')->value('value') ?? 28.00;
        $discountAmount = 0;
        $appliedDiscountLabel = null;

        // Prezzo standard per i biglietti paganti
        $finalPricePerTicket = max(0, $basePrice - $discountAmount);

        // --- LOGICA PROMO GRUPPI (Ogni 11 biglietti, 1 è gratis) ---
        $totalTickets = count($validatedData['tickets']);
        $freeTicketsCount = floor($totalTickets / 11);
        $paidTicketsCount = $totalTickets - $freeTicketsCount;

        // Il totale dell'ordine si calcola ESCLUSIVAMENTE sui biglietti paganti
        $totalAmount = $paidTicketsCount * $finalPricePerTicket;

        if ($validatedData['payment_method'] === 'stripe' && blank(config('services.stripe.secret'))) {
            return back()
                ->withInput()
                ->withErrors(['payment_method' => 'Stripe non è configurato: manca STRIPE_SECRET nel file .env oppure la configurazione Laravel è in cache.']);
        }

        // Aggiungiamo l'etichetta se è scattata la promo
        if ($freeTicketsCount > 0) {
            $promoLabel = "PROMO_11_GRATIS";
            $appliedDiscountLabel = $appliedDiscountLabel ? $appliedDiscountLabel . ' + ' . $promoLabel : $promoLabel;
        }

        // 3. Creazione Ordine e Biglietti
        $order = DB::transaction(function () use ($request, $validatedData, $appliedDiscountLabel, $totalAmount, $finalPricePerTicket) {
            $order = Order::create([
                'group_code' => 'SGR_' . strtoupper(\Illuminate\Support\Str::random(10)),
                'total_amount' => $totalAmount,
                'payment_method' => $validatedData['payment_method'],
                'is_sports_association' => $request->has('is_sports_association'),
                'association_name' => $validatedData['association_name'] ?? null,
                'discount_code' => $appliedDiscountLabel,
                'status' => 'pending',
            ]);

            foreach ($validatedData['tickets'] as $index => $data) {
                // L'undicesimo biglietto (indice 10, 21, 32...) ha prezzo 0€
                $isFreeTicket = (($index + 1) % 11 == 0);
                $ticketPrice = $isFreeTicket ? 0 : $finalPricePerTicket;

                $order->tickets()->create(array_merge($data, [
                    'unique_ticket_code' => null,
                    'price_paid' => $ticketPrice,
                    'payment_tag' => ucfirst($validatedData['payment_method']),
                    'status' => 'pending',
                ]));
            }

            return $order;
        });

        // 5. Redirect Pagamento
        if ($totalAmount == 0) {
            return redirect()->route('checkout.success', ['order_code' => $order->group_code]);
        }

        try {
            return ($validatedData['payment_method'] === 'stripe')
                ? $this->processStripePayment($order)
                : $this->processPaypalPayment($order);
        } catch (Throwable $e) {
            $order->update(['status' => 'payment_error']);
            Log::error('Errore avvio pagamento', [
                'order_id' => $order->id,
                'group_code' => $order->group_code,
                'payment_method' => $order->payment_method,
                'message' => $e->getMessage(),
            ]);

            return back()
                ->withInput()
                ->withErrors(['payment_method' => 'Non siamo riusciti ad avviare il pagamento. Controlla la configurazione del gateway e riprova.']);
        }
    }

    private function processStripePayment(Order $order)
    {
        $stripeSecret = config('services.stripe.secret');

        if (blank($stripeSecret)) {
            throw new RuntimeException('Stripe secret key non configurata.');
        }

        \Stripe\Stripe::setApiKey($stripeSecret);

        $lineItems = [];
        foreach ($order->tickets as $ticket) {
            // SALVAGENTE STRIPE: Inviamo a Stripe solo i biglietti che hanno un costo maggiore di zero.
            if ($ticket->price_paid > 0) {
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => 'Iscrizione Sgranar per Colli - ' . $ticket->first_name . ' ' . $ticket->last_name,
                            'description' => 'Taglia maglia: ' . $ticket->tshirt_size,
                        ],
                        'unit_amount' => intval($ticket->price_paid * 100), 
                    ],
                    'quantity' => 1,
                ];
            }
        }

        $checkout_session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success', ['order_code' => $order->group_code]),
            'cancel_url' => route('checkout.cancel', ['order' => $order->group_code]),
            'client_reference_id' => $order->group_code, 
        ]);

        $order->update(['stripe_session_id' => $checkout_session->id]); 

        return redirect()->away($checkout_session->url);
    }

    private function processPaypalPayment(Order $order)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('checkout.success', ['order_code' => $order->group_code]),
                "cancel_url" => route('checkout.cancel', ['order' => $order->group_code]),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "EUR",
                        "value" => $order->total_amount
                    ]
                ]
            ]
        ]);

        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    $order->update(['paypal_order_id' => $response['id']]); 
                    return redirect()->away($links['href']);
                }
            }
        }

        return redirect()->route('checkout.cancel', ['order' => $order->group_code])->with('error', 'Qualcosa è andato storto con PayPal.');
    }

    public function success(Request $request, $order_code)
    {
        $order = Order::with('tickets')->where('group_code', $order_code)->firstOrFail();

        // 1. Se l'ordine risulta già pagato, mostriamo solo la vista.
        if ($order->status === 'paid') {
            return view('checkout.success', compact('order'));
        }

        // --- 2. VERIFICA E CATTURA PAGAMENTO PAYPAL ---
        if ($order->payment_method === 'paypal' && $request->has('token')) {
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $provider->getAccessToken();
            
            // QUESTA È LA RIGA MAGICA CHE PRELEVA EFFETTIVAMENTE I SOLDI
            $response = $provider->capturePaymentOrder($request->query('token'));
            
            if (isset($response['status']) && $response['status'] == 'COMPLETED') {
                $order->update(['status' => 'paid']);
            } else {
                return redirect()->route('checkout.cancel', ['order' => $order->group_code])->with('error', 'Il pagamento PayPal non è stato autorizzato o è stato annullato.');
            }
        }
        
        // --- 3. VERIFICA PAGAMENTO STRIPE ---
        elseif ($order->payment_method === 'stripe' && $order->stripe_session_id) {
            $stripeSecret = config('services.stripe.secret');

            if (blank($stripeSecret)) {
                return redirect()->route('checkout.cancel', ['order' => $order->group_code])->with('error', 'Stripe non è configurato correttamente.');
            }

            \Stripe\Stripe::setApiKey($stripeSecret);
            $session = \Stripe\Checkout\Session::retrieve($order->stripe_session_id);
            
            if ($session->payment_status == 'paid') {
                $order->update(['status' => 'paid']);
            } else {
                return redirect()->route('checkout.cancel', ['order' => $order->group_code])->with('error', 'Il pagamento Stripe non è stato completato.');
            }
        }
        
        // --- 4. VERIFICA ORDINI A ZERO EURO (Promo Gruppi) ---
        elseif ($order->total_amount == 0) {
            $order->update(['status' => 'paid']);
        }

        // --- 5. AZIONI POST-PAGAMENTO VERIFICATO ---
        // Se l'ordine ha passato i controlli ed è "paid", attiviamo i biglietti
        if ($order->status === 'paid') {
            foreach ($order->tickets as $ticket) {
                
                // Generiamo il codice univoco che prima mancava
                $uniqueCode = $ticket->unique_ticket_code ?? 'TKT_' . strtoupper(\Illuminate\Support\Str::random(8));

                // Aggiorniamo il biglietto nel database
                $ticket->update([
                    'status' => 'active',
                    'unique_ticket_code' => $uniqueCode
                ]); 
                
                // Inviamo la mail
                SendTicketEmail::dispatch($ticket);
            }
            return view('checkout.success', compact('order'));
        }

        // Fallback in caso di tentativi anomali
        return redirect()->route('checkout.cancel', ['order' => $order->group_code])->with('error', 'Errore nella convalida del pagamento.');
    }

    public function downloadTicket($unique_code)
    {
        $ticket = Ticket::with('order')->where('unique_ticket_code', $unique_code)->firstOrFail();

        if ($ticket->order->status !== 'paid') {
            return back()->with('error', 'Il pagamento non è ancora stato confermato. Riprova tra poco.');
        }

        $pdf = Pdf::loadView('pdf.ticket', compact('ticket'));
        $fileName = 'Biglietto_Sgranar_' . str_replace(' ', '_', $ticket->last_name) . '.pdf';
        
        return $pdf->download($fileName);
    }
}
