<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Services\OrderPaymentFinalizer;
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

        if ($event->type == 'checkout.session.completed') {
            $session = $event->data->object;
            
            // Recuperiamo il nostro group_code che avevamo passato a Stripe
            $orderCode = $session->client_reference_id; 

            $order = Order::with('tickets')->where('group_code', $orderCode)->first();

            if ($order) {
                app(OrderPaymentFinalizer::class)->finalize($order);
                Log::info("Ordine {$orderCode} pagato con successo tramite Webhook Stripe.");
            }
        }

        if ($event->type == 'payment_intent.succeeded') {
            $paymentIntent = $event->data->object;
            $orderCode = $paymentIntent->metadata->group_code ?? null;

            $order = Order::with('tickets')
                ->when($orderCode, fn ($query) => $query->where('group_code', $orderCode))
                ->when(! $orderCode, fn ($query) => $query->where('stripe_payment_intent_id', $paymentIntent->id))
                ->first();

            if ($order) {
                app(OrderPaymentFinalizer::class)->finalize($order);
                Log::info("Ordine {$order->group_code} pagato con successo tramite Payment Intent Stripe.");
            }
        }

        // Rispondiamo a Stripe con un 200 OK per dirgli "Messaggio ricevuto!"
        return response('Webhook gestito', 200);
    }
}
