<?php

namespace App\Http\Controllers;

use App\Models\Flashcard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FlashcardCompletionController extends Controller
{
    public function store(Flashcard $flashcard)
    {
        $user = auth()->user();
        
        if ($user->completedFlashcards->contains($flashcard)) {
            return response()->json([
                'success' => false,
                'message' => 'You have already completed this flashcard.'
            ]);
        }

        $oldPoints = $user->points;
        
        // Check if the flashcard belongs to the History subject
        $pointsToAdd = $flashcard->subject->name === 'History' ? 25 : 10;
        $user->points += $pointsToAdd;
        $user->save();

        $user->completedFlashcards()->attach($flashcard);

        $levelUp = $user->checkLevelUp($oldPoints);

        return response()->json([
            'success' => true,
            'message' => "Flashcard marked as complete! +{$pointsToAdd} points",
            'new_points' => $user->points,
            'level_up' => $levelUp
        ]);
    }
} 