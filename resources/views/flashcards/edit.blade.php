<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-custom p-6 rounded-lg">
                <h2 class="text-2xl font-bold text-custom mb-6">Edit Flashcard</h2>

                <form action="{{ route('flashcards.update', $flashcard) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="term" class="block text-custom font-medium mb-2">Term</label>
                        <input type="text" name="term" id="term" class="w-full rounded-lg" value="{{ old('term', $flashcard->term) }}" required>
                        @error('term')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="content" class="block text-custom font-medium mb-2">Content</label>
                        <textarea name="content" id="content" rows="4" class="w-full rounded-lg">{{ old('content', $flashcard->content) }}</textarea>
                        @error('content')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-primary text-white px-4 py-2 rounded-lg">
                            Update Flashcard
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout> 