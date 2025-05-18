<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  /*  public function up(): void
    {
        Schema::table('suministros', function (Blueprint $table) {
          if (Schema::hasColumn('suministros', 'numPedido')) {
           $table->dropColumn('numPedido');
        }
            //  $table->dropColumn('numPedido'); // Eliminar columna
        });

        // Modificar fechaAlta para que tenga valor por defecto
      DB::statement("ALTER TABLE suministros MODIFY fechaAlta DATE DEFAULT CURRENT_DATE");
    }

    /**
     * Reverse the migrations.
     */
  /*  public function down(): void
    {
        Schema::table('suministros', function (Blueprint $table) {
           // $table->string('numPedido', 50)->unique();
            if (Schema::hasColumn('suministros', 'numPedido')) {
         $table->string('numPedido', 50)->unique();
        }
        });

        // Quitar el valor por defecto de fechaAlta
        DB::statement("ALTER TABLE suministros MODIFY fechaAlta DATE NULL");
    }*/
};
