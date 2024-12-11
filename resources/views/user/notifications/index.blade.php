<x-app-layout>
    <x-app-header>Notifications</x-app-header>

    <div class="container mx-auto sm:px-6 lg:px-8 w-full h-full">

        <div class="grid grid-cols-3 gap-4 w-full h-full">
            {{--left--}}
            <div class="col-span-1">
                <div class="grow bg-white overflow-y-auto shadow-sm sm:rounded-lg h-full">
                    <div class="p-4 bg-white overflow-x-auto w-full space-y-1">
                        {{--notification lists--}}
                        @include('user.notifications.partials.notification-lists', ['notifications' => $notifications])
                    </div>
                </div>
            </div>

            {{--right--}}
            <div class="col-span-2">
                <div class="flex items-center text-center bg-white overflow-y-auto shadow-sm sm:rounded-lg h-full">
                    <div class="p-6 bg-white overflow-x-auto w-full space-y-2">
                        <div class="text-5xl font-black text-gray-500">
                            Select notification to view.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
