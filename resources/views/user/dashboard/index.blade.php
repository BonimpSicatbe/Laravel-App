<x-app-layout>
    <x-app-header>Dashboard</x-app-header>

    <x-container-section>
        <div class="text-lg font-bold">Overview</div>

        <div class="flex w-full flex-row justify-between overflow-y-auto gap-2">
            @include('user.dashboard.partials.dashboard-overview')
        </div>
    </x-container-section>

    <div class="flex flex-row gap-4 container mx-auto sm:px-6 lg:px-8">
        <x-container-section :withPadding="false">
            <div class="text-lg font-bold">Notifications</div>
            <div class="overflow-y-auto h-[250px]">
                @include('user.notifications.partials.notification-lists', ['notifications' => $notifications])
            </div>
        </x-container-section>

        <x-container-section :withPadding="false">
            <div class="text-lg font-bold">Progress</div>
            <div class="overflow-y-auto h-[250px]"></div>
        </x-container-section>
    </div>

    <x-container-section class="relative">
        <div class="text-lg font-bold">Pending Tasks</div>
        @if($tasks->isEmpty())
            <div class="flex flex-row items-center gap-4">
                <div class="skeleton h-16 w-16 shrink-0 rounded-full"></div>
                <div class="flex flex-col gap-4 w-full">
                    <div class="skeleton h-4 w-2/3"></div>
                    <div class="skeleton h-4 w-full"></div>
                </div>
            </div>
        @else
            @foreach($tasks as $task)
                {{--card--}}
                <div class="flex flex-row items-center gap-4 rounded-lg border border-gray-300 overflow-hidden max-w-[250px] p-2">
                    {{--left--}}
                    <i class="fa-solid fa-user-circle text-5xl"></i>

                    {{--right--}}
                    <div class="flex flex-col w-full">
                        {{--top--}}
                        <div class="items-center flex flex-row gap-2">
                            <div class="text-md font-bold truncate">{{ $task->name }}</div>
                            <span class="badge badge-success badge-xs"></span>
                        </div>

                        {{--bottom--}}
                        <div class="items-center flex flex-row gap-2">
                            <div class="text-md truncate">{{ $task->description }}</div>
                            <div class="text-sm text-gray-500 text-nowrap">
                                {{ floor($task->created_at->diffInMinutes()) < 60 ? floor($task->created_at->diffInMinutes()) . 'm' : (floor($task->created_at->diffInHours()) < 24 ? floor($task->created_at->diffInHours()) . 'h' : floor
                                ($task->created_at->diffInDays()) . 'd') }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </x-container-section>

    <x-container-section>
        <div class="text-lg font-bold">Recents</div>
    </x-container-section>
</x-app-layout>
