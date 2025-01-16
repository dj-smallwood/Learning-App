<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FlashcardController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\LearnController;
use App\Http\Controllers\FlashcardCompletionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/learn', [LearnController::class, 'index'])->name('learn.index');
    Route::get('/learn/{subject}', [LearnController::class, 'subject'])->name('learn.subject');
    Route::post('/flashcards/{flashcard}/complete', [FlashcardCompletionController::class, 'store'])
        ->name('flashcards.complete');
    Route::get('/flashcards', [FlashcardController::class, 'index'])->name('flashcards.index');
    Route::get('/flashcards/create/{subject?}', [FlashcardController::class, 'create'])->name('flashcards.create');
    Route::post('/flashcards', [FlashcardController::class, 'store'])->name('flashcards.store');
    Route::get('/flashcards/{subject}', [FlashcardController::class, 'show'])->name('flashcards.show');
    Route::get('/flashcards/{flashcard}/edit', [FlashcardController::class, 'edit'])->name('flashcards.edit');
    Route::put('/flashcards/{flashcard}', [FlashcardController::class, 'update'])->name('flashcards.update');
    Route::delete('/flashcards/{flashcard}', [FlashcardController::class, 'destroy'])->name('flashcards.destroy');

    Route::post('/reset-points', [UserController::class, 'resetPoints'])->name('user.reset-points');
    Route::post('/reset-subject/{subject}', [UserController::class, 'resetSubjectProgress'])
        ->name('user.reset-subject');
    Route::delete('/subjects/{subject}', [SubjectController::class, 'destroy'])->name('subjects.destroy');
});

Route::post('/subjects', [SubjectController::class, 'store'])->name('subjects.store');

require __DIR__.'/auth.php';
