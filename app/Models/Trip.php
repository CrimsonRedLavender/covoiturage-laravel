<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'available_seats',
    ];

    public $timestamps = false;



    public function stops (): HasMany {
        return $this->hasMany(Stop::class);
    }

    public function reservations (): HasMany {
        return $this->hasMany(Reservation::class);
    }

    public function proposals (): HasOne { // C'est Trip qui "own" la relation avec Proposal
        return $this->hasOne(Proposal::class);
    }
}
