<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, Prunable, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

class Question extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Prunable;

    protected $casts = [
        'draft' => 'bool',
    ];
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }
    public function prunable()
    {
        return static::where('deleted_at', '<=', now()->subMonth());
    }
}
