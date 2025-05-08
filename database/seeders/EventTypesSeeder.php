<?php

namespace Database\Seeders;

use App\Models\EventType;
use Illuminate\Database\Seeder;

class EventTypesSeeder extends Seeder
{
    public function run()
    {
        $types = [
            ['name' => 'Семья принята на сопровождение', 'description' => '', 'user_id' => 1],
            ['name' => 'Семья находится на сопровождении', 'description' => '', 'user_id' => 1],
            ['name' => 'Семья снята с сопровождения', 'description' => '', 'user_id' => 1],
        ];

        foreach ($types as $type) {
            EventType::create($type);
        }
    }
}
