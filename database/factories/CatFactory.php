<?php

namespace Database\Factories;

use App\Models\Cat;
use Illuminate\Database\Eloquent\Factories\Factory;


class CatFactory extends Factory
{
    protected $model = Cat::class;

    public function definition(): array
    {
        return [
            'name'      => $this->faker->firstName(),
            'gender'    => $this->faker->randomElement(['male', 'female']),
            'age'       => $this->faker->numberBetween(0, 15),
            'mother_id' => null,
        ];
    }
}
