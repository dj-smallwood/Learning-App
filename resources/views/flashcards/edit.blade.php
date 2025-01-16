<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-custom p-6 rounded-lg">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-custom">Edit Flashcard</h2>
                    <div class="flex space-x-4">
                        <a href="{{ route('flashcards.show', $flashcard->subject_id) }}" 
                           class="text-secondary hover:underline">
                            &larr; Back to Flashcards
                        </a>
                        
                        <!-- Add Delete Button/Form -->
                        <form method="POST" 
                              action="{{ route('flashcards.destroy', $flashcard) }}" 
                              class="inline">
                            @csrf
                            @method('DELETE')
                            <x-danger-button type="submit" 
                                             onclick="return confirm('Are you sure you want to delete this flashcard? This action cannot be undone.')">
                                Delete Flashcard
                            </x-danger-button>
                        </form>
                    </div>
                </div>

                <form method="POST" action="{{ route('flashcards.update', $flashcard) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="term" value="Term" />
                        <x-text-input id="term" 
                                     name="term" 
                                     type="text" 
                                     class="mt-1 block w-full"
                                     :value="old('term', $flashcard->term)"
                                     required />
                        <x-input-error :messages="$errors->get('term')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="content" value="Content" />
                        <textarea id="content"
                                 name="content"
                                 class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                 rows="6"
                                 required>{{ old('content', $flashcard->content) }}</textarea>
                        <x-input-error :messages="$errors->get('content')" class="mt-2" />
                    </div>

                    <div class="flex justify-end">
                        <x-secondary-button type="button" 
                                          onclick="window.location='{{ route('flashcards.show', $flashcard->subject_id) }}'"
                                          class="mr-3">
                            Cancel
                        </x-secondary-button>
                        <x-primary-button>
                            Update Flashcard
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout> 