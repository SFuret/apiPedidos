<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('suministros', function (Blueprint $table) {
        $table->enum('ubicacion', ['bar', 'cocina'])->default('cocina');
    });
}

public function down()
{
    Schema::table('suministros', function (Blueprint $table) {
        $table->dropColumn('ubicacion');
    });
}
};
