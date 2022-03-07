<?php

namespace Database\Factories;

use App\Enums\PropertyFieldName;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PropertyField>
 */
class PropertyFieldFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = $this->faker->unique()->randomElement(PropertyFieldName::getValues());

        return [
            'name' => $name,
            'value' => $this->fieldValue($name),
        ];
    }

    private function fieldValue($name)
    {
        return match ($name) {
            PropertyFieldName::Area => $this->faker->boolean(60) ? $this->faker->randomFloat(2, 10, 1000) : null,
            PropertyFieldName::YearOfConstruction => $this->faker->boolean(15) ? $this->faker->year() : null,
            PropertyFieldName::Rooms =>  $this->faker->boolean(30) ? $this->faker->numberBetween(1, 8) : null,
            PropertyFieldName::HeatingType =>  $this->faker->boolean(20) ? $this->faker->randomElement(['gas', 'electric']) : null,
            PropertyFieldName::Parking =>  $this->faker->boolean(20) ? $this->faker->boolean(30) : null,
            PropertyFieldName::ReturnActual =>  $this->faker->boolean(8) ? $this->faker->randomFloat(1, 0, 50) : null,
            PropertyFieldName::Price =>  $this->faker->boolean(75) ? $this->faker->randomFloat(2, 10000, 1000000) : null,
            default => null,
        };
    }
}
