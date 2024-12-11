<x-app-layout>
    <x-app-header>Create Role</x-app-header>

    @if ($errors->any())
        <x-container-section>
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="text-red-500">{{ $error }}</li>
                @endforeach
            </ul>
        </x-container-section>
    @endif

    {{-- Enter new role --}}
    <x-container-section>
        <form action="{{ route('admin.roles.store') }}" method="post" class="space-y-4">
            @csrf
            <div class="space-y-2">
                <x-input-label for="name" :value="__('Role Name')"/>
                <x-text-input id="name" type="text" name="name" :value="old('name')" autofocus autocomplete="name"/>
                <x-input-error :messages="$errors->get('name')" class="mt-2"/>
            </div>

            <button type="submit" class="btn btn-sm btn-wide btn-success text-white">Submit</button>
        </form>
    </x-container-section>

    {{-- Role Lists --}}
    <x-container-section>
        {{-- Filter Sections --}}

        <div class="inline-flex items-center w-full">
            <div class="grow text-md font-bold">Roles Lists</div>
            <a href="{{ route('admin.roles.create') }}" class="btn btn-sm btn-success space-x-2 text-white">
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
                            <a href="{{ route('admin.roles.show', $role->id) }}"
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
