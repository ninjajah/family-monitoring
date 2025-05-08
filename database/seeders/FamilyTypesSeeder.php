<?php

namespace Database\Seeders;

use App\Models\FamilyType;
use Illuminate\Database\Seeder;

class FamilyTypesSeeder extends Seeder
{
    public function run()
    {
        $types = [
            ['name' => 'Кровная', 'description' => 'Биологическая семья', 'user_id' => 1],
            ['name' => 'Замещающая', 'description' => 'Приемная семья', 'user_id' => 1],
            ['name' => 'Родственная опека', 'description' => 'Опека родственниками', 'user_id' => 1],
            ['name' => 'Временная ресурсная', 'description' => 'Временное размещение', 'user_id' => 1],
        ];

        foreach ($types as $type) {
            FamilyType::create($type);
        }
    }
}
