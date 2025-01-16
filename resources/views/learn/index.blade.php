<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-custom p-6 rounded-lg">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-custom">Study Mode</h2>
                    <a href="{{ route('flashcards.index') }}" class="text-secondary hover:underline">
                        &larr; Back to Flashcards
                    </a>
                </div>

                <!-- Subjects Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($subjects as $index => $subject)
                        <div class="{{ $index % 2 === 0 ? 'bg-white' : 'bg-gray-50' }} rounded-lg shadow-md p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex items-center">
                                    @if($subject->icon)
                                        <span class="text-2xl mr-3">{{ $subject->icon }}</span>
                                    @endif
                                    <div>
                                        <h3 class="text-xl font-semibold">{{ $subject->name }}</h3>
                                        @if($subject->flashcards_count > 0 && $subject->flashcards_count === $subject->completed_count)
                                            <span class="text-sm text-green-600">✓ Completed</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex flex-col items-end">
                                    <span class="text-gray-600 text-sm">{{ $subject->flashcards_count }} cards</span>
                                    @if($subject->flashcards_count > 0)
                                        <span class="text-sm text-gray-500">
                                            {{ $subject->completed_count }}/{{ $subject->flashcards_count }} completed
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                @if($subject->flashcards_count > 0)
                                    <a 
                                        href="{{ route('learn.subject', $subject) }}"
                                        class="w-full inline-flex justify-center items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-opacity-90"
                                    >
                                        @if($subject->flashcards_count === $subject->completed_count)
                                            Review Cards
                                        @else
                                            Continue Learning
                                        @endif
                                    </a>
                                @else
                                    <a 
                                        href="{{ route('flashcards.create', ['subject' => $subject->id]) }}"
                                        class="w-full inline-flex justify-center items-center px-4 py-2 bg-secondary text-white rounded-lg hover:bg-opacity-90"
                                    >
                                        Add Cards
                                    </a>
                                @endif
                            </div>

                            @if($subject->completed_count > 0)
                                <x-subject-reset-button :subject="$subject" />
                            @endif
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12 text-gray-600">
                            <p class="mb-4">No subjects available for study.</p>
                            <a 
                                href="{{ route('flashcards.index') }}"
                                class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-opacity-90"
                            >
                                Create Your First Subject
                            </a>
                        </div>
                    @endforelse
                </div>

                <!-- Study Progress -->
                <div class="mt-8 bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold mb-4">Overall Progress</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-600">Total Points</h4>
                            <p class="text-2xl font-bold text-primary">{{ auth()->user()->points }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-600">Cards Completed</h4>
                            <p class="text-2xl font-bold text-secondary">
                                {{ auth()->user()->completedFlashcards()->count() }}
                            </p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-600">Completion Rate</h4>
                            <p class="text-2xl font-bold text-gray-700">
                                @if($subjects->sum('flashcards_count') > 0)
                                    {{ round(($subjects->sum('completed_count') / $subjects->sum('flashcards_count')) * 100) }}%
                                @else
                                    0%
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 