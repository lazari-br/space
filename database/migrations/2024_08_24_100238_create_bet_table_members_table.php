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
        Schema::create('bet_table_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bet_table_id');
            $table->unsignedBigInteger('account_id');
            $table->decimal('account_income_rate', 4, 3);
            $table->timestamps();

            $table->foreign('bet_table_id')->references('id')->on('bet_tables');
            $table->foreign('account_id')->references('id')->on('accounts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bet_table_members');
    }
};
