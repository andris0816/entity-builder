<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Entity extends Model
{
    use HasFactory;
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

    public function sourceRelationship(): HasMany
    {
        return $this->hasMany(Relationship::class, 'source');
    }

    public function targetRelationship(): HasMany
    {
        return $this->hasMany(Relationship::class, 'target');
    }

    public function relatedEntities()
    {
        return $this->sourceRelationship->merge($this->targetRelationship);
    }
}
