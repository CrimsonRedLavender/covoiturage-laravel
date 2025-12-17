<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class User extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function vehicles (): HasMany {
        return $this->hasMany(Vehicle::class);
    }
    public function proposals (): HasMany {
        return $this->hasMany(Proposal::class);
    }
    public function reservations (): HasMany {
        return $this->hasMany(Reservation::class);
    }
}
