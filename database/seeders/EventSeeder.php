<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventType;
use App\Models\FamilyType;
use App\Models\User;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run()
    {
        $eventTypes = EventType::all();
        $familyTypes = FamilyType::all();
        $users = User::all();

        if ($eventTypes->isEmpty() || $familyTypes->isEmpty() || $users->isEmpty()) {
            $this->command->error('Необходимо сначала создать EventTypes, FamilyTypes и Users!');

            return;
        }

        for ($i = 0; $i < 50; $i++) {

            Event::create([
                'event_type_id' => $eventTypes->random()->id,
                'family_type_id' => $familyTypes->random()->id,
                'biological_children' => random_int(1, 5),
                'foster_children' => random_int(0, 3),
                'disabled_children' => random_int(0, 2),
                'disabled_adults' => random_int(0, 2),
                'children_in_family' => random_int(0, 4),
                'children_in_institution' => random_int(0, 2),
                'notes' => random_int(0, 1) ? 'Тестовое примечание '.($i + 1) : null,
                'user_id' => $users->random()->id,
                'created_at' => now()->subDays(random_int(0, 30)),
                'updated_at' => now()->subDays(random_int(0, 30)),
            ]);
        }

        $this->command->info('Создано 50 тестовых событий');
    }
}
