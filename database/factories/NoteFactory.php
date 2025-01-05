<?php

namespace Database\Factories;

use App\Models\Note;
use App\Models\Etudiant;
use App\Models\EC;
use Illuminate\Database\Eloquent\Factories\Factory;

class NoteFactory extends Factory
{
    protected $model = Note::class;

    public function definition()
    {
        return [
            'etudiant_id' => Etudiant::factory(),  
            'ec_id' => EC::factory(),             
            'note' => $this->faker->numberBetween(0, 20),
            'session' => $this->faker->randomElement(['normale', 'rattrapage']),
            'date_evaluation' => $this->faker->date(),
        ];
    }
}
