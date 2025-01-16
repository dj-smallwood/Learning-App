<div
    x-data="{ show: false, name: '' }"
    x-on:open-modal.window="show = ($event.detail === name)"
    x-on:close-modal.window="show = false"
    x-on:keydown.escape.window="show = false"
>
    {{ $slot }}
</div> 