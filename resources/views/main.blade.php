<x-app-layout>
  <h1 class="sr-only">Voting App</h1>

  <div class="flex flex-col gap-8 lg:flex-row lg:gap-0 lg:items-start">
    <section class="max-w-xs bg-white border-2 border-gray-200 rounded-xl px-4 py-6 m-auto lg:m-0">
      <h2 class="text-center font-semibold text-xl mb-2">Add an idea</h2>
      <p class="text-sm text-center mb-8">
        Let us know what you would like and we'll take a look over!
      </p>
      <x-ideas.add-new-form />
    </section>

    <section class="flex-1 lg:pl-8">
      <h2 class="sr-only">Ideas</h2>

      <div class="flex flex-wrap gap-y-4 justify-center xl:justify-start w-full mb-8">
        <x-ideas.filter-item :active="true" href="#" :first="true">
          All ideas (89)
        </x-ideas.filter-item>
        <x-ideas.filter-item href="#">
          Considering (6)
        </x-ideas.filter-item>
        <x-ideas.filter-item href="#" :last="true">
          In progress (1)
        </x-ideas.filter-item>

        <x-ideas.filter-item class="xl:ml-auto" href="#" :first="true">
          Implemented (10)
        </x-ideas.filter-item>
        <x-ideas.filter-item href="#" :last="true">
          Closed (55)
        </x-ideas.filter-item>
      </div>

      <div class="flex flex-wrap gap-4 mb-8">
        <select
          name="category-filter"
          class="border-none rounded-xl cursor-pointer w-full sm:w-auto"
        >
          <option value="default" selected disabled>Category</option>
          <option value="some-category">Some category</option>
          <option value="some-other-category">Some other category</option>
        </select>

        <select
          name="other-filter"
          class="border-none rounded-xl cursor-pointer w-full sm:w-auto"
        >
          <option value="default" selected disabled>Other filters</option>
          <option value="the-other-filter">The other filter</option>
          <option value="something-else">Something else</option>
        </select>

        <div class="flex flex-1 max-w-xl ml-auto">
          <div class="flex items-center bg-white pl-2 rounded-l-xl">
            <x-icon.search class="w-5 h-5 text-gray-700" />
          </div>
          <input
            type="search"
            name="search"
            placeholder="Find an idea"
            class="border-none rounded-r-xl w-full pl-2"
          />
        </div>
      </div>

      <ul class="flex flex-col gap-4 sm:gap-8">
        <li>
          <x-ideas.preview-card
            title="Some title"
            description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint, suscipit nulla officiis quasi voluptatibus ab animi cumque repudiandae sed ipsum, aliquid voluptatum nisi quo neque optio alias inventore nostrum omnis quas. Facilis deleniti atque ratione obcaecati fugiat voluptatum error iste laborum ea optio similique magnam qui unde nobis, eum harum neque soluta culpa facere autem inventore assumenda accusantium. Ullam pariatur ipsum voluptas, et cupiditate impedit minus quo, distinctio aut voluptatem cumque vel alias harum fugiat aperiam perspiciatis nisi atque commodi accusamus molestiae dolorem sunt iusto. Numquam nam itaque cum, facilis veniam ipsa nulla doloribus quam provident atque id ut quia nostrum in corporis voluptatibus. Magnam sint illo id non, similique quasi repudiandae nobis in qui dicta iusto distinctio esse cupiditate. Exercitationem natus quod delectus? Nostrum eos dolorem temporibus vitae doloribus cum distinctio voluptates voluptatum soluta at ipsam praesentium iure eligendi, unde deleniti? Illum at facilis ex iste nihil doloremque maxime est molestias officiis, amet eius dolorem doloribus harum illo soluta obcaecati, velit odio adipisci nam commodi ipsa ipsam vel asperiores omnis. Assumenda, quaerat enim. Cupiditate modi tenetur sint amet labore optio voluptas accusantium, fugit, neque unde consequatur? Animi, nihil hic in officiis nemo odio aliquid, nulla cupiditate eaque rem magni."
            category="Some category"
            :votesCount="12"
            :voted="true"
            :commentsCount="6"
            status="in-progress"
            href="#"
            time="20 hours ago"
            datetime="2022-08-07"
          />
        </li>
        <li>
          <x-ideas.preview-card
            title="Some other title"
            description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint, suscipit nulla officiis quasi voluptatibus ab animi cumque repudiandae sed ipsum, aliquid voluptatum nisi quo neque optio alias inventore nostrum omnis quas. Facilis deleniti atque ratione obcaecati fugiat voluptatum error iste laborum ea optio similique magnam qui unde nobis, eum harum neque soluta culpa facere autem inventore assumenda accusantium. Ullam pariatur ipsum voluptas, et cupiditate impedit minus quo, distinctio aut voluptatem cumque vel alias harum fugiat aperiam perspiciatis nisi atque commodi accusamus molestiae dolorem sunt iusto. Numquam nam itaque cum, facilis veniam ipsa nulla doloribus quam provident atque id ut quia nostrum in corporis voluptatibus. Magnam sint illo id non, similique quasi repudiandae nobis in qui dicta iusto distinctio esse cupiditate. Exercitationem natus quod delectus? Nostrum eos dolorem temporibus vitae doloribus cum distinctio voluptates voluptatum soluta at ipsam praesentium iure eligendi, unde deleniti? Illum at facilis ex iste nihil doloremque maxime est molestias officiis, amet eius dolorem doloribus harum illo soluta obcaecati, velit odio adipisci nam commodi ipsa ipsam vel asperiores omnis. Assumenda, quaerat enim. Cupiditate modi tenetur sint amet labore optio voluptas accusantium, fugit, neque unde consequatur? Animi, nihil hic in officiis nemo odio aliquid, nulla cupiditate eaque rem magni."
            category="Some other category"
            :votesCount="244"
            :voted="false"
            :commentsCount="44"
            status="open"
            href="#"
            time="20 hours ago"
            datetime="2022-08-07"
          />
        </li>
        <li>
          <x-ideas.preview-card
            title="Some title"
            description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint, suscipit nulla officiis quasi voluptatibus ab animi cumque repudiandae sed ipsum, aliquid voluptatum nisi quo neque optio alias inventore nostrum omnis quas. Facilis deleniti atque ratione obcaecati fugiat voluptatum error iste laborum ea optio similique magnam qui unde nobis, eum harum neque soluta culpa facere autem inventore assumenda accusantium. Ullam pariatur ipsum voluptas, et cupiditate impedit minus quo, distinctio aut voluptatem cumque vel alias harum fugiat aperiam perspiciatis nisi atque commodi accusamus molestiae dolorem sunt iusto. Numquam nam itaque cum, facilis veniam ipsa nulla doloribus quam provident atque id ut quia nostrum in corporis voluptatibus. Magnam sint illo id non, similique quasi repudiandae nobis in qui dicta iusto distinctio esse cupiditate. Exercitationem natus quod delectus? Nostrum eos dolorem temporibus vitae doloribus cum distinctio voluptates voluptatum soluta at ipsam praesentium iure eligendi, unde deleniti? Illum at facilis ex iste nihil doloremque maxime est molestias officiis, amet eius dolorem doloribus harum illo soluta obcaecati, velit odio adipisci nam commodi ipsa ipsam vel asperiores omnis. Assumenda, quaerat enim. Cupiditate modi tenetur sint amet labore optio voluptas accusantium, fugit, neque unde consequatur? Animi, nihil hic in officiis nemo odio aliquid, nulla cupiditate eaque rem magni."
            category="Some category"
            :votesCount="12"
            :voted="true"
            :commentsCount="6"
            status="closed"
            href="#"
            time="20 hours ago"
            datetime="2022-08-07"
          />
        </li>
      </ul>
    </section>
  </div>
</x-app-layout>
