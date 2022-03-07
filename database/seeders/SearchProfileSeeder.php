<?php

namespace Database\Seeders;

use App\Enums\SearchProfileFieldName;
use App\Models\SearchProfile;
use App\Models\SearchProfileField;
use Faker\Generator;
use Illuminate\Database\Seeder;

class SearchProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 1000; $i++) {
            SearchProfile::factory()
                ->has(SearchProfileField::factory(count(SearchProfileFieldName::getValues())))
                ->create();
            app(Generator::class)->unique(true);
        }
    }
}
