<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TakeAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
       'test_id', 'candidate_id', 'question_id', 'answer_id'
    ];
}
