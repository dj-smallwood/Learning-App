<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-custom">
        <div class="relative min-h-screen">
            <!-- Navigation -->
            <nav class="bg-white shadow-sm">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <h1 class="text-2xl font-bold text-primary">LearnDeck</h1>
                        </div>
                        <div class="flex items-center space-x-4">
                            @auth
                                <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-primary">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-gray-700 hover:text-primary">Login</a>
                                <a href="{{ route('register') }}" 
                                   class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-opacity-90 transition-colors duration-200">
                                    Get Started
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Hero Section -->
            <div class="py-20 bg-gradient-to-b from-white to-gray-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center">
                        <h2 class="text-4xl font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                            Master Any Subject with
                            <span class="text-primary">Interactive Flashcards</span>
                        </h2>
                        <p class="mt-3 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                            Level up your learning journey with our gamified flashcard system. Track progress, earn points, and achieve mastery in any topic.
                        </p>
                        <div class="mt-5 max-w-md mx-auto sm:flex sm:justify-center md:mt-8">
                            @guest
                                <div class="rounded-md shadow">
                                    <a href="{{ route('register') }}"
                                       class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary hover:bg-opacity-90 md:py-4 md:text-lg md:px-10">
                                        Start Learning Now
                                    </a>
                                </div>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>

            <!-- Features Section -->
            <div class="py-16">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                        <!-- Feature 1 -->
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <div class="w-12 h-12 bg-primary bg-opacity-10 rounded-lg flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Level Up System</h3>
                            <p class="text-gray-600">Progress through ranks from Noob to God as you master your subjects.</p>
                        </div>

                        <!-- Feature 2 -->
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <div class="w-12 h-12 bg-secondary bg-opacity-10 rounded-lg flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Study Mode</h3>
                            <p class="text-gray-600">Interactive flashcard review system to optimize your learning experience.</p>
                        </div>

                        <!-- Feature 3 -->
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <div class="w-12 h-12 bg-primary bg-opacity-10 rounded-lg flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Progress Tracking</h3>
                            <p class="text-gray-600">Monitor your learning progress with detailed statistics and achievements.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <footer class="bg-white mt-auto">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <div class="text-center text-gray-500 text-sm">
                        © {{ date('Y') }} LearnDeck. All rights reserved.
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
