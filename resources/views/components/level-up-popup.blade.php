<div
    x-data="{ show: false, level: '', color: '' }"
    x-show="show"
    x-on:level-up.window="
        show = true;
        level = $event.detail.level;
        color = $event.detail.color;
        setTimeout(() => show = false, 5000)
    "
    class="fixed top-4 right-4 z-50"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform translate-y-2"
    x-transition:enter-end="opacity-100 transform translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 transform translate-y-0"
    x-transition:leave-end="opacity-0 transform translate-y-2"
    style="display: none;"
>
    <div class="bg-white rounded-lg shadow-xl p-6 max-w-sm">
        <div class="flex items-center space-x-4">
            <div class="flex-shrink-0">
                <svg class="h-12 w-12" fill="currentColor" :class="color" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div>
                <p class="font-bold text-gray-900">Level Up!</p>
                <p class="text-gray-600">You've reached <span x-text="level" :class="color" class="font-semibold"></span> level!</p>
            </div>
        </div>
    </div>
</div> 