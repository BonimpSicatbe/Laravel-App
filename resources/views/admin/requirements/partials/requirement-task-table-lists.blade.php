<div class="overflow-y-auto max-h-[500px]">
    <table class="table table-auto">
        <thead>
        <tr>
            <th>Name</th>
            <th>Due Date</th>
            <th>Created By</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @if($tasks->isEmpty())
            <tr>
                <td colspan="5" class="text-center">No Task Listed.</td>
            </tr>
        @else
            @foreach($tasks as $task)
                <tr>
                    <td><a href="{{ route('admin.tasks.show', $task->id) }}" class="hover:link">{{ $task->name }}</a></td>
                    <td>{{ $task->due_date }}</td>
                    <td>{{ $task->createdBy->name }}</td>
                    <td>{{ $task->created_at }}</td>
                    <td class="flex flex-row gap-2">
                        <a href="{{ route('admin.tasks.edit', $task->id) }}"
                           class="text-blue-500 hover:text-blue-700 tooltip" data-tip="Edit"><i
                                class="fa-regular fa-edit"></i></a>
                        <form action="{{ route('admin.tasks.destroy', $task->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 tooltip"
                                    data-tip="Delete"><i class="fa-regular fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>
