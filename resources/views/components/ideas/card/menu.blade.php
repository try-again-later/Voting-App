<x-dropdown>
  <x-slot:trigger>
      <button class="bg-gray-100 rounded-full px-2 hover:bg-gray-200 transition-colors">
          <x-icon.dots-horizontal class="w-6 h-6" />
      </button>
  </x-slot>

  <x-slot:content>
        <div class="flex flex-col rounded-md border-[1px] border-gray-300 shadow-lg">
            <x-ideas.card.menu-item :first="true">
                Mark as spam
            </x-ideas.card.menu-item>

            <x-ideas.card.menu-item :last="true">
                Delete post
            </x-ideas.card.menu-item>
      </div>
  </x-slot>
</x-dropdown>
