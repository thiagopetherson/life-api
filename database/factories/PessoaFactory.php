<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
// Helper
use App\Helpers\PessoaHelper;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pessoa>
 */
class PessoaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nome' => $this->faker->name(),
            'cpf' => PessoaHelper::gerarCpfValido(),
            'email' => $this->faker->freeEmail(),
            'data_nasc' => $this->faker->date($format = 'Y-m-d', $max = '2005-12-31'),
            'nacionalidade' => $this->faker->country()
        ];
    }
}
