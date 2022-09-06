<x-dropdown :wrapperClasses="$class ?? ''">
  <x-slot:trigger>
      <button class="bg-gray-200 rounded-full px-2 hover:bg-gray-300 transition-colors">
          <x-icon.dots-horizontal class="w-6 h-6" />
      </button>
  </x-slot>

  <x-slot:content>
        <div class="flex flex-col rounded-md border-[1px] border-gray-300 shadow-lg">
            {{ $slot }}
        </div>
  </x-slot>
</x-dropdown>
