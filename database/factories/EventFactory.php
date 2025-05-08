<?php

namespace Database\Factories;

use App\Models\EventType;
use App\Models\FamilyType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    public function definition()
    {
        return [
            'event_type_id' => EventType::factory(),
            'family_type_id' => FamilyType::factory(),
            'children_affected' => $this->faker->numberBetween(1, 10),
            'biological_children' => $this->faker->numberBetween(0, 5),
            'foster_children' => $this->faker->numberBetween(0, 5),
            'disabled_children' => $this->faker->numberBetween(0, 3),
            'disabled_adults' => $this->faker->numberBetween(0, 2),
            'children_in_family' => $this->faker->numberBetween(0, 8),
            'children_in_institution' => $this->faker->numberBetween(0, 2),
            'notes' => $this->faker->optional()->text(200),
            'user_id' => User::factory(),
        ];
    }
}
