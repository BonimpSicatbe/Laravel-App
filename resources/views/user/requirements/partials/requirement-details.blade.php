<div class="grid grid-cols-2 gap-4">
    {{--name / edit button--}}
    <div class="col-span-2 flex flex-row justify-between items-center">
        <div class="">
            <x-input-label>Requirement Name</x-input-label>
            <div class="text-2xl font-bold">{{ $requirement->name }}</div>
        </div>
        <a href="{{ route('user.requirements.edit', $requirement->id) }}" class="text-blue-500">
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

    {{--syllabus--}}
    <div class="col-span-2">
        <x-input-label class="capitalize">syllabus</x-input-label>
        <div class="text-md capitalize">{{ is_null($requirement->syllabus) ? 'No syllabus uploaded.' : $requirement->syllabus }}</div>
    </div>

    {{--attachments--}}
    <div class="col-span-2">
        <x-input-label class="capitalize">attachment</x-input-label>
        @include('user.requirements.partials.requirement-attachments-list')
    </div>
</div>
