    @if ($requirements->isEmpty())
        <div class="flex flex-row items-center gap-4">
            <div class="skeleton h-16 w-16 shrink-0 rounded-full"></div>
            <div class="flex flex-col gap-4 w-full">
                <div class="skeleton h-4 w-2/3"></div>
                <div class="skeleton h-4 w-full"></div>
            </div>
        </div>
    @else
        @foreach ($requirements as $requirement)
            {{-- card --}}
            <a href="{{ route('user.requirements.show', $requirement->id) }}"
                class="flex flex-row max-w-[350px] min-w-[350px] gap-2 p-4 border border-gray-200 rounded-lg overflow-hidden hover:bg-gray-100 transition-all">
                {{-- left --}}
                <i class="fa-solid fa-user-circle text-5xl"></i>

                {{-- right --}}
                <div class="flex flex-col justify-between overflow-hidden">
                    {{-- top --}}
                    <div class="font-bold">{{ $requirement->name }}</div>

                    {{-- bottom --}}
                    <div class="flex flex-row items-center">
                        {{-- left --}}
                        <div class="truncate grow">{{ $requirement->description }}</div>

                        {{-- right --}}
                        <div class="">
                            {{ floor($requirement->created_at->diffInMinutes()) < 60
                                ? floor($requirement->created_at->diffInMinutes()) . 'm'
                                : (floor($requirement->created_at->diffInHours()) < 24
                                    ? floor($requirement->created_at->diffInHours()) . 'h'
                                    : floor($requirement->created_at->diffInDays()) . 'd') }}
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
        @if ($requirements->count() > 10)
            {{-- View More card --}}
            <a href="{{ route('user.requirements.index') }}" class="text-lg space-x-4 border border-gray-200 hover:text-blue-700 font-bold rounded-lg text-nowrap p-6">
                <span>View more</span>
                <i class="fa-solid fa-arrow-circle-right"></i>
            </a>
        @endif
    @endif
