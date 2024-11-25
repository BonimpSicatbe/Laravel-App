@if($notifications->isEmpty())
    <div class="space-y-2">
        @for($i = 0;$i < 3;$i++)
            <div class="group flex flex-row rounded-lg gap-4 p-2 hover:bg-gray-100 transition-all">
                <div class="bg-gray-100 h-12 w-12 shrink-0 rounded-full group-hover:bg-white"></div>

                <div class="flex flex-col gap-4 grow">
                    <div class="flex flex-row justify-between items-center">
                        <div class="bg-gray-100 rounded-full h-4 w-1/2 group-hover:bg-white"></div>
                        <div class="bg-gray-100 rounded-full h-3 w-3 group-hover:bg-white"></div>
                    </div>

                    <div class="flex flex-row gap-3">
                        <div class="bg-gray-100 rounded-full h-4 grow group-hover:bg-white"></div>
                        <div class="bg-gray-100 rounded-full h-4 w-12 group-hover:bg-white"></div>
                    </div>
                </div>
            </div>
        @endfor
    </div>
@else
    @foreach($notifications as $notification)
        <a href="{{ route('admin.notifications.show', $notification->id) }}"
           class="flex flex-row rounded-lg gap-4 p-2 hover:bg-gray-100
            {{ Request::is('admin/notifications/' . $notification->id) ? 'bg-green-100' : '' }}">
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
                        <span class="badge badge-success badge-xs"></span>
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
