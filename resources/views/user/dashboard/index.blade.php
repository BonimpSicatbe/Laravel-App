<x-app-layout>
    <x-app-header>Dashboard</x-app-header>

    {{-- overview section --}}
    <x-container-section>
        <div class="text-lg font-bold">Overview</div>

        <div class="flex w-full flex-row justify-between overflow-y-auto gap-2">
            @include('user.dashboard.partials.dashboard-overview')
        </div>
    </x-container-section>

    {{-- notification and progress section --}}
    <!--
    <div class="flex flex-row gap-4 container mx-auto sm:px-6 lg:px-8">
        {{-- notification section --}}
        <x-container-section :withPadding="false">
            <div class="text-lg font-bold">Notifications</div>
            <div class="overflow-y-auto h-[250px]">
                @include('user.notifications.partials.notification-lists', [
                    'notifications' => $notifications,
                ])
            </div>
        </x-container-section>

        {{-- progress section --}}
        <x-container-section :withPadding="false">
            <div class="text-lg font-bold">Progress</div>
            <div class="overflow-y-auto h-[250px]"></div>
        </x-container-section>
    </div>
    -->

    {{-- pending tasks section --}}
    <x-container-section>
        <div class="text-lg font-bold">Pendings</div>
        <div class="flex flex-row items-center overflow-auto max-w-full gap-4">
            @include('user.dashboard.partials.pending-tasks-section', ['requirements' => $requirements])
        </div>
    </x-container-section>

    {{-- recents section --}}
    <x-container-section>
        <div class="text-lg font-bold">Recents</div>
    </x-container-section>
</x-app-layout>
