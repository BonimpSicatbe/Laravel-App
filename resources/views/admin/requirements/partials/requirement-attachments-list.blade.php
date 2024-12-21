<div class="max-h-[250px] overflow-y-auto">
    @if(is_null($requirement->attachments))
        <div class="text-md">No attachments uploaded.</div>
    @else
        @foreach($requirement->attachments as $attachment)
            <div class="flex flex-row justify-between items-center gap-4">
                <div class="text-md">{{ $attachment->file_name }}</div>

                {{--action buttons--}}
                <div class="flex flex-row gap-2">
                    <a href="{{ route('attachments.view', $attachment->id) }}" class="text-green-500 hover:text-green-700 transition-all"><i class="fa-regular fa-eye"></i></a>
                    <a href="{{ route('attachments.download', $attachment->id) }}" class="text-blue-500 hover:text-blue-700 transition-all"><i class="fa-regular fa-download"></i></a>
                    <form action="{{ route('attachments.destroy', $attachment->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700 transition-all"><i class="fa-regular fa-trash"></i></button>
                        {{--                        <a href="{{ route('attachments.view', $attachment->id) }}"></a>--}}
                    </form>
                </div>
            </div>
        @endforeach
    @endif
</div>
