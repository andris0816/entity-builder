<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Relationship extends Model
{
    protected $fillable = [
        'source', // Source Entity of the relationship
        'target', // Target Entity of the relationship
        'type',
        'desc',
    ];

    public function source(): BelongsTo
    {
        return $this->belongsTo(Entity::class);
    }

    public function target(): BelongsTo
    {
        return $this->belongsTo(Entity::class);
    }

    public function world(): hasOneThrough
    {
        return $this->hasOneThrough(
            World::class,
            Entity::class,
            'id',
            'id',
            'source',
            'world_id'
        );
    }
}
