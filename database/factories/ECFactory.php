<?php

namespace Database\Factories;

use App\Models\Ec;
use App\Models\UE;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EC>
 */
class ECFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->regexify('EC\d{2}'), 
            'nom' => $this->faker->words(2, true),
            'coefficient' => $this->faker->numberBetween(1, 5),
            'ue_id' => UE::factory(), 
        ];
    }
}
