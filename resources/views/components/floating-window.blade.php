@props([
    'button',
    'window',
])

<div {{ $attributes->class('') }} x-data="{ opened: false }" x-id="['open-button']">
    <button type="button" {{ $button->attributes->class('') }} :data-opens-window="$id('open-button')"
        @@click="
          opened = !opened;
          await $nextTick();
          updateWindowPosition($el, $refs.replyWindow);
      ">
        {{ $button }}
    </button>
    <div
        {{ $window->attributes->class('absolute bg-white p-4 shadow-lg rounded-xl ring-1 ring-gray-300 max-w-[calc(100vw_-_32px)] w-[32rem]') }}
        :id="$id('open-button')"
        x-ref="replyWindow"
        x-cloak
        x-show="opened"
        x-transition
        @@click.outside="if (opened) opened = false;"
    >
        {{ $window }}
    </div>
</div>
