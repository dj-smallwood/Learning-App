@props(['user'])

<div class="flex items-center space-x-2">
    <div class="flex flex-col">
        <span class="text-sm font-medium {{ $user->getLevel()['color'] }}">
            {{ $user->getLevel()['name'] }}
        </span>
        @if($user->getNextLevelPoints())
            <div class="w-24 h-1 bg-gray-200 rounded-full overflow-hidden">
                <div 
                    class="h-full {{ $user->getLevel()['color'] }} bg-opacity-50"
                    style="width: {{ $user->getLevelProgress() }}%"
                ></div>
            </div>
            <span class="text-xs text-gray-500">
                {{ $user->points }}/{{ $user->getNextLevelPoints() }}
            </span>
        @endif
    </div>
</div> 