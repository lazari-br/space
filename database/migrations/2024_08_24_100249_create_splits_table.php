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
        Schema::create('splits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bet_table_id');
            $table->unsignedBigInteger('payer_account_id');
            $table->unsignedBigInteger('receiver_account_id');
            $table->unsignedBigInteger('operation_id');
            $table->integer('value');

            $table->foreign('bet_table_id')->references('id')->on('bet_tables');
            $table->foreign('payer_account_id')->references('id')->on('accounts');
            $table->foreign('receiver_account_id')->references('id')->on('accounts');
            $table->foreign('operation_id')->references('id')->on('operations');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('splits');
    }
};
