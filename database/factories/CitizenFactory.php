<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Citizen>
 */
class CitizenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'curp' => $this->faker->unique()->regexify('[A-Z]{4}[0-9]{6}[A-Z]{6}[0-9]{2}'),
            'image_path' => $this->faker->imageUrl(),
            'latitude' => $this->faker->randomFloat(7, 20, 21),
            'longitude' => $this->faker->randomFloat(7, -101, -100)
        ];
    }

    public function jardinPrincipal()
    {
        return $this->state(function (array $attributes) {
            return [
                'latitude' => 20.521932631611154,
                'longitude' => -100.81404306296317,
            ];
        });
    }

    public function estadio()
    {
        return $this->state(function (array $attributes) {
            return [
                'latitude' => 20.535366210076916,
                'longitude' => -100.81829172063344,
            ];
        });
    }


    public function parqueFundadores()
    {
        return $this->state(function (array $attributes) {
            return [
                'latitude' => 20.5180943257773,
                'longitude' => -100.82923505131673,
            ];
        });
    }

    public function deportivaNorte()
    {
        return $this->state(function (array $attributes) {
            return [
                'latitude' =>  20.547793960137867,
                'longitude' => -100.81328126296236,
            ];
        });
    }

    public function xochipilli()
    {
        return $this->state(function (array $attributes) {
            return [
                'latitude' => 20.532733851583885,
                'longitude' => -100.82710004632061
            ];
        });
    }
}