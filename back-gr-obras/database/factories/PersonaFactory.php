<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Persona>
 */
class PersonaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'tipo_doc' => $tipo_doc = $this->faker->randomElement(['DNI', 'RUC']),
            'num_doc' => $tipo_doc == 'DNI' ? $this->faker->unique()->numerify('########') : $this->faker->unique()->numerify('###########'),
            'nombres' => $nombres = $this->faker->name(),
            'a_paterno' => $a_paterno = $this->faker->lastName(),
            'a_materno' => $a_materno = $this->faker->lastName(),
            'nombre_completo' => $nombres . ' ' . $a_paterno . ' ' . $a_materno,
            'email' => fake()->safeEmail(),
            'direccion' => $this->faker->address(),
            'celular' => $this->faker->numerify('#########'),
        ];
    }
}
