<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Jobs\SendTicketEmail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function handleStripe(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $endpoint_secret = config('services.stripe.webhook_secret');

        try {
            // Verifichiamo che la chiamata arrivi davvero da Stripe e non sia un hacker
            $event = \Stripe\Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
        } catch(\UnexpectedValueException $e) {
            return response('Payload non valido', 400);
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            return response('Firma non valida', 400);
        }

        // Se il pagamento è andato a buon fine!
        if ($event->type == 'checkout.session.completed') {
            $session = $event->data->object;
            
            // Recuperiamo il nostro group_code che avevamo passato a Stripe
            $orderCode = $session->client_reference_id; 

            $order = Order::with('tickets')->where('group_code', $orderCode)->first();

            // Se l'ordine esiste ed era ancora in attesa
            if ($order && $order->status !== 'paid') {
                $order->update(['status' => 'paid']); // Ordine Pagato!
                
                // Sblocchiamo tutti i biglietti di quell'ordine
                foreach ($order->tickets as $ticket) {
                    $ticket->update([
                        'status' => 'active',
                        'unique_ticket_code' => 'TK_' . strtoupper(Str::random(8))
                    ]);
                    
                    // SPARA L'EMAIL IN BACKGROUND!
                    SendTicketEmail::dispatch($ticket);
                }
                Log::info("Ordine {$orderCode} pagato con successo tramite Webhook Stripe.");
            }
        }

        // Rispondiamo a Stripe con un 200 OK per dirgli "Messaggio ricevuto!"
        return response('Webhook gestito', 200);
    }
}
