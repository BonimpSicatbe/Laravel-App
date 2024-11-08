<x-app-layout>
    <x-app-header>Assign Users</x-app-header>

    <x-container-section>
        <form action="{{ route('admin.store_user_roles', $role->id) }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <x-input-label>Select Users</x-input-label>

                <div class="flex flex-col gap-2 max-h-[250px] overflow-y-auto">
                    @if($users->isEmpty())
                        <div class="text-md">There are no recorded users.</div>
                    @else
                        @foreach($users as $user)
                            <div class="flex items-center gap-4">
                                <input type="checkbox" name="users[]" value="{{ $user->id }}" id="user-{{ $user->id }}"
                                       class="checkbox"
                                    {{ $user->hasRole($role->name) ? 'checked' : '' }} />
                                <label for="user-{{ $user->id }}" class="label-text">{{ $user->name }}</label>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            {{--            <div class="flex justify-end">--}}
            <button type="submit" class="btn btn-sm btn-success text-white">Assign Users</button>
            {{--            </div>--}}
        </form>
    </x-container-section>
</x-app-layout>
