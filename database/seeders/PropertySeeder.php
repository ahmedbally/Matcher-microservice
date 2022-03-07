<?php

namespace Database\Seeders;

use App\Enums\PropertyFieldName;
use App\Models\Property;
use App\Models\PropertyField;
use Faker\Generator;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 20; $i++) {
            Property::factory()
//            ->count(20)
                ->has(PropertyField::factory(count(PropertyFieldName::getValues())))
                ->create();
            app(Generator::class)->unique(true);
        }
    }
}
