<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flashcard extends Model
{
    use HasFactory;

    protected $fillable = ['term', 'content', 'subject_id'];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function completedByUsers()
    {
        return $this->belongsToMany(User::class, 'completed_flashcards')
                    ->withTimestamps();
    }
} 