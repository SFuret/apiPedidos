<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('suministros', function (Blueprint $table) {
            $table->dropColumn('fechaAlta'); // Elimina la columna fechaAlta si existe
            $table->date('fechaCaducidad')->nullable()->change(); // Asegura que sea tipo DATE y nullable
        });
    }

     public function down(): void
    {
        Schema::table('suministros', function (Blueprint $table) {
            $table->date('fechaAlta')->nullable(); // Restaura la columna fechaAlta
        });
    }
};

