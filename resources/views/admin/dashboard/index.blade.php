<x-app-layout>
    <x-app-header>Dashboard</x-app-header>

    <x-container-section class="">
        <div class="text-lg font-bold">Overview</div>
        @include('admin.dashboard.partials.dashboard-overview')
    </x-container-section>

    <div class="flex flex-row gap-4 container mx-auto sm:px-6 lg:px-8">
        <x-container-section :withPadding="false">
            <div class="text-lg font-bold">Notifications</div>
            <div class="overflow-y-auto h-[250px]">
                @include('admin.notifications.partials.notification-lists', ['notifications' => $notifications])
            </div>
        </x-container-section>

        <x-container-section :withPadding="false">
            <div class="text-lg font-bold">Progress</div>
            <div class="overflow-y-auto h-[250px]">

            </div>
        </x-container-section>
    </div>

    <x-container-section>
        <div class="text-lg font-bold">Pending Tasks</div>
    </x-container-section>

    <x-container-section>
        <div class="text-lg font-bold">Recents</div>
    </x-container-section>
</x-app-layout>
