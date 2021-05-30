<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealStatePhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'photo',
        'is_thumb',
    ];

    public function realState(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(RealState::class);
    }

}
