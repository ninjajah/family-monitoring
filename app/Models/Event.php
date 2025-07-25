<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_type_id',
        'family_type_id',
        'children_affected',
        'biological_children',
        'foster_children',
        'disabled_children',
        'disabled_adults',
        'children_in_family',
        'children_in_institution',
        'notes',
        'user_id',
    ];

    protected static function booted()
    {
        static::saving(function ($event) {
            $event->children_affected = $event->biological_children + $event->foster_children;

            if ($event->children_affected <= 0) {
                throw ValidationException::withMessages([
                    'biological_children' => ['Хотя бы одно поле с количеством детей должно быть больше нуля'],
                ]);
            }
        });
    }

    public function eventType()
    {
        return $this->belongsTo(EventType::class);
    }

    public function familyType()
    {
        return $this->belongsTo(FamilyType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
