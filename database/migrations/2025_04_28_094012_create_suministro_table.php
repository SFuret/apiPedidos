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
        Schema::create('suministros', function (Blueprint $table) {
            $table->id(); // id INT AUTO_INCREMENT PRIMARY KEY
            $table->string('numPedido', 50)->unique(); // numPedido VARCHAR(50) NOT NULL UNIQUE
            $table->string('nombre', 100); // nombre VARCHAR(100) NOT NULL
            $table->decimal('precio', 10, 2); // precio DECIMAL(10,2) NOT NULL
            $table->string('categoria', 50)->nullable(); // categoria VARCHAR(50) NULLABLE
            $table->text('detalles')->nullable(); // detalles TEXT NULLABLE
            $table->text('ingredientes')->nullable(); // ingredientes TEXT NULLABLE
            $table->string('marca', 50)->nullable(); // marca VARCHAR(50) NULLABLE
            $table->date('fechaCaducidad')->nullable(); // fechaCaducidad DATE NULLABLE
            $table->date('fechaAlta')->nullable(); // fechaAlta DATE NULLABLE
            $table->integer('cantidad')->nullable(); // cantidad INT NULLABLE
            $table->timestamps(); // created_at y updated_at (si quieres)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suministros');
    }
};
