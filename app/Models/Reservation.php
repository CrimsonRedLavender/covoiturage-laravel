<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment',
        'trip_id',
        'user_id',
    ];


    public $timestamps = false;

    public function user (): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function trip(): HasOne {
        return $this->hasOne(Trip::class);
    }
}
