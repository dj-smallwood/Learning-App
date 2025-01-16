<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Flashcard;

class LearnController extends Controller
{
    public function index()
    {
        $subjects = Subject::withCount(['flashcards', 'flashcards as completed_count' => function ($query) {
            $query->whereHas('completedByUsers', function ($q) {
                $q->where('user_id', auth()->id());
            });
        }])->get();

        return view('learn.index', compact('subjects'));
    }

    public function subject(Subject $subject)
    {
        $flashcards = $subject->flashcards()->inRandomOrder()->get();
        
        if ($flashcards->isEmpty()) {
            return redirect()->route('learn.index')
                ->with('error', 'No flashcards available for this subject.');
        }

        \Log::info('Flashcards:', ['data' => $flashcards->toArray()]);

        return view('learn.subject', [
            'subject' => $subject,
            'flashcards' => $flashcards,
            'totalCards' => $flashcards->count(),
            'completedCount' => auth()->user()->completedFlashcards()
                ->where('subject_id', $subject->id)
                ->count()
        ]);
    }
} 