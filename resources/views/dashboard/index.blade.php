<x-app-layout>
    <x-app-header>Dashboard</x-app-header>

    <x-container-section>
        <div class="text-lg font-bold">Overview</div>

        <div class="flex w-full flex-row justify-between overflow-y-auto gap-2">
            @include('dashboard.partials.dashboard-overview')
        </div>
    </x-container-section>

    <div class="flex flex-row gap-4 container mx-auto sm:px-6 lg:px-8">
        <div class="container mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 w-full space-y-6">
                    <div class="text-lg font-bold">Notifications</div>
                    <div class="overflow-y-auto h-[250px]">
                        @include('notifications.partials.notification-lists', ['notifications' => $notifications])
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

    {{--
        <div class="container mx-auto sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg space-y-2 p-6">
                    <div class="text-lg font-bold">Overview</div>

                    <div class="flex w-full flex-row justify-between overflow-y-auto gap-2">
                        @include('dashboard.partials.dashboard-overview')
                    </div>
                </div>

                <div class="flex flex-row gap-4">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg w-full space-y-2 p-6">
                        <div class="text-lg font-bold">Notifications</div>
                        <div class="overflow-y-auto h-[250px]">
                            @include('notifications.partials.notification-lists', ['notifications' => $notifications])
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg w-full  space-y-2 p-6">
                        <div class="text-lg font-bold">Progress</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg space-y-2 p-6">
                    <div class="text-lg font-bold">Pending Tasks</div>

                    <div class="flex flex-row gap-2 overflow-x-auto">
                        @include('tasks.partials.pending-tasks-lists', ['tasks' => $tasks])
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg space-y-2 p-6">
                    <div class="text-lg font-bold">Recents</div>

                </div>
            </div>
        </div>
    --}}
</x-app-layout>
