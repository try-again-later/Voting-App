<x-app-layout>
    <a href="/" class="text-lg font-bold hover:underline inline-flex items-center gap-2 mb-4">
        <x-icon.chevron-left class="w-4 h-4" />
        <span>Back to all ideas</span>
    </a>

    <x-ideas.card
        title="Some title"
        :description="[
            'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sunt adipisci magni, ea architecto, ratione dolores totam at temporibus praesentium maiores officiis eligendi doloribus iusto?',
            'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sunt adipisci magni, ea architecto, ratione dolores totam at temporibus praesentium maiores officiis eligendi doloribus iusto? Nihil doloribus quia amet, adipisci magnam maxime ullam saepe odio aliquid dolores nesciunt quisquam autem blanditiis delectus odit possimus ipsam ratione cum eligendi. Expedita, architecto. Quaerat facilis voluptatum magnam ex ea nihil, ipsum, dignissimos qui totam debitis a, nesciunt pariatur culpa. Tenetur laudantium reprehenderit, et aut, excepturi eveniet quas pariatur explicabo dolorem accusamus minima voluptatem, culpa delectus vitae reiciendis dolores ad exercitationem cumque ex veritatis possimus nobis sed! Ducimus beatae in fuga voluptate laudantium soluta earum?',
            'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sunt adipisci magni, ea architecto, ratione dolores totam at temporibus praesentium maiores officiis eligendi doloribus iusto?',
        ]"
        category="Some category" :votesCount="12" :voted="true" :commentsCount="6"
        status="in-progress" href="#" time="20 hours ago" datetime="2022-08-07" author="John Doe"
    />
</x-app-layout>
