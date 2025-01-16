<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-custom p-6 rounded-lg">
                <div class="mb-6">
                    <a href="{{ url()->previous() }}" class="text-secondary hover:underline">&larr; Back</a>
                    <h2 class="text-2xl font-bold text-custom mt-2">Create New Flashcard</h2>
                </div>

                <form method="POST" action="{{ route('flashcards.store') }}" class="space-y-6">
                    @csrf

                    <!-- Subject Selection -->
                    <div>
                        <x-input-label for="subject_id" value="Subject" />
                        @if($selectedSubject)
                            <input type="hidden" name="subject_id" value="{{ $selectedSubject->id }}">
                            <div class="mt-1 flex items-center">
                                @if($selectedSubject->icon)
                                    <span class="text-xl mr-2">{{ $selectedSubject->icon }}</span>
                                @endif
                                <span class="text-gray-700">{{ $selectedSubject->name }}</span>
                            </div>
                        @else
                            <select
                                id="subject_id"
                                name="subject_id"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                required
                            >
                                <option value="">Select a subject</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}" @selected(old('subject_id') == $subject->id)>
                                        {{ $subject->icon ? $subject->icon . ' ' : '' }}{{ $subject->name }}
                                    </option>
                                @endforeach
                            </select>
                        @endif
                        <x-input-error :messages="$errors->get('subject_id')" class="mt-2" />
                    </div>

                    <!-- Term -->
                    <div>
                        <x-input-label for="term" value="Term" />
                        <x-text-input
                            id="term"
                            name="term"
                            type="text"
                            class="mt-1 block w-full"
                            required
                            autofocus
                        />
                        <x-input-error :messages="$errors->get('term')" class="mt-2" />
                    </div>

                    <!-- Content -->
                    <div>
                        <x-input-label for="content" value="Definition" />
                        <textarea
                            id="content"
                            name="content"
                            rows="4"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            required
                        ></textarea>
                        <x-input-error :messages="$errors->get('content')" class="mt-2" />
                    </div>

                    <div class="flex justify-end gap-4">
                        <x-secondary-button type="button" onclick="window.history.back()">
                            Cancel
                        </x-secondary-button>
                        <x-primary-button>
                            Create Flashcard
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout> 