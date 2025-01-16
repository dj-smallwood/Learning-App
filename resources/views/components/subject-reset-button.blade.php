@props(['subject'])

<x-danger-button
    x-data=""
    @click="$dispatch('open-modal', 'confirm-subject-reset-{{ $subject->id }}')"
    type="button"
    class="!px-2 !py-1 !text-xs"
>
    Reset Progress
</x-danger-button>

<x-modal name="confirm-subject-reset-{{ $subject->id }}" :show="false">
    <form method="POST" action="{{ route('user.reset-subject', $subject) }}" class="p-6">
        @csrf

        <h2 class="text-lg font-medium text-gray-900">
            Reset progress for {{ $subject->name }}?
        </h2>

        <p class="mt-3 text-sm text-gray-600">
            This will:
            <ul class="list-disc list-inside mt-2">
                <li>Remove all completed cards for {{ $subject->name }}</li>
                <li>Deduct points earned from this subject</li>
                <li>Reset progress tracking for this subject</li>
            </ul>
            This action cannot be undone.
        </p>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                Cancel
            </x-secondary-button>

            <x-danger-button class="ml-3">
                Yes, Reset Subject
            </x-danger-button>
        </div>
    </form>
</x-modal> 