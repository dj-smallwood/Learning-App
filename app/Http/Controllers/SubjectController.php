<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

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
} 