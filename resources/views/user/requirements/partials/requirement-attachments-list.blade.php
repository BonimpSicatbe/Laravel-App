{{--TODO :: upload function--}}
@if(is_null($requirement->attachments))
    <div class="text-md">No attachment uploaded.</div>
@else
    <div class="flex flex-col w-full gap-2">
        @foreach($requirement->attachments as $attachment)
            <div class="flex flex-row gap-4">
                <div class="text-md grow">{{ $attachment->file_name }}</div>
                {{--action buttons--}}
                <div class="space-x-2">
                    <a href="{{ route('attachments.view', $attachment->id) }}" class="text-md text-green-500 hover:text-green-700 transition-all"><i class="fa-regular fa-eye"></i></a>
                    <a href="{{ route('attachments.download', $attachment->id) }}" class="text-md text-blue-500 hover:text-blue-700 transition-all"><i class="fa-regular fa-download"></i></a>
                    <a href="" class="text-md text-orange-500 hover:text-orange-700 transition-all"><i class="fa-regular fa-upload"></i></a>
                </div>
            </div>
        @endforeach
    </div>
@endif
