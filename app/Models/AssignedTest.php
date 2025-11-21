<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssignedTest extends Model
{
    use HasFactory;
    protected $table = 'assigned_tests';
    protected $fillable = [
        'title', 'question_ids', 'user_id', 'startdatetime'
    ];

    /**
     * Get the user that owns the AssignedTest
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get the user that owns the AssignedTest
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function questions(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'question_ids', 'id');
    }

}
