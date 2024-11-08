{{--
    todo
    display assigned users of a role
--}}

<x-app-layout>
    <x-app-header>Show Role</x-app-header>

    {{-- role details --}}
    <x-container-section>
        <div class="flex flex-row gap-4">
            {{-- Role Name --}}
            <div class="grow">
                <x-input-label class="capitalize">Role Name</x-input-label>
                <div class="text-lg font-bold bg-gray-50 rounded-lg p-2">{{ $role->name }}</div>
            </div>

            {{--permission count--}}
            <div class="grow">
                <x-input-label>Permission Count:</x-input-label>
                <div class="text-lg font-bold bg-gray-50 rounded-lg p-2">{{ $role->permissions->count() }}</div>
            </div>

            {{--user count--}}
            <div class="grow">
                <x-input-label>User Count:</x-input-label>
                <div class="text-lg font-bold bg-gray-50 rounded-lg p-2">{{ $role->users->count() }}</div>
            </div>
        </div>
    </x-container-section>

    {{--assigned permissions--}}
    <x-container-section>
        <div class="flex">
            <div class="text-md font-bold grow">Assigned Permissions</div>
            <a href="{{ route('admin.assign_permission', $role->id) }}" class="btn btn-sm btn-success space-x-2 text-white">
                <i class="fa-solid fa-plus"></i>
                <span>Assign Permission</span>
            </a>
        </div>
        <div class="max-h-[250px] overflow-y-auto">
            <table class="table table-fixed">
                <thead>
                <tr>
                    <th>NAME</th>
                    <th>GUARD NAME</th>
                    <th>ACTIONS</th>
                </tr>
                </thead>
                <tbody>
                @if($permissions->isEmpty())
                    <tr>
                        <td colspan="3" class="text-center text-sm">No Permission Assigned.</td>
                    </tr>
                @else
                    @foreach($permissions as $permission)
                        <tr>
                            <td class="capitalize">{{ $permission->name }}</td>
                            <td class="capitalize">{{ $permission->guard_name }}</td>
                            <td class="capitalize">
                                <form action="{{ route('admin.remove_permission_from_role', [$role->id, $permission->id]) }}"
                                      method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="link text-red-600 hover:text-red-800 transition-all">
                                        remove
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </x-container-section>

    {{--assigned users--}}
    <x-container-section>
        <div class="flex items-center gap-4">
            <div class="text-md font-bold grow">Assigned Users</div>

            <a href="{{ route('admin.assign_user_roles', $role->id) }}" class="btn btn-sm btn-success text-white">
                <i class="fa-solid fa-plus"></i>
                <span>Assign Users</span>
            </a>
        </div>

        <div class="">
            <table class="table table-fixed">
                <thead>
                <tr>
                    <th>ACCOUNT NUMBER</th>
                    <th>NAME</th>
                    <th>POSITION</th>
                    <th>ACTION</th>
                </tr>
                </thead>
                <tbody>
                @if($assignedUsers->isEmpty())
                    <tr>
                        <td colspan="4" class="text-center">There are no assigned users.</td>
                    </tr>
                @else
                    @foreach($assignedUsers as $assignedUser)
                        <tr>
                            <td class="truncate">{{ $assignedUser->account_number }}</td>
                            <td class="truncate">{{ $assignedUser->name }}</td>
                            <td class="truncate">{{ $assignedUser->position->name }}</td>
                            <td class="truncate">
                                <form action="{{ route('admin.remove_user_from_role', [$role->id, $assignedUser->id]) }}"
                                      method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="link text-red-600 hover:text-red-800 transition-all">
                                        remove
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </x-container-section>
</x-app-layout>
