<?php
namespace App\Http\Interfaces;


interface StripeInterface {


    public function authentication();

//    public function generateIframeModel($request);
    public function generateIframeModel($request);

    public function successCheckout($request);
    public function invoicePaymentSucceeded($request);

    public function invoicePaymentFailed($request);

    public function thankspage();

}
