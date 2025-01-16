<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-custom p-6 rounded-lg">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-custom">Flashcards by Subject</h2>
                    <div class="flex space-x-4">
                        <a href="{{ route('learn.index') }}" class="px-4 py-2 bg-secondary text-white rounded-lg hover:bg-opacity-90">
                            Study Mode
                        </a>
                        <x-primary-button x-data="" @click="$dispatch('open-modal', 'create-subject')">
                            New Subject
                        </x-primary-button>
                    </div>
                </div>

                <!-- Stats Section -->
                <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6 mb-3">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h4 class="text-lg font-semibold mb-2">Total Points</h4>
                        <p class="text-3xl font-bold text-primary">{{ auth()->user()->points }}</p>
                    </div>
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h4 class="text-lg font-semibold mb-2">Cards Completed</h4>
                        <p class="text-3xl font-bold text-secondary">
                            {{ auth()->user()->completedFlashcards()->count() }}
                        </p>
                    </div>
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h4 class="text-lg font-semibold mb-2">Total Cards</h4>
                        <p class="text-3xl font-bold text-gray-700">{{ $totalCards }}</p>
                    </div>
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
                            
                            <div class="flex justify-between items-center mt-4">
                                <a 
                                    href="{{ route('flashcards.create', ['subject' => $subject->id]) }}" 
                                    class="text-secondary hover:underline"
                                >
                                    Add Cards
                                </a>
                                <div class="flex space-x-2">
                                    <a 
                                        href="{{ route('learn.subject', $subject) }}" 
                                        class="px-3 py-1 bg-secondary text-white text-sm rounded hover:bg-opacity-90"
                                    >
                                        Study
                                    </a>
                                    <a 
                                        href="{{ route('flashcards.show', $subject) }}" 
                                        class="px-3 py-1 bg-primary text-white text-sm rounded hover:bg-opacity-90"
                                    >
                                        View All
                                    </a>
                                    @if($subject->completed_count > 0)
                                        <x-subject-reset-button :subject="$subject" />
                                    @endif
                                    <x-subject-delete-button :subject="$subject" />
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12 text-gray-600">
                            <p class="mb-4">No subjects created yet.</p>
                            <x-primary-button x-data="" @click="$dispatch('open-modal', 'create-subject')">
                                Create Your First Subject
                            </x-primary-button>
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>

    <!-- Create Subject Modal -->
    <x-modal name="create-subject" :show="false">
        <form 
            method="POST" 
            action="{{ route('subjects.store') }}" 
            class="p-6"
            x-data="{ showEmojiPicker: false }"
        >
            @csrf
            <h2 class="text-lg font-medium text-gray-900">
                Create New Subject
            </h2>

            <div class="mt-6">
                <x-input-label for="name" value="Subject Name" />
                <x-text-input
                    id="name"
                    name="name"
                    type="text"
                    class="mt-1 block w-full"
                    required
                />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="icon" value="Icon (emoji)" />
                <div class="mt-1 relative">
                    <x-text-input
                        id="icon"
                        name="icon"
                        type="text"
                        class="block w-full"
                        placeholder="📚"
                        x-ref="iconInput"
                    />
                    <button 
                        type="button"
                        @click="showEmojiPicker = !showEmojiPicker"
                        class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
                    >
                        😊
                    </button>
                </div>
                <div 
                    x-show="showEmojiPicker" 
                    @click.away="showEmojiPicker = false"
                    class="absolute z-50 mt-2 bg-white rounded-lg shadow-lg p-4"
                >
                    <div class="grid grid-cols-8 gap-2">
                        @foreach(['📚', '✏️', '🔢', '🧪', '🌍', '🎨', '🎵', '��', '🏃‍♂️', '🧠', '⭐️', '📝'] as $emoji)
                            <button 
                                type="button"
                                @click="$refs.iconInput.value = '{{ $emoji }}'; showEmojiPicker = false"
                                class="text-2xl hover:bg-gray-100 p-2 rounded"
                            >
                                {{ $emoji }}
                            </button>
                        @endforeach
                    </div>
                </div>
                <p class="mt-1 text-sm text-gray-600">
                    You can use any emoji as an icon (optional)
                </p>
                <x-input-error :messages="$errors->get('icon')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    Cancel
                </x-secondary-button>

                <x-primary-button class="ml-3">
                    Create Subject
                </x-primary-button>
            </div>
        </form>
    </x-modal>
</x-app-layout> 