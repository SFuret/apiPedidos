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
   public function up()
{
    // Aquí modificas la columna para quitar el DEFAULT CURRENT_DATE
    Schema::table('suministros', function (Blueprint $table) {
        $table->date('fechaAlta')->nullable()->default(null)->change();
    });
}

public function down()
{
    Schema::table('suministros', function (Blueprint $table) {
        $table->date('fechaAlta')->default(DB::raw('CURRENT_DATE'))->change();
    });
}

};
