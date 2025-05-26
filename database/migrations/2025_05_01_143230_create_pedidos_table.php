<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->bigIncrements('noPedido');
            $table->unsignedBigInteger('idMesa')->nullable();
            $table->unsignedBigInteger('idUsuario')->nullable();
            $table->string('estado', 50);
            $table->timestamp('fechaAlta')->useCurrent();
            $table->timestamps();

            $table->foreign('idMesa')->references('id')->on('mesas')->onDelete('set null');
            $table->foreign('idUsuario')->references('id')->on('users')->onDelete('set null');
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
