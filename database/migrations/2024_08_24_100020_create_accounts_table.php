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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('agency');
            $table->string('account');
            $table->string('login');
            $table->string('password');
            $table->string('document');
            $table->decimal('income_rate', 4, 3);
            $table->string('pix_key')->nullable();
            $table->string('pix_type')->nullable();
            $table->string('status');
            $table->dateTime('pix_key_created_at')->nullable();
            $table->dateTime('pix_key_deleted_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
