<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class SuministroFactory extends Factory
{
    public function definition(): array
    {
        $categoriasConProductos = [
            'bebidas' => ['Agua mineral', 'Coca-Cola', 'Vino tinto', 'Cerveza', 'Zumo de naranja'],
            'entrantes' => ['Croquetas', 'Ensaladilla rusa', 'Patatas bravas', 'Aceitunas', 'Pan con tomate'],
            'primeros platos' => ['Sopa de verduras', 'Ensalada mixta', 'Pasta al pesto', 'Arroz a la cubana'],
            'segundos platos' => ['Filete de ternera', 'Pollo al horno', 'Merluza a la romana', 'Hamburguesa'],
            'postres' => ['Tarta de queso', 'Flan', 'Helado de vainilla', 'Fruta variada']
        ];

        $categoria = $this->faker->randomElement(array_keys($categoriasConProductos));
        $nombre = $this->faker->randomElement($categoriasConProductos[$categoria]);

        return [
            'numPedido' => $this->faker->unique()->bothify('PED-####'),
            'nombre' => $nombre,
            'precio' => $this->faker->randomFloat(2, 1, 100),
            'categoria' => $categoria,
            'detalles' => $this->faker->sentence(),
            'ingredientes' => $this->faker->words(5, true),
            'marca' => $this->faker->company(),
            'fechaCaducidad' => $this->faker->dateTimeBetween('now', '+1 year'),
            'fechaAlta' => $this->faker->date(),
            'cantidad' => $this->faker->numberBetween(1, 100),
        ];
    }
}
