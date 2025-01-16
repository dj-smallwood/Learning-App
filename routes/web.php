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
    Route::get('/flashcards/create/{subject?}', [FlashcardController::class, 'create'])->name('flashcards.create');
    Route::get('/flashcards/{subject}', [FlashcardController::class, 'show'])->name('flashcards.show');
    Route::resource('flashcards', FlashcardController::class)->except(['show', 'create']);
    Route::post('/reset-points', [UserController::class, 'resetPoints'])->name('user.reset-points');
    Route::post('/reset-subject/{subject}', [UserController::class, 'resetSubjectProgress'])
        ->name('user.reset-subject');
});

Route::post('/subjects', [SubjectController::class, 'store'])->name('subjects.store');

require __DIR__.'/auth.php';
