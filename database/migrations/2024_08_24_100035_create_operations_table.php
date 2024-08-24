<?php

use App\Models\Operation;
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
        Schema::create('operations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payer_account_id');
            $table->unsignedBigInteger('receiver_account_id');
            $table->string('operation_type');
            $table->integer('value');
            $table->string('status')->default(Operation::PENDING);
            $table->string('pagar_id')->nullable();
            $table->dateTime('updated_by_pagare_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operations');
    }
};
