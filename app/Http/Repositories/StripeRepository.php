<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\StripeInterface;
use App\Http\Interfaces\ProductInterface;

use App\Http\Resources\ProductResource;
use App\Http\Traits\ApiDesignTrait;
use App\Http\Traits\CreateMediaTrait;
use App\Http\Traits\DeleteMediaTrait;
use App\Models\Media;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;

use App\Models\User;
use Illuminate\Http\Request;
use Stripe\Stripe;

class StripeRepository implements StripeInterface {
    use ApiDesignTrait;
    use CreateMediaTrait;
    use DeleteMediaTrait;

    private $paymentModel;
    private $mediaModel;
    private $orderModel;
    private $userModel;



    public function __construct(Payment $payment, Media $media, Order $order, User $user) {

        $this->paymentModel = $payment;
        $this->mediaModel = $media;
        $this->orderModel = $order;
        $this->userModel = $user;
    }

    public function authentication()
    {
        // TODO: Implement authentication() method.

    }

    public function generateIframeModel($request)
    {
        // TODO: Implement generateIframeModel() method.
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $order_id = $request->order_id;
        $user_id = $request->user_id;
//        $orderObj = $this->orderModel::find($order_id);
//        $user = $this->userModel::find($user_id);
//        dd($request->all());
        $orderObj = $this->orderModel::find($order_id);
        $user = $this->userModel::find($user_id);

        $session = \Stripe\Checkout\Session::create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => ['name' => $orderObj->products->first()->name ],
                        'unit_amount' => (($orderObj->amount - $orderObj->discount) + $orderObj->taxes )* 100,
                        'tax_behavior' => 'exclusive',
                    ],
                    'quantity' => 1,
                ],
            ],
            'metadata' => [
//                'user_id' => $orderObj->user_id,
                'user_id' => $user_id,
                'paymentable_id' => $order_id,
                'paymentable_type' => 'App\Models\Order',
                'transaction_id' => time(),
                'amount'         => (($orderObj->amount - $orderObj->discount) + $orderObj->taxes ),
            ],
            'payment_intent_data' => [ //callback
                'metadata' => [
                    'user_id' =>  $user_id,
                    'paymentable_id' => $order_id,
                    'paymentable_type' => 'App\Models\Order',
                    'transaction_id' => time(),
                    'amount'         => (($orderObj->amount - $orderObj->discount) + $orderObj->taxes ),
                ],
            ],
            'mode' => 'payment',
            'allow_promotion_codes' => true,
            'success_url' => route('checkout.success', [], true) . "?session_id={CHECKOUT_SESSION_ID}", // thanks page => redirect her after success
        ]);
        return $this->ApiResponse(200, 'Done', null,  $session->url);
    }

    public function successCheckout($request)
    {
        // TODO: Implement successCheckout() method.
        dump('Thanks page');
        dd($request->all());
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $sessionId = $request->get('session_id');
        $session = \Stripe\Checkout\Session::retrieve($sessionId);
        $transaction_id = $session->metadata->transaction_id;
        $user = Auth::user();
        $payment_status = $session->payment_status;
    }

    public function invoicePaymentSucceeded($request)
    {
        // TODO: Implement invoicePaymentSucceeded() method.
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        $payment_intent_id = $request['data']['object']['id'];
        $amountPaid = $request['data']['object']['amount_received'];
        // $attemptCount = $request['data']['object']['attempt_count'];

        // $billingReason = $request['data']['object']['billing_reason'];
        // $customer_id = $request['data']['object']['customer'];
        $chargeId =  $request['data']['object']['latest_charge'];
        // $discount = $request['data']['object']['discount']; // array or null
        // $hosted_invoice_url = $request['data']['object']['hosted_invoice_url'];
        // $invoice_pdf = $request['data']['object']['invoice_pdf'];
        $transaction_id = $request['data']['object']['metadata']['transaction_id'];
        $user_id = $request['data']['object']['metadata']['user_id'];
        $paymentable_type = $request['data']['object']['metadata']['paymentable_type'];
        $paymentable_id = $request['data']['object']['metadata']['paymentable_id'];
        // $start_date = $request['data']['object']['period']['start'];
        // $end_date = $request['data']['object']['period']['end'];

        // $subscriptionId = $request['data']['object']['subscription'];
        // $number = $request['data']['object']['number'];
        $payment_method_id = $request['data']['object']['payment_method'];
        $statusName = $request['data']['object']['status'];

        if($statusName == "succeeded") {
            $status = 1;
        }else {
            $status = 0;
        }
        $subtotal = $request['data']['object']['amount'];
        // $sub  = $stripe->subscriptions->retrieve($subscriptionId);

        $paymentMethodObject = $stripe->paymentMethods->retrieve($payment_method_id);
        $type                = $paymentMethodObject->type;
        $sub_type            = $paymentMethodObject->card->brand;

        $charge = $stripe->charges->retrieve($chargeId);

        $payment = Payment::create([
            'user_id' => $user_id,
            'status'  => $status,
            'sub_total'  => $subtotal,
            'total'  => $amountPaid,
            'charge_id'  => $chargeId,
            'payment_intent_id' => $payment_intent_id,
            'response_message' => $charge['outcome']['seller_message'],
            'type' => $type,
            'sub_type' => $sub_type,
            'transaction_id' => $transaction_id,
            'transaction_number' => $request['id'],
            'paymentable_type'    => $paymentable_type,
            'paymentable_id' => $paymentable_id
        ]);

//        $payment = Payment::create([
//            'user_id' => 'dd',
//            'status'  => 'dd',
//            'sub_total'  => 'dd',
//            'total'  => 'dd',
//            'charge_id'  => 'dd',
//            'payment_intent_id' => 'dd',
//            'response_message' => 'dd',
//            'type' => 'dd',
//            'sub_type' => 'dd',
//            'transaction_id' => 'dd',
//            'transaction_number' => 'dd',
//            'paymentable_type'    => 'dd',
//            'paymentable_id' => 'dd'
//        ]);
        // send email invoice here

        // $subscription = Subscription::create([
        //     'user_id' => $user_id,
        //     'payment_id' => $payment->id,
        //     'stripe_subscription_id' => $subscriptionId,
        //     'stripe_customer_id' => $customer_id,
        //     'start_date' => $start_date,
        //     'end_date' => $end_date,
        //     'invoice_id' => $invoiceId,
        //     'attemptCount' => $attemptCount,
        //     'hosted_invoice_url' => $hosted_invoice_url,
        //     'invoice_pdf' => $invoice_pdf,
        //     'number' => $number,
        //     'billingReason' => $billingReason,
        //     'status'        => $sub->status
        // ]);

        // subscription created successfully => send email to user and give him access to the plan
    }

    public function invoicePaymentFailed($request)
    {
        // TODO: Implement invoicePaymentFailed() method.
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));

        $payment_intent_id = $request['data']['object']['id'];
        $amountPaid = $request['data']['object']['amount_received'];
        // $attemptCount = $request['data']['object']['attempt_count'];

        // $billingReason = $request['data']['object']['billing_reason'];
        // $customer_id = $request['data']['object']['customer'];
        $chargeId =  $request['data']['object']['latest_charge'];
        // $discount = $request['data']['object']['discount']; // array or null
        // $hosted_invoice_url = $request['data']['object']['hosted_invoice_url'];
        // $invoice_pdf = $request['data']['object']['invoice_pdf'];
        $transaction_id = $request['data']['object']['metadata']['transaction_id'];
        $user_id = $request['data']['object']['metadata']['user_id'];
        $paymentable_type = $request['data']['object']['metadata']['paymentable_type'];
        $paymentable_id = $request['data']['object']['metadata']['paymentable_id'];

        // $start_date = $request['data']['object']['period']['start'];
        // $end_date = $request['data']['object']['period']['end'];

        // $subscriptionId = $request['data']['object']['subscription'];
        // $number = $request['data']['object']['number'];
        $payment_method_id = $request['data']['object']['last_payment_error']['payment_method']['id'];
        $statusName = $request['data']['object']['status'];

        if($statusName == "succeeded") {
            $status = 1;
        }else {
            $status = 0;
        }
        $subtotal = $request['data']['object']['amount'];
        // $sub  = $stripe->subscriptions->retrieve($subscriptionId);

        $paymentMethodObject = $stripe->paymentMethods->retrieve($payment_method_id);
        $type                = $paymentMethodObject->type;
        $sub_type            = $paymentMethodObject->card->brand;

        $charge = $stripe->charges->retrieve($chargeId);

        $payment = Payment::create([
            'user_id' => $user_id,
            'status'  => $status,
            'sub_total'  => $subtotal,
            'total'  => $amountPaid,
            'charge_id'  => $chargeId,
            'payment_intent_id' => $payment_intent_id,
            'response_message' => $charge['outcome']['seller_message'],
            'type' => $type,
            'sub_type' => $sub_type,
            'transaction_id' => $transaction_id,
            'transaction_number' => $request['id'],
            'paymentable_type'    => $paymentable_type,
            'paymentable_id' => $paymentable_id
        ]);

        // $user
        // faild email

    }

    public function thankspage(){
        return view('welcome');
    }
}
