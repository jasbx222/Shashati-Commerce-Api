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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('merchant')->nullable();
            $table->string('phone')->unique();
            $table->string('password');
            $table->boolean('is_active')->default(true);
         $table->string('otp')->nullable();
            $table->date('phone_verified_at')->nullable();
            $table->boolean('is_confirmed')->default(false);
            $table->integer('verification_code_requests')->default(0);
            $table->date('last_verification_code_sent_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
