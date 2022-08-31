<form class="flex flex-col gap-4">
    @csrf

    <x-textarea name="comment" placeholder="Give your feedback on this idea..." :required="true" />

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <x-input-file
            id="reply-attachment"
            class="flex-1"
            name="attachment"
        />

        <x-submit-button class="flex-1">Submit</x-submit-button>
    </div>
</form>
