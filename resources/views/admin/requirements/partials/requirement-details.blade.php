<div class="grid grid-cols-2 gap-4">
    {{--name / edit button--}}
    <div class="col-span-2 flex flex-row justify-between items-center">
        <div class="">
            <x-input-label>Requirement Name</x-input-label>
            <div class="text-2xl font-bold">{{ $requirement->name }}</div>
        </div>
        <a href="{{ route('admin.requirements.edit', $requirement->id) }}" class="text-blue-500">
            <i class="fa-regular fa-edit"></i>
            <span>Edit</span>
        </a>
    </div>

    {{--created at--}}
    <div class="">
        <x-input-label class="capitalize">created at</x-input-label>
        <div class="text-md capitalize">{{ $requirement->created_at->format('M, d Y - H:i A') }}</div>
    </div>

    {{--due date--}}
    <div class="">
        <x-input-label class="capitalize">due date</x-input-label>
        <div class="text-md capitalize">{{ $requirement->due_date->format('M, d Y - H:i A') }}</div>
    </div>

    {{--assigned by--}}
    <div class="">
        <x-input-label class="capitalize">assigned by</x-input-label>
        <div class="text-md capitalize">{{ $requirement->createdBy->name }}</div>
    </div>

    {{--assigned to--}}
    <div class="">
        <x-input-label class="capitalize">assigned to</x-input-label>
        <div class="text-md capitalize">{{ $requirement->sent_to_name }}</div>
    </div>

    {{--status--}}
    <div class="">
        <x-input-label class="capitalize">status</x-input-label>
        <div class="text-md capitalize">{{ $requirement->status }}</div>
    </div>

    {{--task count--}}
    <div class="">
        <x-input-label class="capitalize">task count</x-input-label>
        <div class="text-md capitalize">{{ $requirement->tasks->count() }}</div>
    </div>

    {{--description--}}
    <div class="col-span-2">
        <x-input-label class="capitalize">description</x-input-label>
        <div class="text-md capitalize">{{ $requirement->description }}</div>
    </div>

    <div class="col-span-2 space-y-2">
        <x-input-label class="capitalize">attachments</x-input-label>
        @if(is_null($requirement->attachments))
            <div class="text-md">No attachment uploaded.</div>
        @else
            <div class="overflow-y-auto max-h-[250px]z space-y-2">
                @foreach($requirement->attachments as $attachment)
                    <div class="flex flex-row gap-4">
                        <div class="text-md grow">{{ $attachment->file_name }}</div>

                        <div class="flex flex-row gap-2">
                            <a href="{{ route('attachments.view', $attachment->id) }}" class="text-green-500 hover:text-green-700 transition-all tooltip tooltip-left" data-tip="view"><i class="fa-regular fa-eye"></i></a>
                            <a href="{{ route('attachments.download', $attachment->id) }}" class="text-blue-500 hover:text-blue-700 transition-all tooltip tooltip-left" data-tip="download"><i class="fa-regular fa-download"></i></a>
                            <form action="{{ route('attachments.destroy', $attachment->id) }}" method="post">
                                @csrf
                                <button type="submit" class="text-red-500 hover:text-red-700 transition-all"><i class="fa-regular fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
