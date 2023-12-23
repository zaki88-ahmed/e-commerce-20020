<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('status');
            $table->double('sub_total');
            $table->double('total');
            $table->string('charge_id');
            $table->string('payment_intent_id');
            $table->string('response_message');
            $table->string('type');
            $table->string('sub_type');
            $table->string('transaction_id');
            $table->string('transaction_number');
            $table->string('paymentable_type');
            $table->string('paymentable_id');

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
