<?php

namespace App\Http\Controllers;

use App\Models\Flashcard;
use App\Models\Subject;
use Illuminate\Http\Request;

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
        $subject_id = $flashcard->subject_id;
        $flashcard->delete();

        return redirect()->route('flashcards.show', ['subject' => $subject_id])
            ->with('success', 'Flashcard deleted successfully.');
    }
} 