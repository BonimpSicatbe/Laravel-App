@if($notifications->isEmpty())
    <div class="text-lg text-center font-semibold border border-gray-500 rounded-lg hover:bg-gray-100 p-4">
        No notifications available.
    </div>
@else
    @foreach($notifications as $notification)
        <a href="{{ route('user.notifications.show', $notification->id) }}"
           class="flex flex-row rounded-lg gap-4 p-2 hover:bg-gray-100">
            {{-- left icon --}}
            <i class="fa-solid fa-user-circle text-5xl"></i>

            {{-- right container --}}
            <div class="grow overflow-hidden">
                {{-- top row: title and unread status --}}
                <div class="flex flex-row justify-between items-center">
                    <div class="text-lg font-bold truncate">
                        {{ $notification->data['name'] ?? 'Notification' }}
                    </div>
                    @if(is_null($notification->read_at))
                        <span class="badge badge-success badge-xs">New</span>
                    @endif
                </div>

                {{-- bottom row: message and timestamp --}}
                <div class="flex flex-row gap-3">
                    <div class="text-sm grow truncate">
                        {{ $notification->data['description'] ?? 'No additional details.' }}
                    </div>
                    <div class="text-sm text-gray-500 text-nowrap">
                        {{ $notification->created_at->format('g:i A') }}
                    </div>
                </div>
            </div>
        </a>
    @endforeach
@endif
