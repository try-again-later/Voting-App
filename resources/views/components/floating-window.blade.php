@props([
    'button',
    'window',
])

<div {{ $attributes->class('') }} x-data="{ opened: false, cleanup: null }" x-id="['open-button']">
    <button
        {{ $button->attributes->class('') }}
        type="button"
        :data-opens-window="$id('open-button')"
        @@click="
          opened = !opened;
          await $nextTick();

          if (opened) {
            cleanup = floatingAutoUpdate($el, $refs.floatingWindow, () => {
              updateWindowPosition($el, $refs.floatingWindow);
            });
          } else {
            cleanup();
            cleanup = null;
          }
      ">
        {{ $button }}
    </button>
    <div
        {{ $window->attributes->class('absolute z-50 bg-white p-4 shadow-lg rounded-xl ring-1 ring-gray-300 max-w-[calc(100vw_-_32px)]') }}
        :id="$id('open-button')"
        x-ref="floatingWindow"
        x-cloak
        x-show="opened"
        x-transition
    >
        {{ $window }}
    </div>
</div>
