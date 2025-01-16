<?php

namespace App\Http\Controllers;

use App\Models\Flashcard;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FlashcardController extends Controller
{
    public function index()
    {
        $subjects = Subject::withCount(['flashcards', 'flashcards as completed_count' => function ($query) {
            $query->whereHas('completedByUsers', function ($q) {
                $q->where('user_id', auth()->id());
            });
        }])->get();
        
        $totalCards = Flashcard::count();

        return view('flashcards.index', compact('subjects', 'totalCards'));
    }

    public function create(Subject $subject = null)
    {
        $subjects = Subject::orderBy('name')->get();
        return view('flashcards.create', [
            'subjects' => $subjects,
            'selectedSubject' => $subject
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'term' => 'required|max:255',
            'content' => 'nullable',
            'subject_id' => 'required|exists:subjects,id'
        ]);

        Flashcard::create($validated);

        return redirect()->route('flashcards.show', ['subject' => $request->subject_id])
            ->with('success', 'Flashcard created successfully.');
    }

    public function show(Subject $subject)
    {
        $flashcards = $subject->flashcards()->paginate(10);
        return view('flashcards.show', [
            'subject' => $subject,
            'flashcards' => $flashcards
        ]);
    }

    public function edit(Flashcard $flashcard)
    {
        return view('flashcards.edit', compact('flashcard'));
    }

    public function update(Request $request, Flashcard $flashcard)
    {
        $validated = $request->validate([
            'term' => 'required|max:255',
            'content' => 'nullable'
        ]);

        $flashcard->update($validated);

        return redirect()->route('flashcards.show', ['subject' => $flashcard->subject_id])
            ->with('success', 'Flashcard updated successfully.');
    }

    public function destroy(Flashcard $flashcard)
    {
        try {
            \Log::info('Delete request received for flashcard: ' . $flashcard->id);
            
            // Store subject_id before deletion
            $subject_id = $flashcard->subject_id;
            
            DB::transaction(function () use ($flashcard) {
                $user = auth()->user();
                
                // Check if the flashcard was completed and deduct points if it was
                if ($user->completedFlashcards->contains($flashcard)) {
                    \Log::info('Deducting points for completed flashcard');
                    $user->points = max(0, $user->points - 10);
                    $user->save();
                    
                    // Remove the completion record
                    $user->completedFlashcards()->detach($flashcard->id);
                }
                
                // Delete the flashcard
                \Log::info('Deleting flashcard');
                $flashcard->delete();
                \Log::info('Flashcard deleted successfully');
            });

            return redirect()->route('flashcards.show', $subject_id)
                ->with('success', 'Flashcard deleted successfully.');
        } catch (\Exception $e) {
            \Log::error('Error deleting flashcard: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            return redirect()->back()
                ->with('error', 'Error deleting flashcard: ' . $e->getMessage());
        }
    }
} 