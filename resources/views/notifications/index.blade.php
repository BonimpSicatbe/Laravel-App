<x-app-layout>
    <x-app-header>Notifications</x-app-header>

    <div class="container flex flex-row mx-auto overflow-hidden gap-4 pb-4 sm:px-6 lg:px-8 w-full h-full">

        {{--left--}}
        <div class="flex flex-col gap-6 w-1/3">

            {{--            @auth --}}{{-- TODO !!! change so only the admins can create notifications !!! --}}
            {{--                <form action="{{ route('notifications.create') }}" method="post" class="">--}}
            {{--                    <button type="submit" onclick="createNewNotificationModal.open()" class="btn btn-lg btn-outline bg-white shadow-lg w-full">Create New Notification</button>--}}
            {{--                </form>--}}
            {{--            @endauth --}}{{-- TODO!!! change so only the admins can create notifications !!! --}}

            <div class="grow bg-white overflow-y-auto shadow-sm sm:rounded-lg">
                <div class="p-4 bg-white overflow-x-auto w-full space-y-1">
                    {{--notification lists--}}
                    @include('notifications.partials.notification-lists', ['notifications' => $notifications])
                </div>
            </div>
        </div>

        {{--right--}}
        <div class="w-2/3">
            <div class="flex items-center text-center bg-white overflow-y-auto shadow-sm sm:rounded-lg h-full">
                <div class="p-6 bg-white overflow-x-auto w-full space-y-2">
                    <div class="text-5xl font-black text-gray-500">
                        Select notification to view.
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
