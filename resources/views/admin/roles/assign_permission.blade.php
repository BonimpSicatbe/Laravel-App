<x-app-layout>
    <x-app-header>Role Permissions</x-app-header>

    {{--assign permission--}}
    <x-container-section>
        <div class="text-md font-bold">Assign Permissions to {{ $role->name }} Role</div>
        <form action="{{ route('admin.store_permission', $role->id) }}" method="post" class="space-y-4">
            @csrf

            {{--Select Permissions--}}
            <div class="max-h-[250px] overflow-y-auto rounded-lg space-y-2">
                @if($permissions->isEmpty())
                    <div class="text-md">There are no permissions listed. <a
                            href="{{ route('admin.permissions.create') }}" class="link text-blue-600 hover:text-blue-800 transition-all">Create permissions</a></div>
                @else
                    @foreach($permissions as $permission)
                        <div class="flex items-center gap-4">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="permission-{{ $permission->name }}" class="checkbox"
                                {{ $role->hasPermissionTo($permission) ? 'checked' : '' }} />
                            <label for="permission-{{ $permission->name }}" class="label-text">{{ $permission->name }}</label>
                        </div>
                    @endforeach
                @endif
            </div>

            <a href="{{ route('admin.roles.show', $role->id) }}" class="btn btn-sm btn-neutral text-white">Done</a>
            <a href="{{ route('admin.permissions.create') }}" class="btn btn-sm btn-primary text-white">Create</a>
            <button type="submit" class="btn btn-sm btn-success text-white" {{ $permissions->isEmpty() ? 'disabled' : '' }}>Assign</button>
        </form>
    </x-container-section>

    {{--assigned permissions--}}
    <x-container-section>
        <div class="text-md font-bold">Assigned Permissions</div>

        <table class="table table-fixed">
            <thead>
            <tr>
                <th>NAME</th>
                <th>GUARD NAME</th>
                <th>CREATED AT</th>
                <th>UPDATED AT</th>
                <th>ACTIONS</th>
            </tr>
            </thead>
            <tbody>
            @if($assignedPermissions->isEmpty())
                <tr>
                    <td colspan="5" class="text-center">There are no permissions listed.</td>
                </tr>
            @else
                @foreach($assignedPermissions as $assignedPermission)
                    <tr>
                        <td>{{ $assignedPermission->name }}</td>
                        <td>{{ $assignedPermission->guard_name }}</td>
                        <td>{{ $assignedPermission->created_at->diffForHumans() }}</td>
                        <td>{{ $assignedPermission->updated_at->diffForHumans() }}</td>
                        <td>
                            <a href="{{ route('admin.permissions.show', $assignedPermission->id) }}" class="text-green-500 hover:text-green-700 transition-all"><i class="fa-regular fa-eye"></i></a>
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </x-container-section>
</x-app-layout>
