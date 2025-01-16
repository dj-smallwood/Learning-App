<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Subject;

class UserController extends Controller
{
    public function resetPoints()
    {
        $user = auth()->user();
        
        DB::transaction(function () use ($user) {
            // Reset points to 0
            $user->points = 0;
            $user->save();
            
            // Remove all completed flashcards
            $user->completedFlashcards()->detach();
        });

        return redirect()->back()->with('success', 'Points and progress have been reset successfully.');
    }

    public function resetSubjectProgress(Subject $subject)
    {
        $user = auth()->user();
        
        DB::transaction(function () use ($user, $subject) {
            // Get points to deduct (10 points per completed card, 25 for history)
            $completedCards = $user->completedFlashcards()
                ->where('subject_id', $subject->id)
                ->get();
            
            $pointsToDeduct = $completedCards->sum(function ($flashcard) {
                return $flashcard->subject->name === 'History' ? 25 : 10;
            });
            
            // Update user points
            $user->points = max(0, $user->points - $pointsToDeduct);
            $user->save();
            
            // Remove completed flashcards for this subject
            $user->completedFlashcards()
                ->where('subject_id', $subject->id)
                ->detach();
        });

        return redirect()->back()->with('success', "Progress for {$subject->name} has been reset successfully.");
    }
} 