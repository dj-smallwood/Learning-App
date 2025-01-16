<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'icon' => 'nullable|string|max:10'
        ]);

        Subject::create($validated);

        return redirect()->route('flashcards.index')
            ->with('success', 'Subject created successfully.');
    }

    public function destroy(Subject $subject)
    {
        DB::transaction(function () use ($subject) {
            // Get the user and completed flashcards for point deduction
            $user = auth()->user();
            $completedCards = $user->completedFlashcards()
                ->where('subject_id', $subject->id)
                ->count();
            
            // Deduct points (10 points per completed card)
            $pointsToDeduct = $completedCards * 10;
            $user->points = max(0, $user->points - $pointsToDeduct);
            $user->save();

            // Delete the subject (this will cascade delete flashcards due to foreign key)
            $subject->delete();
        });

        return redirect()->route('flashcards.index')
            ->with('success', 'Subject and all associated flashcards have been deleted.');
    }
} 