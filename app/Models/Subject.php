<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'icon'];

    public function flashcards()
    {
        return $this->hasMany(Flashcard::class);
    }

    protected static function boot()
    {
        parent::boot();
        
        // When a subject is deleted, also delete related flashcards
        static::deleting(function ($subject) {
            $subject->flashcards()->delete();
        });
    }
} 