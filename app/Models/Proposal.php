<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Proposal extends Model
{
    use HasFactory;

    /*
     * https://laravel.com/docs/12.x/eloquent#timestamps
     * By default, Eloquent expects created_at and updated_at
     * columns to exist on your model's corresponding database table.
     * Eloquent will automatically set these column's values when models are created or updated.
     * If you do not want these columns to be automatically managed by Eloquent, you should define a $timestamps
     * property on your model with a value of false.
     */
    public $timestamps = false;

    public function trip (): HasOne {
        return $this->hasOne(Trip::class);
    }

    public function vehicle (): BelongsTo {
        return $this->belongsTo(Vehicle::class);
    }

    public function user () : BelongsTo {
        return $this->belongsTo(User::class);
    }
}
