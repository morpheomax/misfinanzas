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
        Schema::table('metas', function (Blueprint $table) {
            // Convertir monto y monto_ahorrado a enteros
            $table->integer('monto')->unsigned()->change();
            $table->integer('monto_ahorrado')->unsigned()->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('metas', function (Blueprint $table) {
            // Revertir los cambios a decimal
            $table->decimal('monto', 10, 2)->change();
            $table->decimal('monto_ahorrado', 10, 2)->default(0)->change();
        });
    }
};
