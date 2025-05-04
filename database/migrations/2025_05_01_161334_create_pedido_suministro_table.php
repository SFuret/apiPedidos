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
        Schema::create('pedido_suministro', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pedido_id')->constrained('pedidos', 'noPedido')->onDelete('cascade');
            $table->foreignId('suministro_id')->constrained('suministros')->onDelete('cascade');

            $table->integer('cantidad')->default(1); // si necesitas registrar cuántos se pidieron
            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedido_suministro');
    }
};
