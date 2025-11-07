<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Relationship extends Model
{
    protected $fillable = [
        'entity_from',
        'entity_to',
        'type',
        'desc',
    ];

    public function entityFrom(): BelongsTo
    {
        return $this->belongsTo(Entity::class);
    }

    public function entityTo(): BelongsTo
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
            'entity_from',
            'world_id'
        );
    }
}
