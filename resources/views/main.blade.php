<x-app-layout>
  <h1 class="sr-only">Voting App</h1>

  <div class="flex flex-col gap-8 lg:flex-row lg:gap-0">
    <section class="max-w-xs bg-white border-2 border-gray-200 rounded-xl px-4 py-6 m-auto">
      <h2 class="text-center font-semibold text-xl mb-2">Add an idea</h2>
      <p class="text-sm text-center mb-8">
        Let us know what you would like and we'll take a look over!
      </p>
      <x-ideas.add-new-form />
    </section>

    <section class="flex-1 px-4">
      <h2 class="sr-only">Ideas</h2>

      <div class="flex flex-wrap gap-y-4 justify-center xl:justify-start w-full">
        <x-ideas.filter-item :active="true" href="#">
          All ideas (89)
        </x-ideas.filter-item>
        <x-ideas.filter-item href="#">
          Considering (6)
        </x-ideas.filter-item>
        <x-ideas.filter-item href="#">
          In progress (1)
        </x-ideas.filter-item>

        <x-ideas.filter-item class="xl:ml-auto" href="#">
          Implemented (10)
        </x-ideas.filter-item>
        <x-ideas.filter-item href="#">
          Closed (55)
        </x-ideas.filter-item>
      </div>
    </section>
  </div>
</x-app-layout>
