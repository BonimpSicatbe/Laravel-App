<table class="table table-auto">
    <thead>
    <tr>
        <th>Name</th>
        {{--                <th>Description</th>--}}
        <th>Status</th>
        <th>Priority</th>
        <th>Users</th>
        <th>Requirement</th>
{{--        <th>Created At</th>--}}
{{--        <th>Due Date</th>--}}
        <th>Created By</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @if($tasks->isEmpty())
        <tr>
            <td colspan="7" class="text-center capitalize">There are no task listed</td>
        </tr>
    @else
        <div class="overflow-y-auto max-h-[250px]">
            @foreach($tasks as $task)
                <tr class="overflow-y-auto max-h-[250px]">
                    <td class="truncate hover:animate-marquee hover:link"><a
                            href="{{ route('tasks.show', $task->id) }}">{{ $task->name }}</a></td>
                    {{--<td>{{ $task->Description }}</td>--}}
                    <td class="truncate capitalize ">{{ $task->status }}</td>
                    <td class="truncate capitalize ">{{ $task->priority }}</td>
                    <td class="truncate capitalize ">{{ $task->users->count() }}</td>
                    <td class="truncate capitalize ">{{ $task->requirement->name }}</td>
{{--                    <td class="truncate capitalize text-nowrap">{{ $task->created_at }}</td>--}}
{{--                    <td class="truncate capitalize text-nowrap">{{ $task->due_date }}</td>--}}
                    <td class="truncate capitalize text-nowrap">{{ $task->createdBy->name }}</td>
                    <td class="flex flex-row items-center gap-2">
                        {{-- view task --}}
                        <a href="{{ route('tasks.show', $task->id) }}"
                           class="text-green-500 hover:text-green-700 transition-all "><i
                                class=" fa-regular fa-eye"></i></a>

                        {{-- edit task --}}
                        <a href="{{ route('tasks.edit', $task->id) }}"
                           class="text-blue-500 hover:text-blue-700 transition-all "><i class=" fa-regular fa-edit"></i></a>

                        {{-- delete task --}}
                        <form method="POST" action="{{ route('tasks.destroy', $task->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 transition-all "><i
                                    class=" fa-regular fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </div>
    @endif
    </tbody>
</table>
