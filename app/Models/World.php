<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class World extends Model
{
    protected $fillable = [
        'name',
        'desc',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function entities(): HasMany
    {
        return $this->hasMany(Entity::class, 'world_id');
    }

    public function relationships(): HasManyThrough
    {
        return $this->HasManyThrough(
            Relationship::class,
            Entity::class,
            'world_id',
            'entity_from',
            'id',
            'id'
        );
    }
}
