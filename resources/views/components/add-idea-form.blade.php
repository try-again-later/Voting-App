<form
  method="post"
  x-data="{ attachment: null, errors: {} }"
  @@submit.prevent="
    if ($event.target.elements['category'].value == 'default') {
      errors['category'] = 'Choose a category.';
      return;
    } else {
      errors['category'] = null;
    }
    $event.target.submit();
  "
>
  @csrf

  <input
    name="title"
    type="text"
    placeholder="Your idea"
    class="py-2 px-4 shadow-none bg-gray-100 w-full rounded-xl border-none mb-4"
    required
  />

  <div class="mb-4">
    <select
      name="category"
      class="w-full mb-2 rounded-xl border-none bg-gray-100 text-gray-500 cursor-pointer"
      required
    >
      <option selected disabled value="default">Category</option>
      <option value="some category">Some category</option>
      <option value="some other category">Some other category</option>
    </select>
    <div x-cloak x-show="errors['category'] != null" class="text-red-700 flex flex-wrap gap-1">
      <x-icon.exclamation class="w-4 h-4 self-center" />
      <span x-text="errors['category']" class="text-sm"></span>
    </div>
  </div>

  <textarea
    name="description"
    rows="3"
    class="resize-none w-full border-none bg-gray-100 rounded-xl mb-4"
    placeholder="Describe your idea"
    required
  ></textarea>

  <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <div class="flex-1">
      <label
        for="attachment"
        class="flex items-center justify-center gap-1 px-1 py-2 bg-gray-100 text-sm font-semibold rounded-xl cursor-pointer hover:bg-gray-200 transition-colors"
      >
        <x-icon.paper-clip class="w-6 h-6 text-gray-400" />
        <span>Attach</span>
      </label>
      <input
        type="file"
        name="attachment"
        id="attachment"
        class="sr-only"
        @@change="attachment = $event.target.files[0].name"
        x-ref="attachment"
      />
    </div>

    <button
      type="submit"
      class="min-h-[2.5rem] flex-1 bg-purple-500 hover:bg-purple-400 transition-colors text-white rounded-xl"
    >
      Submit
    </button>
  </div>

  <div
    class="mt-4 flex flex-wrap gap-2 items-center"
    x-cloak
    x-show="attachment != null"
  >
    <button
      type="button"
      class="relative circle-background-hover"
      @@click="$refs.attachment.value = null; attachment = null;"
    >
      <x-icon.x class="w-4 h-4 text-red-700" />
    </button>
    <span>Attached file:</span>
    <span class="text-gray-400 break-words break-all" x-text="attachment"></span>
  </div>
</form>
