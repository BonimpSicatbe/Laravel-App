<table class="w-full text-sm text-left text-gray-500">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b-2 border-gray-200">
    <tr>
        <th class="px-3 py-3">
            <a href="{{ route('project.index', array_merge($queryParams, ['sort_field' => 'id', 'sort_direction' => request('sort_field') == 'id' && request('sort_direction') == 'asc' ? 'desc' : 'asc'])) }}">
                ID
            </a>
        </th>
        <th class="px-3 py-3">Image</th>
        <th class="px-3 py-3">
            <a href="{{ route('project.index', array_merge($queryParams, ['sort_field' => 'name', 'sort_direction' => request('sort_field') == 'name' && request('sort_direction') == 'asc' ? 'desc' : 'asc'])) }}">
                Name
            </a>
        </th>
        <th class="px-3 py-3">
            <a href="{{ route('project.index', array_merge($queryParams, ['sort_field' => 'status', 'sort_direction' => request('sort_field') == 'status' && request('sort_direction') == 'asc' ? 'desc' : 'asc'])) }}">
                Status
            </a>
        </th>
        <th class="px-3 py-3">
            <a href="{{ route('project.index', array_merge($queryParams, ['sort_field' => 'created_at', 'sort_direction' => request('sort_field') == 'created_at' && request('sort_direction') == 'asc' ? 'desc' : 'asc'])) }}">
                Create Date
            </a>
        </th>
        <th class="px-3 py-3">
            <a href="{{ route('project.index', array_merge($queryParams, ['sort_field' => 'due_date', 'sort_direction' => request('sort_field') == 'due_date' && request('sort_direction') == 'asc' ? 'desc' : 'asc'])) }}">
                Due Date
            </a>
        </th>
        <th class="px-3 py-3">Created By</th>
        <th class="px-3 py-3 text-right">Actions</th>
    </tr>
    <tr>
        <td class="px-3 py-3"></td>
        <td class="px-3 py-3"></td>
        <td class="px-3 py-3">
            <form method="GET" action="{{ route('project.index') }}">
                <input
                    type="text"
                    name="name"
                    class="w-full border border-gray-300 rounded px-2 py-1"
                    value="{{ request('name') }}"
                    placeholder="Project Name"
                />
                <button type="submit" class="hidden">Search</button>
            </form>
        </td>
        <td class="px-3 py-3">
            <form method="GET" action="{{ route('project.index') }}">
                <select
                    name="status"
                    class="w-full border border-gray-300 rounded px-2 py-1"
                    onchange="this.form.submit()"
                >
                    <option value="">Select Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </form>
        </td>
        <td class="px-3 py-3"></td>
        <td class="px-3 py-3"></td>
        <td class="px-3 py-3"></td>
        <td class="px-3 py-3"></td>
    </tr>
    </thead>
    <tbody>
    @foreach ($projects as $project)
        <tr class="bg-white border-b border-gray-200">
            <td class="px-3 py-2">{{ $project->id }}</td>
            <td class="px-3 py-2">
                <img src="{{ $project->image_path }}" style="width: 60px;" />
            </td>
            <td class="px-3 py-2 text-gray-800 text-nowrap hover:underline">
                <a href="{{ route('project.show', $project->id) }}">{{ $project->name }}</a>
            </td>
            <td class="px-3 py-2 {{ $projectStatusClassMap[$project->status] ?? '' }}">
                {{ $projectStatusTextMap[$project->status] ?? '' }}
            </td>
            <td class="px-3 py-2 text-nowrap">{{ $project->created_at }}</td>
            <td class="px-3 py-2 text-nowrap">{{ $project->due_date }}</td>
            <td class="px-3 py-2">{{ $project->createdBy->name }}</td>
            <td class="px-3 py-2 text-nowrap">
                <a href="{{ route('project.edit', $project->id) }}" class="font-medium text-blue-600 hover:underline mx-1"><i class="fa-solid fa-pen-to-square"></i></a>
                <form method="POST" action="{{ route('project.destroy', $project->id) }}" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="font-medium text-red-600 hover:underline mx-1"><i class="fa-solid fa-trash"></i></button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
