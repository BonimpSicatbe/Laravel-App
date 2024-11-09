<x-app-layout>
    <x-slot:header>
        <h2 class="font-bold text-xl text-gray-700">
            {{ __('Notifications') }}
        </h2>
    </x-slot:header>

    <div class="container flex flex-row mx-auto overflow-hidden gap-4 sm:px-6 lg:px-8 w-full h-full">

        {{--left--}}
        <div class="flex flex-col gap-6 sm:py-6 lg:py-8 w-1/3">
            {{--            @auth--}}
            {{--                <form action="{{ route('user.notifications.create') }}" method="post" class="">--}}
            {{--                    <button type="submit" class="btn btn-lg btn-outline bg-white shadow-lg w-full">Create New Notification</button>--}}
            {{--                </form>--}}
            {{--            @endauth--}}

            <div class="grow bg-white overflow-y-auto shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white overflow-x-auto w-full space-y-1">
                    {{--notification lists--}}
                    @include('user.notifications.partials.notification-lists', ['notifications' => $notifications])
                </div>
            </div>
        </div>

        {{--right--}}
        <div class="sm:py-6 lg:py-8 w-2/3">
            <div class="bg-white overflow-y-auto shadow-sm sm:rounded-lg h-full">
                <div class="flex flex-col h-full p-6 bg-white w-full space-y-2">
                    {{-- show notification section --}}
                    <div class="flex flex-row justify-between items-center w-full gap-4">
                        {{-- notification title --}}
                        <div class="text-lg font-bold grow truncate">{{ $notification->data['name'] }}</div>

                        {{-- sent date --}}
                        <div class="">
                            <div class="text-sm text-nowrap">{{ $notification->created_at->format('F j, Y h:ia') }}</div>
                        </div>

                        {{-- icon action button --}}
                        <div class="dropdown dropdown-end">
                            <div tabindex="0" role="button" class=""><i class="fa-solid fa-ellipsis"></i></div>
                            <ul tabindex="0"
                                class="dropdown-content menu bg-base-100 rounded-box z-[1] w-52 p-2 shadow">
                                <li><a href="{{ route('user.notifications.edit', $notification->id) }}"
                                       class="text-blue-500">
                                        <i class="fa-solid fa-edit"></i>
                                        <span>Edit</span>
                                    </a></li>
                                <li><a href="{{ route('user.notifications.destroy', $notification->id) }}"
                                       class="text-red-500">
                                        <i class="fa-solid fa-trash"></i>
                                        <span>Delete</span>
                                    </a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="divider"></div>

                    {{-- notification content --}}
                    <div class="flex flex-row items-center gap-4 w-full">
                        <i class="fa-solid fa-user-circle text-5xl"></i>

                        <div class="flex flex-col grow">
                            <div class="text-lg font-semibold">
                                {{ $notification->data['name'] }}
                            </div>
                            <div class="text-sm">
                                <strong class="text-gray-500">Sent to: </strong>
{{--                                {{ $notification->user->name }}--}}
                            </div>
                        </div>
                    </div>

                    <div class="divider"></div>

                    {{-- notification body --}}
                    <div class="flex flex-col grow overflow-y-auto gap-4">
                        <div class="space-y-2">
                            <div class="text-sm text-gray-500">Message:</div>
                            <div class="text-md">{{ $notification->data['description'] }}</div>
                        </div>
                        <div class="space-y-2">
                            <div class="text-sm text-gray-500">Attachment/s:</div>

                            {{-- TODO: display attachments included for every requirements  --}}

                            {{-- attachment container --}}
                            <div class="grid grid-cols-3 gap-2">
                                @include('user.notifications.partials.notification-attachments', ['notification' => $notification->id])
                            </div>

                        </div>
                    </div>

                    {{-- message action button --}}
                    <div class="">
                        <button class="text-white btn btn-sm btn-success">
                            <i class="fa-solid fa-reply"></i>
                            <span>Reply</span>
                        </button>
                        <input type="file" class="file-input file-input-sm file-input-success file-input-bordered w-full max-w-xs"/>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
