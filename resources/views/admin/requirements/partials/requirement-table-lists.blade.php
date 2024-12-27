<table class="table table-fixed">
    <thead>
    <tr class="text-gray-500">
        <th>Name</th>
        <th>Description</th>
        <th>Status</th>
        <th>Users Submitted</th>
        <th>Users</th>
        <th>Created At</th>
        <th>Due Date</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody id="requirements-tbody">
    @if($requirements->isEmpty())
        <tr>
            <td colspan="8" class="text-center font-bold text-black">No Requirements Listed.</td>
        </tr>
    @else
        @foreach ($requirements as $requirement)
            <tr>
                {{-- name --}}
                <td class="truncate"><a href="{{ route('admin.requirements.show', $requirement->id) }}"
                                        class="hover:link truncate">{{ $requirement->name }}</a></td>

                {{-- description --}}
                <td class="truncate">{{ $requirement->description }}</td>

                {{-- status --}}
                <td class="truncate"><a href="">{{ $requirement->status }}</a></td>

                {{-- Users Submitted --}}
                <td class="truncate">
                    @if($requirement->submittedUsers->isEmpty())
                        <span>0</span>
                    @else
                        @foreach($requirement->submittedUsers as $user)
                            <span>{{ $user->name }}</span><br>
                        @endforeach
                    @endif
                </td>


                <td class="truncate">{{ $requirement->users->count() }}</td>

                {{-- Created At --}}
                <td class="truncate">{{ $requirement->created_at }}</td>

                {{-- Due Date --}}
                <td class="truncate">{{ $requirement->due_date }}</td>

                {{-- Action Buttons --}}
                <td class="flex flex-row items-center gap-2">
                    {{-- View requirement --}}
                    <a href="{{ route('admin.requirements.show', $requirement->id) }}"
                       class="text-green-500 hover:text-green-700 transition-all "><i class="fa-regular fa-eye"></i></a>

                    {{-- Edit requirement --}}
                    <a href="{{ route('admin.requirements.edit', $requirement->id) }}"
                       class="text-blue-500 hover:text-blue-700 transition-all "><i class="fa-regular fa-edit"></i></a>

                    {{-- Delete requirement --}}
                    <button type="button" class="text-red-500 hover:text-red-700 transition-all" onclick="showDeleteModal({{ $requirement->id }})">
                        <i class="fa-regular fa-trash"></i>
                    </button>
                </td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>

<!-- Confirmation Deletion Modal -->
<dialog id="delete_requirement_modal" class="modal">
    <div class="modal-box w-11/12 max-w-lg space-y-2">
        <h3 class="text-lg font-bold">Confirm Deletion</h3>
        <p>Are you sure you want to delete this requirement? This action cannot be undone.</p>
        <div class="modal-action">
            <form id="delete_form" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Yes, Delete</button>
            </form>
            <button class="btn" onclick="closeDeleteModal()">Cancel</button>
        </div>
    </div>
</dialog>

<script>
    // Function to open the delete confirmation modal
    function showDeleteModal(requirementId) {
        const form = document.getElementById('delete_form');
        form.action = '/admin/requirements/' + requirementId;

        document.getElementById('delete_requirement_modal').showModal();
    }

    // Function to close the delete confirmation modal
    function closeDeleteModal() {
        document.getElementById('delete_requirement_modal').close();
    }
</script>
