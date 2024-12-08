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
        Schema::table('users', function (Blueprint $table) {
            $table->string('country')->nullable(); // País
            $table->string('city')->nullable(); // Ciudad
            $table->boolean('is_premium')->default(false); // Estado premium
            $table->timestamp('subscription_end_date')->nullable(); // Fecha de fin de suscripción
            $table->boolean('is_active')->default(true); // Estado de la cuenta
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['country', 'city', 'is_premium', 'subscription_end_date', 'is_active']);
        });
    }
};
