<x-app-layout>
    <x-app-header>Roles List</x-app-header>

    {{-- Roles List --}}
    <x-container-section>
        {{-- Filter Sections --}}
        <div class="inline-flex items-center w-full">
            <div class="grow text-md font-bold">Roles Lists</div>
            <a href="{{ route('roles.create') }}" class="btn btn-sm btn-success space-x-2 text-white">
                <i class="fa-solid fa-plus"></i>
                <span>New Role</span>
            </a>
        </div>

        <table class="table table-fixed">
            <thead>
            <tr>
{{--                <th>ID</th>--}}
                <th>NAME</th>
                <th>GUARD NAME</th>
                <th>CREATED AT</th>
                <th>UPDATED AT</th>
                <th>ACTIONS</th>
            </tr>
            </thead>
            <tbody>
            @if($roles->isEmpty())
                <tr>
                    <td colspan="6" class="text-center text-sm">No Roles Listed.</td>
                </tr>
            @else
                @foreach($roles as $role)
                    <tr>
{{--                        <td class="capitalize">{{ $role->id }}</td>--}}
                        <td class="capitalize">{{ $role->name }}</td>
                        <td class="capitalize">{{ $role->guard_name }}</td>
                        <td class="capitalize">{{ $role->created_at->diffForHumans() }}</td>
                        <td class="capitalize">{{ $role->updated_at->diffForHumans() }}</td>
                        <td class="capitalize">
                            <a href="{{ route('roles.show', $role->id) }}"
                               class="text-green-500 hover:text-green-700 transition-all"><i
                                    class="fa-regular fa-eye"></i></a>
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </x-container-section>

    {{-- User Roles Lists --}}
    <x-container-section>
        <div class="inline-flex items-center w-full">
            <div class="grow text-md font-bold">User Roles Lists</div>
            <a href="" class="btn btn-sm btn-success text-white">
                <i class="fa-solid fa-plus"></i>
                <span>Assign Role</span>
            </a>
        </div>

        <div class="overflow-y-auto max-h-[500px] min-h-[500px]">
            <table class="table table-fixed">
                <thead>
                <tr>
                    <th>ACCOUNT NUMBER</th>
                    <th>NAME</th>
                    <th>ROLE</th>
                    <th>ACTIONS</th>
                </tr>
                </thead>
                <tbody>
                @if($allUserWithTheirRoles->isEmpty())
                    <tr>
                        <td colspan="4" class="capitalize text-center">There are no recorded users.</td>
                    </tr>
                @else
                    @foreach($allUserWithTheirRoles as $user)
                        <tr>
                            <td>{{ $user->account_number }}</td>
                            <td>{{ $user->name }}</td>
                            <td>
                                @if($user->roles->isNotEmpty())
                                    {{ $user->roles->pluck('name')->join(', ') }}
                                @else
                                    No role assigned
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('users.show', $user->id) }}"
                                   class="text-green-500 hover:text-green-700 transition-all">
                                    <i class="fa-regular fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>

        <div class="pagination-wrapper">
            {{ $allUserWithTheirRoles->links('vendor.pagination.custom') }}
        </div>
    </x-container-section>

    {{--  --}}
</x-app-layout>
