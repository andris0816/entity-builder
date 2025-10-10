<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
