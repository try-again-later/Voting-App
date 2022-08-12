<button
    class="fixed bottom-8 right-8 z-50 bg-purple-500 hover:bg-purple-400 hover:scale-110 hover:shadow-lg transition-all rounded-full p-2 shadow-md lg:hidden"
    x-data="{
        shown: false,
        updateShown() {
            if (window.scrollY > 500) this.shown = true; else this.shown = false;
        }
    }"
    x-init="updateShown();"
    x-show="shown"
    x-transition
    x-cloak
    @@click="window.scroll({ top: 0, behavior: 'smooth' })"
    @@scroll.window.passive.debounce.500ms="updateShown"
>
    <span class="sr-only">Scroll to top</span>
    <x-icon.chevron-up class="w-6 h-6 text-white" />
</button>
