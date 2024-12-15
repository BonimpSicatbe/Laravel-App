{{-- todo: turn labels into variables, if attachment none, display none --}}

<div class="flex flex-col gap-2 w-full">
    @if(is_null($notification->attachments))
        <div class="text-md">There are no attached files.</div>
    @else
        @foreach($notification->attachments as $attachment)
            <div class="flex flex-row gap-4">
                <div class="text-md grow">{{ $attachment->file_name }}</div>

                <div class="space-x-2">
                    <a href="{{ route('attachments.view', $attachment->id) }}" class="text-green-500 hover:text-green-700 transition-all tooltip tooltip-left" data-tip="view"><i class="fa-regular fa-eye"></i></a>
                    <a href="{{ route('attachments.download', $attachment->id) }}" class="text-blue-500 hover:text-blue-700 transition-all tooltip tooltip-left" data-tip="download"><i class="fa-regular fa-download"></i></a>
                    <a href="" class="text-orange-500 hover:text-orange-700 transition-all tooltip tooltip-left" data-tip="upload"><i class="fa-regular fa-upload"></i></a>
                </div>
            </div>
        @endforeach
    @endif
</div>
