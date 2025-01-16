<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Welcome & Level Section -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-semibold">Welcome back, {{ auth()->user()->name }}!</h2>
                            <div class="mt-2">
                                <x-user-level :user="auth()->user()" />
                            </div>
                        </div>
                        <div class="flex items-center">
                            <x-level-sprite :level="auth()->user()->getLevel()['name']" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Flashcards Card -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="p-2 bg-primary bg-opacity-10 rounded-lg mr-4">
                                <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900">Flashcards</h3>
                                <p class="text-gray-600">Create and manage your flashcard sets</p>
                            </div>
                        </div>
                        <a href="{{ route('flashcards.index') }}" 
                            class="inline-flex items-center justify-center w-full bg-primary text-white px-4 py-2 rounded-lg hover:bg-opacity-90 transition-colors duration-300"
                        >
                            Go to Flashcards
                        </a>
                    </div>
                </div>

                <!-- Study Mode Card -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="p-2 bg-secondary bg-opacity-10 rounded-lg mr-4">
                                <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900">Study Mode</h3>
                                <p class="text-gray-600">Start learning with your flashcards</p>
                            </div>
                        </div>
                        <a href="{{ route('learn.index') }}" 
                            class="inline-flex items-center justify-center w-full bg-secondary text-white px-4 py-2 rounded-lg hover:bg-opacity-90 transition-colors duration-300"
                        >
                            Start Learning
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stats Section -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Your Progress</h3>
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
                            <h4 class="text-sm font-medium text-gray-600">Next Level</h4>
                            <p class="text-2xl font-bold text-gray-700">
                                {{ auth()->user()->getNextLevelPoints() ? auth()->user()->getNextLevelPoints() - auth()->user()->points . ' points needed' : 'Max Level' }}
                            </p>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <x-danger-button
                            x-data=""
                            @click="$dispatch('open-modal', 'confirm-points-reset')"
                        >
                            Reset Progress
                        </x-danger-button>
                    </div>
                </div>
            </div>

            <!-- Level Progress Section -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Level Progress</h3>
                    <div class="space-y-4">
                        @php
                            $levels = [
                                ['name' => 'Noob', 'min' => 0, 'max' => 250, 'color' => 'bg-gray-400'],
                                ['name' => 'Apprentice', 'min' => 251, 'max' => 1000, 'color' => 'bg-gray-600'],
                                ['name' => 'Adventurer', 'min' => 1001, 'max' => 2000, 'color' => 'bg-green-600'],
                                ['name' => 'Warrior', 'min' => 2001, 'max' => 3500, 'color' => 'bg-blue-600'],
                                ['name' => 'Champion', 'min' => 3501, 'max' => 5500, 'color' => 'bg-yellow-600'],
                                ['name' => 'Legend', 'min' => 5501, 'max' => 10000, 'color' => 'bg-red-600'],
                                ['name' => 'God', 'min' => 10001, 'max' => null, 'color' => 'bg-purple-600'],
                            ];

                            $userPoints = auth()->user()->points;
                            $currentLevel = null;
                            
                            foreach ($levels as $index => $level) {
                                if ($userPoints >= $level['min'] && (!$level['max'] || $userPoints <= $level['max'])) {
                                    $currentLevel = $index;
                                    break;
                                }
                            }
                        @endphp

                        @foreach($levels as $index => $level)
                            <div class="relative">
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="font-medium">{{ $level['name'] }}</span>
                                    <span class="text-gray-500">
                                        {{ number_format($level['min']) }}
                                        @if($level['max'])
                                            - {{ number_format($level['max']) }}
                                        @else
                                            +
                                        @endif
                                        points
                                    </span>
                                </div>
                                <div class="h-4 bg-gray-200 rounded-full overflow-hidden">
                                    @if($index < $currentLevel)
                                        {{-- Completed levels --}}
                                        <div class="h-full w-full {{ $level['color'] }}"></div>
                                    @elseif($index === $currentLevel)
                                        {{-- Current level progress --}}
                                        @php
                                            $progress = 0;
                                            if ($level['max']) {
                                                $progress = (($userPoints - $level['min']) / ($level['max'] - $level['min'])) * 100;
                                            } else {
                                                $progress = 100;
                                            }
                                        @endphp
                                        <div class="h-full {{ $level['color'] }}" style="width: {{ $progress }}%"></div>
                                    @endif
                                </div>
                                @if($index === $currentLevel)
                                    <div class="absolute -right-2 -top-2">
                                        <span class="flex h-4 w-4">
                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-4 w-4 bg-primary"></span>
                                        </span>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-modal name="confirm-points-reset" :show="false">
    <form method="POST" action="{{ route('user.reset-points') }}" class="p-6">
        @csrf

        <h2 class="text-lg font-medium text-gray-900">
            Are you sure you want to reset your progress?
        </h2>

        <p class="mt-3 text-sm text-gray-600">
            This will:
            <ul class="list-disc list-inside mt-2">
                <li>Reset your points to 0</li>
                <li>Remove all completed flashcards</li>
                <li>Reset your level to Noob</li>
            </ul>
            This action cannot be undone.
        </p>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                Cancel
            </x-secondary-button>

            <x-danger-button class="ml-3">
                Yes, Reset Progress
            </x-danger-button>
        </div>
    </form>
</x-modal>
