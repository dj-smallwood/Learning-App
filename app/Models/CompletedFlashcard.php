<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompletedFlashcard extends Model
{
    protected $fillable = ['user_id', 'flashcard_id'];
} 