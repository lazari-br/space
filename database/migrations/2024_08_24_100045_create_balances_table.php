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
        Schema::create('balances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_id');
            $table->integer('current_balance');
            $table->integer('previous_balance');
            $table->integer('movement');
            $table->unsignedBigInteger('operation_id');

            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('operation_id')->references('id')->on('operations');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('balances');
    }
};
