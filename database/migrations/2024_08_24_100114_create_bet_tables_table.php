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
        Schema::create('bet_tables', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('franchisee_user_id');
            $table->integer('bet_value');
            $table->boolean('has_won')->default(false);
            $table->unsignedBigInteger('winner_account_id')->nullable();

            $table->foreign('franchisee_user_id')->references('id')->on('users');
            $table->foreign('winner_account_id')->references('id')->on('accounts');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bet_tables');
    }
};
