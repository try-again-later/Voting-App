<div
    x-data="{
        loadedCommentsIdsRanges: @entangle('loadedCommentsIdsRanges').live,
        commentsChunks: [],
        async loadMoreComments(chunkIndex, count) {
            chunks = [{
                chunkIndex,
                firstId: this.loadedCommentsIdsRanges[chunkIndex].lastId + 1,
                lastId: this.loadedCommentsIdsRanges[chunkIndex].lastId + count,
            }];

            newComments = await $wire.loadMoreComments(chunks);

            for (chunk of newComments) {
                commentsChunk = this.commentsChunks.find((x) => x.chunkIndex === chunk.chunkIndex);

                if (commentsChunk == undefined) {
                    commentsChunk = {
                        chunkIndex: chunk.chunkIndex,
                        comments: [],
                        hiddenCount: this.loadedCommentsIdsRanges[chunk.chunkIndex].hiddenCount,
                    };
                    this.commentsChunks.push(commentsChunk);
                }
                commentsChunk.comments.push(...chunk.comments);
                commentsChunk.hiddenCount = this.loadedCommentsIdsRanges[chunk.chunkIndex].hiddenCount;
            }
        },
        hasMoreComments(chunkIndex) {
            return this.loadedCommentsIdsRanges[chunkIndex].hiddenCount > 0;
        },
    }"
    x-init="
        $wire.loadMoreComments(loadedCommentsIdsRanges).then((newComments) => {
            for (chunk of newComments) {
                commentsChunk = commentsChunks.find((x) => x.chunkIndex === chunk.chunkIndex);

                if (commentsChunk == undefined) {
                    commentsChunk = {
                        chunkIndex: chunk.chunkIndex,
                        comments: [],
                        hiddenCount: loadedCommentsIdsRanges[chunk.chunkIndex].hiddenCount,
                    };
                    commentsChunks.push(commentsChunk);
                }
                commentsChunk.comments.push(...chunk.comments);
                commentsChunk.hiddenCount = loadedCommentsIdsRanges[chunk.chunkIndex].hiddenCount;
            }
        });
    "
    @@created:comment="
        commentsChunk = commentsChunks.find((x) => x.chunkIndex === $event.detail.chunkIndex);

        if (commentsChunk == undefined) {
            commentsChunk = {
                chunkIndex: $event.detail.chunkIndex,
                comments: [],
                hiddenCount: 0,
            };
            commentsChunks.push(commentsChunk);
        }
        commentsChunk.comments.push($event.detail.comment);
    "
    class="flex flex-col {{ $class }}"
>
    <template
        x-for="commentsChunk in commentsChunks"
        :key="'commentsChunk-' + commentsChunk.chunkIndex"
    >
        <div>
            <div>
                <template
                    x-for="(comment, commentIndex) in commentsChunk.comments"
                    :key="comment.id"
                >
                    <x-ideas.comment />
                </template>
            </div>
            <div
                x-show="commentsChunk.hiddenCount > 0"
                class="max-w-[47rem] sm:ml-[3rem] mt-8 p-4 rounded-xl relative isolate flex justify-center"
            >
                <div class="absolute left-0 right-0 top-1/2 -translate-y-1/2 h-4 text-gray-200 squiggly-line">
                </div>

                <div class="isolate z-10 bg-gray-100 px-4">
                    <div
                        x-text="`${ commentsChunk.hiddenCount } hidden comments`"
                        class="text-center font-bold text-gray-400"
                    ></div>
                    <div class="grid grid-cols-2 gap-2 mx-auto mt-4">
                        <button
                            @@click="loadMoreComments(commentsChunk.chunkIndex, 5)"
                            type="button"
                            class="bg-purple-500 text-white px-4 py-1 rounded-lg transition hover:bg-purple-400 text-center"
                        >
                            Load 5 more...
                        </button>
                        <button
                            @@click="loadMoreComments(commentsChunk.chunkIndex, commentsChunk.hiddenCount)"
                            type="button"
                            class="bg-purple-500 text-white px-4 py-1 rounded-lg transition hover:bg-purple-400 text-center"
                        >
                            Load all...
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>
