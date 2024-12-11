<x-app-layout>
    <x-app-header>Dashboard</x-app-header>

    <x-container-section>
        <div class="text-lg font-bold">Overview</div>

        <div class="flex w-full flex-row justify-between overflow-y-auto gap-2">
            @include('user.dashboard.partials.dashboard-overview')
        </div>
    </x-container-section>

    <div class="flex flex-row gap-4 container mx-auto sm:px-6 lg:px-8">
        <div class="container mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 w-full space-y-6">
                    <div class="text-lg font-bold">Notifications</div>
                    <div class="overflow-y-auto h-[250px]">
                        @include('user.notifications.partials.notification-lists', ['notifications' => $notifications])
                    </div>
                </div>
            </div>
        </div>

        <div class="container mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 w-full space-y-6">
                    <div class="text-lg font-bold">Progress</div>
                    <div class="overflow-y-auto h-[250px]">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-container-section class="relative">
        <div class="text-lg font-bold">Pending Tasks</div>
    </x-container-section>

    <x-container-section>
        <div class="text-lg font-bold">Recents</div>
    </x-container-section>
</x-app-layout>
