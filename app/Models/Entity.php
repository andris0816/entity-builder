<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Entity extends Model
{
    protected $fillable = [
        'name',
        'desc',
        'type',
        'world_id',
    ];

    public function world(): BelongsTo
    {
        return $this->belongsTo(World::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function relationshipsFrom(): HasMany
    {
        return $this->hasMany(Relationship::class, 'entity_from');
    }

    public function relationshipsTo(): HasMany
    {
        return $this->hasMany(Relationship::class, 'entity_to');
    }

    public function relatedEntities()
    {
        return $this->relationshipsFrom->merge($this->relationshipsTo);
    }
}
