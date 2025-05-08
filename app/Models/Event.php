<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'user_id'
    ];

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
