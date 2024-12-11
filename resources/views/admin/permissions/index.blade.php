<x-app-layout>
    <x-app-header>Permission Lists</x-app-header>

    {{-- Permissions Table Lists --}}
    <x-container-section>
        <div class="flex items-center w-full">
            <div class="text-md font-bold grow">Permission Lists</div>
            <a href="{{ route('admin.permissions.create') }}" class="btn btn-sm btn-success text-white">
                <i class="fa-solid fa-plus"></i>
                <span>Add Permission</span>
            </a>
        </div>

        <table class="table table-auto">
            <thead>
            <tr>
                <th>NAME</th>
                <th>GUARD NAME</th>
                <th>CREATED AT</th>
                <th>UPDATED AT</th>
                <th>ACTION</th>
            </tr>
            </thead>
            <tbody>
            @if($permissions->isEmpty())
                <tr>
                    <td colspan="5" class="text-center">There are no recorded permissions.</td>
                </tr>
            @else
                @foreach($permissions as $permission)
                    <tr>
                        <td>{{ $permission->name }}</td>
                        <td>{{ $permission->guard_name }}</td>
                        <td>{{ $permission->created_at->diffForHumans() }}</td>
                        <td>{{ $permission->updated_at->diffForHumans() }}</td>
                        <td>
                            <a href="{{ route('admin.permissions.show', $permission->id) }}"
                               class="text-green-500 hover:text-green-700 transition-all"><i
                                    class="fa-regular fa-eye"></i></a>
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </x-container-section>
</x-app-layout>
