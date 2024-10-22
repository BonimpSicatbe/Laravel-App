<table class="table table-fixed">
    <thead>
    <tr>
        <th>Name</th>
        <th>Date Modified</th>
        <th>Type</th>
        <th>Size</th>
        <th>Belongs To</th>
        <th>Created At</th>
        <th>Actions</th>
    </tr>
    </thead>

    <tbody>
    @if($task->files->isEmpty())
        <tr>
            <td colspan="6" class="text-center">There are no files uploaded.</td>
        </tr>
    @else
        @foreach ($task->files as $file)
            <tr>
                <td>{{ $task->name }}</td>
                <td>{{ $task->updated_at }}</td>
                <td>{{ $task->mime_type }}</td>
                <td>{{ $task->size }}</td>
                <td>{{ $task->createdBy }}</td>
                <td>{{ $task->created_at }}</td>
                <td>
                    <a href="{{ route('tasks.delete_uploaded_file', $file->id) }}"
                       class="text-green-500 hover:text-green-700 transition-all"><i class="fa-regular fa-eye"></i></a>
                    <a href="{{ route('tasks.delete_uploaded_file', $file->id) }}"
                       class="text-blue-500 hover:text-blue-700 transition-all"><i class="fa-regular fa-edit"></i></a>
                    <a href="{{ route('tasks.delete_uploaded_file', $file->id) }}"
                       class="text-red-500 hover:text-red-700 transition-all"><i class="fa-regular fa-trash"></i></a>
                </td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>
