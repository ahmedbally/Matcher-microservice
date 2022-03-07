<?php

namespace Database\Seeders;

use App\Models\PropertyType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            'residential',
            'commercial',
            'industrial',
            'raw land',
            'special use',
        ];
        foreach ($types as $type) {
            PropertyType::create([
                'name' => $type,
            ]);
        }
    }
}
