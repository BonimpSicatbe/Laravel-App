@if($notifications->isEmpty())
    <div class="text-lg text-center font-semibold border border-gray-500 rounded-lg hover:bg-gray-100 p-4">
        No notifications available.
    </div>
@else
    @foreach($notifications as $notification)

        {{--card container--}}
        {{--    <a href="{{ route('notifications.show', ['notification' => $notification->id]) }}" class="flex flex-row shadow-lg rounded-lg gap-4 p-4">--}}
        <a href="{{ route('notifications.show', $notification->id) }}"
           class="flex flex-row rounded-lg gap-4 p-2 hover:bg-gray-100">
            {{--left--}}
            <i class="fa-solid fa-user-circle text-5xl"></i>

            {{--right--}}
            <div class="grow overflow-hidden">
                {{--top--}}
                <div class="flex flex-row justify-between items-center">
                    <div class="text-lg font-bold truncate">{{ $notification->title }}</div>
                    @if($notification->unread)
                        <div class="badge badge-success badge-xs"></div>
                    @endif
                </div>

                {{--bottom--}}
                <div class="flex flex-row gap-3">
                    <div class="text-sm grow truncate">{{ $notification->message }}</div>

                    <div class="text-sm text-gray-500 text-nowrap">{{ $notification->created_at->format('g:m A') }}</div>
                </div>
            </div>
        </a>
    @endforeach
@endif
