<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Answer class
 */
class Answer extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'question_id',
        'text',
        'points',
    ];

    /**
     * @var string[]
     */
    protected $hidden = [
        'question_id',
    ];

    /**
     * @return BelongsTo
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
