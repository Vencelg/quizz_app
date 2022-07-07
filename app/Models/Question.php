<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Question class
 */
class Question extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'quiz_id',
        'text',
        'has_many_answers'
    ];

    /**
     * @var string[]
     */
    protected $hidden = [
        'quiz_id'
    ];

    /**
     * @return BelongsTo
     */
    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * @return HasMany
     */
    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }
}
