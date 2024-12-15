<table class="table table-fixed">
    <thead>
    <tr class="text-gray-500">
        <th>Name</th>
        <th>Description</th>
        <th>Status</th>
        <th>Created At</th>
        <th>Due Date</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody id="requirements-tbody">
    @if($requirements->isempty())
        <tr>
            <td colspan="8" class="text-center font-bold text-black">No Requirements Listed.</td>
        </tr>
    @else
        @foreach ($user->requirements as $requirement)
            <tr>
                {{-- name --}}
                <td class="truncate"><a href="{{ route('user.requirements.show', $requirement->id) }}"
                                        class="hover:link truncate">{{ $requirement->name }}</a></td>

                {{--description--}}
                <td class="truncate">{{ $requirement->description }}</td>

                {{-- status --}}
                <td class="truncate"><a href="">{{ $requirement->status }}</a></td>

                {{--Created At--}}
                <td class="truncate">{{ $requirement->created_at }}</td>

                {{-- due date --}}
                <td class="truncate">{{  $requirement->due_date }}</td>

                {{-- action buttons --}}
                <td class="flex flex-row items-center gap-2">
                    {{-- view requirement --}}
                    <a href="{{ route('user.requirements.show', $requirement->id) }}"
                       class="text-green-500 hover:text-green-700 transition-all "><i
                            class=" fa-regular fa-eye"></i></a>

                    {{-- edit requirement --}}
                    <a href="{{ route('user.requirements.edit', $requirement->id) }}"
                       class="text-blue-500 hover:text-blue-700 transition-all "><i class=" fa-regular fa-edit"></i></a>

                    {{-- delete requirement --}}
                    <form method="POST" action="{{ route('user.requirements.destroy', $requirement->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700 transition-all "><i
                                class=" fa-regular fa-trash"></i></button>
                    </form>
                </td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>
