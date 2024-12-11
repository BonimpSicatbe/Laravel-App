<x-app-layout>
    <x-app-header>Create Permission</x-app-header>

    @if ($errors->any())
        <x-container-section>
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="text-red-500">{{ $error }}</li>
                @endforeach
            </ul>
        </x-container-section>
    @endif

    {{-- create permission --}}
    <x-container-section>
        {{--        <div class="text-md font-bold">Create New Permission</div>--}}

        <form action="{{ route('permissions.store') }}" method="post" class="space-y-4">
            @csrf
            <div class="space-y-2">
                <x-input-label for="name" :value="__('Permission Name')"/>
                <x-text-input id="name" type="text" name="name" :value="old('name')" autofocus autocomplete="name"/>
                <x-input-error :messages="$errors->get('name')" class="mt-2"/>
            </div>

            <button type="submit" class="btn btn-sm btn-success text-white">Create</button>
        </form>
    </x-container-section>

    {{-- permission lists --}}
    <x-container-section>
        <div class="text-md font-bold">Permission Lists</div>

        <div class="max-h-[250px] overflow-y-auto">
            <table class="table table-fixed">
                <thead>
                <tr>
                    <td>NAME</td>
                    <td>GUARD NAME</td>
                    <td>CREATED AT</td>
                    <td>UPDATED AT</td>
                    <td>ACTIONS</td>
                </tr>
                </thead>
                <tbody class="">
                @if($permissions->isEmpty())
                    <tr>
                        <td colspan="5">There are no permissions listed.</td>
                    </tr>
                @else
                    @foreach($permissions as $permission)
                        <tr>
                            <td>{{ $permission->name }}</td>
                            <td>{{ $permission->guard_name }}</td>
                            <td>{{ $permission->created_at->diffForHumans() }}</td>
                            <td>{{ $permission->updated_at->diffForHumans() }}</td>
                            <td>
                                <div class="flex gap-2">
                                    <a href="{{ route('permissions.show', $permission->id) }}"
                                       class="text-green-500 hover:text-green-700 transition-all"><i
                                            class="fa-regular fa-eye"></i></a>
                                    <a href="{{ route('permissions.edit', $permission->id) }}"
                                       class="text-blue-500 hover:text-blue-700 transition-all"><i
                                            class="fa-regular fa-edit"></i></a>
                                    <form action="{{ route('permissions.destroy', $permission->id) }}" method="post"
                                          class="text-red-500 hover:text-red-700 transition-all">@csrf
                                        <button type="submit"><i class="fa-regular fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </x-container-section>

    {{-- assign permission --}}
    <x-container-section>
        <div class="text-md font-bold">Assign Permissions</div>

        {{--Select Role--}}
        <div class="space-y-2">
            <x-input-label for="role" :value="__('Select Role:')"></x-input-label>
            <x-select-input name="role" id="role" class="capitalize" required>
                <option value="" disabled selected>-- Select Role --</option>
                @if($roles->isEmpty())
                    <option value="" disabled>No roles listed.</option>
                @else
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" class="capitalize">{{ $role->name }}</option>
                    @endforeach
                @endif
            </x-select-input>
        </div>

        <form action="{{ route('store_permission', $role->id) }}" method="post" class="space-y-4">
            @csrf

            {{--Select Permissions--}}
            <div class="">
                <x-input-label for="role" :value="__('Select Permissions:')"></x-input-label>
                <div class="max-h-[250px] overflow-y-auto rounded-lg space-y-2 p-2">
                    @if($permissions->isEmpty())
                        <div class="text-md">There are no permissions listed.</div>
                    @else
                        @foreach($permissions as $permission)
                            <div class="flex items-center gap-4">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" class="checkbox"/>
                                <div class="label-text">{{ $permission->name }}</div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <button type="submit" class="btn btn-sm btn-neutral text-white">Clear</button>
            <button type="submit" class="btn btn-sm btn-success text-white">Assign</button>
        </form>
    </x-container-section>
</x-app-layout>


