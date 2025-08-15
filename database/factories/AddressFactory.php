<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'street'       => $this->faker->streetName(),
            'neighborhood' => $this->faker->word(),
            'number'       => $this->faker->buildingNumber(),
            'state'        => $this->faker->state(), // Nome completo
            'city'         => $this->faker->city(),
            'active'       => $this->faker->boolean(100) 
        ];
    }
}
