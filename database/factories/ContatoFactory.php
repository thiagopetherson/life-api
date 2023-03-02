<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

// Importando a Model
use App\Models\Pessoa;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contato>
 */
class ContatoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'telefone' => $this->faker->tollFreePhoneNumber(),
            'pessoa_id' => Pessoa::all()->random()
        ];
    }
}
