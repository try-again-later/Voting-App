<div
    x-data="{
        alerts: [],
        visible: [],
        async addAlert(title) {
            const alert = {
                id: Date.now() + title,
                title,
            };
            this.alerts.push(alert);
            await $nextTick();
            this.showAlert(alert);
        },
        showAlert(alert) {
            this.visible.push(alert);
            alert.timeout = setTimeout(() => {
                this.hideAlert(alert);
            }, 5000);
        },
        hideAlert(alert) {
            clearTimeout(alert.timeout);
            this.visible.splice(this.visible.indexOf(alert), 1);
        },
    }"
    x-init="
        @foreach (session('alerts') ?? [] as $alert)
            addAlert('{{ addslashes($alert['title']) }}');
        @endforeach
    "
    @@create:alert="addAlert($event.detail.title)"
    class="fixed bottom-4 right-4 z-40 max-w-[calc(100vw_-_2rem)] flex flex-col-reverse gap-4"
>
    <template x-for="alert in alerts" :key="alert.id">
        <article
            x-show="visible.includes(alert)"
            x-transition:enter="transition ease-in duration-200"
            x-transition:enter-start="opacity-0 translate-x-8"
            x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition ease-out duration-200"
            x-transition:leave-start="opacity-100 translate-x-8"
            x-transition:leave-end="opacity-0 translate-x-8"

            class="bg-green-50 ring-1 ring-gray-300 shadow-md p-4 rounded-lg grid grid-cols-[repeat(3,_auto)] gap-2 items-center max-w-sm"
        >
            <h3 x-text="alert.title" class="font-semibold text-gray-700 break-words"></h3>

            <button
                @click="hideAlert(alert)"
                class="p-1 rounded-full transition hover:bg-gray-200"
            >
                <x-icon.x class="w-4 h-4 text-gray-400" />
                <span class="sr-only">Close</span>
            </button>

            <x-icon.check-badge class="-order-1 w-8 h-8 text-green-600" />
        </article>
    </template>
</div>
