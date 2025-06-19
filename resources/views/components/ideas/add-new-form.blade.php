<form method="post" x-data="{ attachment: null, errors: {} }"
    @@submit.prevent="
    if ($event.target.elements['category'].value == 'default') {
      errors['category'] = 'Choose a category.';
      return;
    } else {
      errors['category'] = null;
    }
    $event.target.submit();
  ">
    @csrf

    <input name="title" type="text" placeholder="Your idea"
        class="py-2 px-4 shadow-none bg-gray-100 w-full rounded-xl border-none mb-4" required />

    <div class="mb-4">
        <select name="category" class="w-full rounded-xl border-none bg-gray-100 text-gray-500 cursor-pointer" required>
            <option selected disabled value="default">Category</option>
            <option value="some-category">Some category</option>
            <option value="some-other-category">Some other category</option>
        </select>
        <div x-cloak x-show="errors['category'] != null" class="text-red-700 flex flex-wrap gap-1 mt-2">
            <x-icon.exclamation class="w-4 h-4 self-center" />
            <span x-text="errors['category']" class="text-sm"></span>
        </div>
    </div>

    <x-textarea name="description" :required="true" placeholder="Describe your data" class="mb-4" />

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <x-input-file
            class="flex-1"
            name="attachment"
            @change="attachment = $event.target.files[0].name"
            x-ref="attachment"
        />

        <x-submit-button class="flex-1">Submit</x-submit-button>
    </div>

    <div class="mt-4 flex flex-wrap gap-2 items-center text-sm" x-cloak x-show="attachment != null">
        <button type="button" class="relative circle-background-hover"
            @@click="$refs.attachment.value = null; attachment = null;">
            <x-icon.x class="w-4 h-4 text-red-700" />
        </button>
        <span>Attached file:</span>
        <span class="text-gray-400 break-words break-all" x-text="attachment"></span>
    </div>
</form>
