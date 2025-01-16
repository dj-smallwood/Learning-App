<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-custom p-6 rounded-lg">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-custom">{{ $subject->name }}</h2>
                        <p class="text-gray-600">{{ $flashcards->total() }} flashcards</p>
                    </div>
                    <div class="flex space-x-4">
                        <a href="{{ route('flashcards.index') }}" class="text-secondary hover:underline">
                            &larr; Back to Subjects
                        </a>
                        <a 
                            href="{{ route('flashcards.create', ['subject' => $subject->id]) }}"
                            class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-opacity-90"
                        >
                            Add Flashcard
                        </a>
                    </div>
                </div>

                <div class="space-y-4">
                    @foreach($flashcards as $flashcard)
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <div class="flex justify-between">
                                <h3 class="text-lg font-semibold">{{ $flashcard->term }}</h3>
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('flashcards.edit', $flashcard) }}" 
                                       class="text-sm text-blue-600 hover:underline">
                                        Edit
                                    </a>
                                    <form method="POST" 
                                          action="{{ route('flashcards.destroy', $flashcard) }}" 
                                          class="inline"
                                          x-data
                                          @submit.prevent="if (confirm('Are you sure you want to delete this flashcard? This action cannot be undone.')) $el.submit()">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-sm text-red-600 hover:underline cursor-pointer">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="mt-2 text-gray-600">
                                {!! nl2br(e($flashcard->content)) !!}
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $flashcards->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 