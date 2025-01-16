@props(['subject'])

<x-danger-button
    x-data=""
    @click="$dispatch('open-modal', 'confirm-subject-delete-{{ $subject->id }}')"
    type="button"
    class="!px-2 !py-1 !text-xs"
>
    Delete Subject
</x-danger-button>

<x-modal name="confirm-subject-delete-{{ $subject->id }}" :show="false">
    <form method="POST" action="{{ route('subjects.destroy', $subject) }}" class="p-6">
        @csrf
        @method('DELETE')

        <h2 class="text-lg font-medium text-gray-900">
            Delete {{ $subject->name }}?
        </h2>

        <p class="mt-3 text-sm text-gray-600">
            This will:
            <ul class="list-disc list-inside mt-2">
                <li>Delete all flashcards in this subject</li>
                <li>Remove completion status for all cards</li>
                <li>Deduct points earned from this subject</li>
                <li>Delete the subject permanently</li>
            </ul>
            This action cannot be undone.
        </p>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                Cancel
            </x-secondary-button>

            <x-danger-button class="ml-3">
                Yes, Delete Subject
            </x-danger-button>
        </div>
    </form>
</x-modal> 