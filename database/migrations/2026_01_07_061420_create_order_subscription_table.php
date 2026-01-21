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
        Schema::create('order_subscription', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('subscription_id');
            $table->timestamps();
            
            $table->primary(['order_id', 'subscription_id']);
            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('subscription_id')->references('subscription_id')->on('subscriptions')->onDelete('cascade')->onUpdate('cascade');
            $table->index('order_id');
            $table->index('subscription_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_subscription');
    }
};
