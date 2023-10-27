<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->string('amount');
            $table->string('timestamp')->nullable();
            $table->string('result')->nullable();
            $table->integer('payment_status')->nullable();
            $table->string('payment_desc')->nullable();
            $table->string('payment_gateway')->nullable();
            $table->json('payment_gateway_data')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
