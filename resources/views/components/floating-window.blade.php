@props([
    'button',
    'window',
])

<div
    {{ $attributes->class('') }}
    x-data="{
        opened: false,
        cleanup: null,

        async setOpened(newOpened) {
            this.opened = newOpened;

            if (this.opened) {
                this.cleanup = floatingAutoUpdate($refs.toggleButton, $refs.floatingWindow, () => {
                    updateWindowPosition($refs.toggleButton, $refs.floatingWindow);
                });
            }
        }
    }"
>
    <button
        {{ $button->attributes->class('') }}
        type="button"
        @@click="setOpened(!opened)"
        x-ref="toggleButton"
    >
        {{ $button }}
    </button>
    <div
        {{ $window->attributes->class('absolute z-50 bg-white p-4 shadow-lg rounded-xl ring-1 ring-gray-300 max-w-[calc(100vw_-_32px)]') }}
        x-ref="floatingWindow"
        x-cloak
        x-show="opened"
        x-transition
    >
        {{ $window }}
    </div>
</div>
