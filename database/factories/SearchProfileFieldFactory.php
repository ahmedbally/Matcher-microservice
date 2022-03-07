<?php

namespace Database\Factories;

use App\Enums\SearchProfileFieldName;
use App\Enums\SearchProfileFieldType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SearchProfileField>
 */
class SearchProfileFieldFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = $this->faker->unique()->randomElement(SearchProfileFieldName::getValues());
        $isRange = $this->faker->boolean(70) && $this->canHaveRange($name);

        return [
            'name' => $name,
            'type' => $isRange ? SearchProfileFieldType::Range : SearchProfileFieldType::Direct,
            'value' => $minValue = $this->fieldValue($name),
            'max_value' => $isRange ? $this->fieldValue($name, true, $minValue) : null,
        ];
    }

    private function fieldValue($name, $range = false, $minValue = 0)
    {
        return match ($name) {
            SearchProfileFieldName::Area => $this->faker->boolean(60) ? $this->faker->randomFloat(2, $range ? $minValue : 10, 1000) : null,
            SearchProfileFieldName::YearOfConstruction => $this->faker->boolean(15) ? $this->faker->numberBetween($range ? $minValue : 1980, 2022) : null,
            SearchProfileFieldName::Rooms =>  $this->faker->boolean(30) ? $this->faker->numberBetween($range ? $minValue : 1, 8) : null,
            SearchProfileFieldName::HeatingType =>  $this->faker->boolean(20) ? $this->faker->randomElement(['gas', 'electric']) : null,
            SearchProfileFieldName::Parking =>  $this->faker->boolean(20) ? $this->faker->boolean(30) : null,
            SearchProfileFieldName::ReturnActual, SearchProfileFieldName::ReturnPotential =>  $this->faker->boolean(8) ? $this->faker->randomFloat(1, $range ? $minValue : 0, 50) : null,
            SearchProfileFieldName::Price =>  $this->faker->boolean(75) ? $this->faker->randomFloat(2, $range ? $minValue : 10000, 1000000) : null,
            default => null,
        };
    }

    public function canHaveRange($name)
    {
        return match ($name) {
            SearchProfileFieldName::Area,
            SearchProfileFieldName::YearOfConstruction,
            SearchProfileFieldName::Rooms,
            SearchProfileFieldName::ReturnActual,
            SearchProfileFieldName::Price => true,
            default => false,
        };
    }
}
