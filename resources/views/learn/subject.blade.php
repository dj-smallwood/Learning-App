<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-custom p-6 rounded-lg">
                <div 
                    x-data="flashcard"
                    data-flashcards="{{ json_encode($flashcards) }}"
                    data-points="{{ auth()->user()->points }}"
                    data-completed="{{ json_encode(auth()->user()->completedFlashcards->pluck('id')) }}"
                    x-init="init()"
                >
                    <div class="mb-6 flex justify-between items-center">
                        <div>
                            <a href="{{ route('learn.index') }}" class="text-secondary hover:underline">&larr; Back to Subjects</a>
                            <h2 class="text-2xl font-bold text-custom mt-2">{{ $subject->name }}</h2>
                        </div>
                        <div class="text-gray-600" x-text="'Card ' + (currentCard + 1) + ' of ' + totalCards"></div>
                    </div>

                    <!-- Points display -->
                    <div class="text-right mb-4">
                        <span class="text-primary font-bold">Points: </span>
                        <span x-text="userPoints"></span>
                    </div>

                    <!-- Flashcard -->
                    <div class="flex justify-center mb-8">
                        <div 
                            @click="flipCard"
                            class="w-full max-w-2xl aspect-video bg-white rounded-xl shadow-lg cursor-pointer transform transition-transform duration-700 preserve-3d"
                            :class="{ 'rotate-y-180': isFlipped }"
                        >
                            <!-- Front of card -->
                            <div 
                                class="absolute w-full h-full backface-hidden flex items-center justify-center p-8"
                                :class="{ 'invisible': isFlipped }"
                            >
                                <h3 class="text-2xl font-bold text-center" x-text="flashcards[currentCard].term"></h3>
                            </div>
                            
                            <!-- Back of card -->
                            <div 
                                class="absolute w-full h-full backface-hidden rotate-y-180 flex items-center justify-center p-8"
                                :class="{ 'invisible': !isFlipped }"
                            >
                                <p class="text-lg text-center" x-text="flashcards[currentCard].content"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation buttons -->
                    <div class="flex justify-center space-x-4">
                        <button 
                            @click="previousCard"
                            :disabled="currentCard === 0"
                            class="px-4 py-2 bg-secondary text-white rounded-lg disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            Previous
                        </button>
                        <button 
                            @click="markComplete"
                            :disabled="isCurrentCardCompleted()"
                            :class="{ 'opacity-50 cursor-not-allowed': isCurrentCardCompleted() }"
                            class="px-4 py-2 bg-green-500 text-white rounded-lg"
                        >
                            <span x-show="!isCurrentCardCompleted()">Mark Complete (+10pts)</span>
                            <span x-show="isCurrentCardCompleted()">Completed ✓</span>
                        </button>
                        <button 
                            @click="nextCard"
                            :disabled="currentCard === flashcards.length - 1"
                            class="px-4 py-2 bg-primary text-white rounded-lg disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            Next
                        </button>
                    </div>

                    <!-- Instructions -->
                    <div class="text-center mt-6 text-gray-600">
                        Click the card to flip it and reveal the answer
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .preserve-3d { transform-style: preserve-3d; }
        .backface-hidden { backface-visibility: hidden; }
        .rotate-y-180 { transform: rotateY(180deg); }
    </style>
    @endpush
</x-app-layout> 