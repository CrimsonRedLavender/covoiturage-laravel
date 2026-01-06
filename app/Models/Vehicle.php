<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand',
        'model',
        'seats',
        'license_plate',
        'color',
        'user_id',
    ];

    public $timestamps = false;

    public function proposals(): HasMany {
        return $this->hasMany(Proposal::class);
    }

    public function user():  BelongsTo {
        return $this->belongsTo(User::class);
    }
}
