<div class="grid sm:grid-cols-1 lg:grid-cols-2 gap-4">
    {{--name--}}
    <div class="col-span-2 flex flex-row justify-between items-center">
        <div class="">
            <x-input-label>{{ ucwords($task->requirement->name) }}</x-input-label>
            <div class="text-xl font-bold">{{ ucwords($task->name) }}</div>
        </div>
        <a href="{{ route('admin.tasks.edit', $task->id) }}" class="text-blue-500 hover:text-blue-700 transition-all">
            <i class="fa-regular fa-edit"></i>
            <span>Edit</span>
        </a>
    </div>

    {{--created at--}}
    <div class="">
        <x-input-label class="capitalize">created at</x-input-label>
        <div class="text-md capitalize">{{ $task->created_at->format('M, d Y - H:i A') }}</div>
    </div>
    {{--updated at--}}
    <div class="">
        <x-input-label class="capitalize">updated at</x-input-label>
        <div class="text-md capitalize">{{ $task->updated_at->format('M, d Y - H:i A') }}</div>
    </div>
    {{--due date--}}
    <div class="">
        <x-input-label class="capitalize">due date</x-input-label>
        <div class="text-md capitalize">{{ $task->due_date->format('M, d Y - H:i A') }}</div>
    </div>
    {{--updated by--}}
    <div class="">
        <x-input-label class="capitalize">updated by</x-input-label>
        <div class="text-md capitalize">{{ $task->updatedBy->name }}</div>
    </div>
    <div class="">
        <x-input-label class="capitalize">Assigned to</x-input-label>
        <div class="text-md capitalize">{{ $task->requirement->sent_to_name }}</div>
    </div>
    {{--created by / assigned by--}}
    <div class="">
        <x-input-label class="capitalize">created by / assigned by</x-input-label>
        <div class="text-md capitalize">{{ $task->createdBy->name }}</div>
    </div>
    {{--status--}}
    <div class="">
        <x-input-label class="capitalize">status</x-input-label>
        <div class="text-md capitalize">{{ $task->status }}</div>
    </div>
    {{--priority--}}
    <div class="">
        <x-input-label class="capitalize">priority</x-input-label>
        <div class="text-md capitalize">{{ $task->priority }}</div>
    </div>
    {{--description--}}
    <div class="col-span-2">
        <x-input-label class="capitalize">description</x-input-label>
        <div class="text-md normal-case">{{ $task->description }}</div>
    </div>
</div>
