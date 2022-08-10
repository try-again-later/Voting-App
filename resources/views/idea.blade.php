<x-app-layout>
    <a href="/" class="text-lg font-bold hover:underline flex items-center gap-2 mb-4">
        <x-icon.chevron-left class="w-4 h-4" />
        <span>Back to all ideas</span>
    </a>

    <x-ideas.card
        title="Some title"
        description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint, suscipit nulla officiis quasi voluptatibus ab animi cumque repudiandae sed ipsum, aliquid voluptatum nisi quo neque optio alias inventore nostrum omnis quas. Facilis deleniti atque ratione obcaecati fugiat voluptatum error iste laborum ea optio similique magnam qui unde nobis, eum harum neque soluta culpa facere autem inventore assumenda accusantium. Ullam pariatur ipsum voluptas, et cupiditate impedit minus quo, distinctio aut voluptatem cumque vel alias harum fugiat aperiam perspiciatis nisi atque commodi accusamus molestiae dolorem sunt iusto. Numquam nam itaque cum, facilis veniam ipsa nulla doloribus quam provident atque id ut quia nostrum in corporis voluptatibus. Magnam sint illo id non, similique quasi repudiandae nobis in qui dicta iusto distinctio esse cupiditate. Exercitationem natus quod delectus? Nostrum eos dolorem temporibus vitae doloribus cum distinctio voluptates voluptatum soluta at ipsam praesentium iure eligendi, unde deleniti? Illum at facilis ex iste nihil doloremque maxime est molestias officiis, amet eius dolorem doloribus harum illo soluta obcaecati, velit odio adipisci nam commodi ipsa ipsam vel asperiores omnis. Assumenda, quaerat enim. Cupiditate modi tenetur sint amet labore optio voluptas accusantium, fugit, neque unde consequatur? Animi, nihil hic in officiis nemo odio aliquid, nulla cupiditate eaque rem magni."
        category="Some category" :votesCount="12" :voted="true" :commentsCount="6"
        status="in-progress" href="#" time="20 hours ago" datetime="2022-08-07" author="John Doe"
    />
</x-app-layout>
