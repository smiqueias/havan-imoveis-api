<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    public function country(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function cities(): \Illuminate\Database\Eloquent\Relations\HasMany  {
        return $this->hasMany(City::class);
    }

    public function adresses() {
        $this->hasMany(Address::class);
    }
}
