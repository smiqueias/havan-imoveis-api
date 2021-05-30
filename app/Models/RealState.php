<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealState extends Model
{
    protected $table = 'real_state';

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'price',
        'content',
        'slug',
        'bedrooms',
        'bathrooms',
        'property_area',
        'total_property_area',

    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function categories(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Category::class,'real_state_categories');
    }

    public function realStatePhotos(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(RealStatePhoto::class);
    }
}
