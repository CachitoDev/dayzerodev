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

    public function coordinates1()
    {
        return $this->state(function (array $attributes) {
            return [
                'latitude' => 20.522425021497472,
                'longitude' => -100.81402159537812,
            ];
        });
    }

    public function coordinates2()
    {
        return $this->state(function (array $attributes) {
            return [
                'latitude' => 20.5358082801794,
                'longitude' => -100.8182487566445,
            ];
        });
    }


    public function coordinates3()
    {
        return $this->state(function (array $attributes) {
            return [
                'latitude' => 20.519169457293057,
                'longitude' => -100.8291063384944,
            ];
        });
    }

    public function coordinates4()
    {
        return $this->state(function (array $attributes) {
            return [
                'latitude' =>  20.54760306466664,
                'longitude' => -100.81325984849376,
            ];
        });
    }

    public function coordinates5()
    {
        return $this->state(function (array $attributes) {
            return [
                'latitude' => 20.532733851583885,
                'longitude' => -100.82710004632061
            ];
        });
    }
}
