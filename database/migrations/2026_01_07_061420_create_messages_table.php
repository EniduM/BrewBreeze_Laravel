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
        Schema::create('messages', function (Blueprint $table) {
            $table->id('message_id');
            $table->foreignId('customer_id')->constrained('customers', 'customer_id')->onDelete('cascade')->onUpdate('cascade');
            $table->string('subject');
            $table->text('description');
            $table->date('date');
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('customer_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
