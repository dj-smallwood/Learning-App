<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-custom p-6 rounded-lg">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <a href="{{ route('flashcards.index') }}" class="text-secondary hover:underline">&larr; Back to Subjects</a>
                        <div class="flex items-center mt-2">
                            @if($subject->icon)
                                <span class="text-3xl mr-3">{{ $subject->icon }}</span>
                            @endif
                            <h2 class="text-2xl font-bold text-custom">{{ $subject->name }}</h2>
                        </div>
                    </div>
                    <div class="flex space-x-4">
                        <a 
                            href="{{ route('flashcards.create', ['subject' => $subject->id]) }}"
                            class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-opacity-90"
                        >
                            Add Card
                        </a>
                        <a 
                            href="{{ route('learn.subject', $subject) }}"
                            class="px-4 py-2 bg-secondary text-white rounded-lg hover:bg-opacity-90"
                        >
                            Study Mode
                        </a>
                    </div>
                </div>

                <!-- Flashcards List -->
                <div class="space-y-4">
                    @forelse($flashcards as $flashcard)
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <h3 class="text-xl font-semibold mb-2">{{ $flashcard->term }}</h3>
                                    <p class="text-gray-600">{{ $flashcard->content }}</p>
                                </div>
                                <div class="ml-4 flex space-x-2">
                                    <a 
                                        href="{{ route('flashcards.edit', $flashcard) }}"
                                        class="px-3 py-1 text-sm bg-secondary text-white rounded hover:bg-opacity-90"
                                    >
                                        Edit
                                    </a>
                                    <form action="{{ route('flashcards.destroy', $flashcard) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit" 
                                            class="px-3 py-1 text-sm bg-red-500 text-white rounded hover:bg-opacity-90"
                                            onclick="return confirm('Are you sure you want to delete this flashcard?')"
                                        >
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @if(auth()->user()->completedFlashcards->contains($flashcard))
                                <div class="mt-4 text-sm text-green-600">
                                    ✓ Completed
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-12 text-gray-600">
                            <p class="mb-4">No flashcards created for this subject yet.</p>
                            <a 
                                href="{{ route('flashcards.create', ['subject' => $subject->id]) }}"
                                class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-opacity-90"
                            >
                                Create Your First Flashcard
                            </a>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $flashcards->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 