<?php

namespace App\Http\Controllers;

use App\Mail\PaymentReceived;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use \Stripe\Charge;
use \Stripe\Stripe;
use \Stripe\Checkout\Session;
use App\Mail\PaymentConfirmation;
use Carbon\Carbon;

class PayController extends Controller
{
    public function show($token)
    {
        $payment = Payment::where('token', $token)->first();

        $user = $payment->user;
        $settings = json_decode($user->settings, true);
        if ($payment) {
            $user = $payment->user;
        }

        return view('pay.show', ['pay' => $payment], compact('payment', 'user', 'settings'));
    }
    public function checkout(Request $request, Payment $payment)
    {
        $user = $payment->user;
        $settings = json_decode($user->settings, true);
        if ($settings['payMethods'][0]['active'] == 1) {
            $settings = json_decode($user->settings, true);

            \Stripe\Stripe::setApiKey($settings['payMethods'][0]['privateKey']);
            $YOUR_DOMAIN = 'http://192.168.1.8:8000';



            $line_items = [];
            foreach ($payment->products as $product) {
                $line_items[] = [
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => $product['product_name'],
                        ],
                        'unit_amount' => $product['product_price'] * 100,
                    ],
                    'quantity' => $product['quantity'],
                ];
            }
            $request->session()->put('payment_id', $payment->id);
            $session = \Stripe\Checkout\Session::create([
                'line_items' => $line_items,
                'mode' => 'payment',
                'success_url' => $YOUR_DOMAIN . '/success',
                'cancel_url' => $YOUR_DOMAIN . '/checkout'
            ]);
        } else {
            return view('pay.show', ['pay' => $payment]);
        }
        $session_id = $session->id;
        $paymentIntentId = $session->payment_intent;
        return redirect()->away($session->url);
    }

    public function success(Request $request)
    {
        $paymentId = $request->session()->get('payment_id');
        $request->session()->forget('payment_id');
        $sessionId = $request->query('session_id');
        
        if ($paymentId) {
            $payment = Payment::find($paymentId);
            if ($payment) {
                $payment->status = 'paid';
                $payment->save();
                
               
            }
        }
        $payment = Payment::find($paymentId);
        $payment->pay_date = Carbon::now('Europe/Rome');
        $payment->save();
        
        // $user = $payment->user;
        // Mail::to($user->email)->send(new PaymentReceived($payment));
        return view('pay.success');
    }



    public function cancel()
    {
        return view('pay.cancel');
    }
}
