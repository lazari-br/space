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
        Schema::create('pagare_webhook_logs', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->string('model')->nullable();
            $table->integer('model_id')->nullable();
            $table->json('request');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagare_webhook_logs');
    }
};
