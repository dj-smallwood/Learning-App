@props(['level'])

@php
$sprites = [
    'Noob' => [
        'color' => '#9CA3AF', // gray-400
        'icon' => 'M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z',
    ],
    'Apprentice' => [
        'color' => '#4B5563', // gray-600
        'icon' => 'M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222',
    ],
    'Adventurer' => [
        'color' => '#059669', // green-600
        'icon' => 'M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3',
    ],
    'Warrior' => [
        'color' => '#2563EB', // blue-600
        'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
    ],
    'Champion' => [
        'color' => '#EAB308', // yellow-600
        'icon' => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z',
    ],
    'Legend' => [
        'color' => '#DC2626', // red-600
        'icon' => 'M13 10V3L4 14h7v7l9-11h-7z',
    ],
    'God' => [
        'color' => '#9333EA', // purple-600
        'icon' => 'M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z',
    ],
];

$currentSprite = $sprites[$level] ?? $sprites['Noob'];
@endphp

<div 
    x-data="{ animate: true }"
    x-init="setInterval(() => animate = !animate, 1000)"
    class="relative w-24 h-24"
>
    <svg 
        xmlns="http://www.w3.org/2000/svg" 
        fill="none" 
        viewBox="0 0 24 24" 
        stroke="currentColor"
        :class="animate ? 'translate-y-0' : 'translate-y-1'"
        class="w-full h-full transition-transform duration-1000"
        style="color: {{ $currentSprite['color'] }}"
    >
        <path 
            stroke-linecap="round" 
            stroke-linejoin="round" 
            stroke-width="2" 
            d="{{ $currentSprite['icon'] }}"
        />
    </svg>
</div> 