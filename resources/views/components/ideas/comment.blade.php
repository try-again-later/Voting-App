<article
    class="
        flex gap-4 p-4 rounded-xl sm:ml-32 relative max-w-2xl ring-2
        before:hidden sm:before:block before:h-1 before:w-16 before:bg-gray-200 before:absolute before:-left-[5rem] before:top-1/2
        after:hidden sm:after:block after:w-1 after:bg-gray-200 after:absolute after:-left-[5rem] after:-bottom-8 after:-top-8
        first:after:-top-4"

    :class="{
        'ring-gray-200 bg-white': comment.new_idea_status == null,
        'ring-status-open bg-gray-50': comment.new_idea_status && comment.new_idea_status.name === 'open',
        'ring-status-in-progress bg-yellow-50': comment.new_idea_status && comment.new_idea_status.name === 'in-progress',
        'ring-status-implemented bg-emerald-50': comment.new_idea_status && comment.new_idea_status.name === 'implemented',
        'ring-status-considering bg-indigo-50': comment.new_idea_status && comment.new_idea_status.name === 'considering',
        'ring-status-closed bg-rose-50': comment.new_idea_status && comment.new_idea_status.name === 'closed',
        'after:bottom-1/2':
            commentsChunk.chunkIndex + 1 === loadedCommentsIdsRanges.length &&
            commentsChunk.hiddenCount === 0 &&
            commentIndex + 1 === commentsChunk.comments.length,
    }"
>
    <div
        x-show="comment.new_idea_status != null"

        class="
            absolute z-10 bg-white shadow-sm rounded-full w-12 h-12 top-1/2 -left-[5rem]
            -translate-y-[1.375rem] -translate-x-[1.375rem]

            before:absolute before:left-1/2 before:top-1/2 before:-translate-x-1/2
            before:-translate-y-1/2 before:z-20 before:w-8 before:h-8 before:rounded-full
        "

        :class="{
            'before:bg-status-open': comment.new_idea_status && comment.new_idea_status.name === 'open',
            'before:bg-status-in-progress': comment.new_idea_status && comment.new_idea_status.name === 'in-progress',
            'before:bg-status-implemented': comment.new_idea_status && comment.new_idea_status.name === 'implemented',
            'before:bg-status-considering': comment.new_idea_status && comment.new_idea_status.name === 'considering',
            'before:bg-status-closed': comment.new_idea_status && comment.new_idea_status.name === 'closed',
        }"
    >
    </div>

    <div class="self-start flex flex-col gap-1 items-center">
        <img
            :src="comment.author.avatar"
            alt="Avatar"
            class="w-16 rounded-xl aspect-square bg-gray-100 grid place-items-center ring-1 ring-gray-200"
        />

        <template x-if="comment.author.is_admin">
            <div class="uppercase text-xs font-bold text-purple-500">Admin</div>
        </template>
    </div>

    <div class="flex flex-col gap-4 w-full">
        <p
            x-show="comment.new_idea_status != null"
            x-text="`Status changed to &quot;${
                comment.new_idea_status == null ? 'Unknown' :
                comment.new_idea_status.name == 'open' ? 'Open' :
                comment.new_idea_status.name == 'in-progress' ? 'In progress' :
                comment.new_idea_status.name == 'implemented' ? 'Implemented' :
                comment.new_idea_status.name == 'considering' ? 'Under Consideration' :
                comment.new_idea_status.name == 'closed' ? 'Closed' : 'Unknown'
            }&quot;`"
            class="text-xl font-semibold"
        ></p>

        <p
            x-show="comment.body != null"
            x-text="comment.body"
        ></p>

        <div class="flex flex-wrap gap-x-4 gap-y-1 items-center mt-auto">
            <div
                class="font-semibold w-full sm:w-auto"
                :class="{
                    'text-purple-500': comment.author.is_admin,
                    'text-gray-700': !comment.author.is_admin,
                }"
                x-text="comment.author.name"
            ></div>
            <time
                :datetime="comment.created_at"
                x-text="comment.created_at_for_humans"
                class="text-gray-400"
            >
            </time>
        </div>
    </div>
</article>
