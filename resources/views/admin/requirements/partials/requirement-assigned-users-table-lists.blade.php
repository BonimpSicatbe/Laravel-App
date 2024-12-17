<div class="overflow-y-auto max-h-[250px]">
    <table class="table table-auto">
        <thead>
        <tr class="text-gray-400">
            <th>Account Number</th>
            <th>Name</th>
            {{--        <th>Role</th>--}}
            <th>Email</th>
            {{--        <th>Email Verified At</th>--}}
            {{--        <th>Created At</th>--}}
            {{--        <th>Updated At</th>--}}
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @if($requirement->users->isEmpty())
            <tr>
                <td colspan="8" class="text-center">There are no assigned users.</td>
            </tr>
        @else
            @foreach($requirement->users as $user)
                <tr class="text-black">
                    <td>{{ $user->account_number }}</td>
                    <td class="text-nowrap truncate">{{ ucwords($user->name) }}</td>
                    {{--                <td>{{ ucwords($user->role) }}</td>--}}
                    <td class="text-nowrap truncate">{{ $user->email }}</td>
                    {{--                <td class="text-nowrap truncate">{{ $user->email_verified_at }}</td>--}}
                    {{--                <td class="text-nowrap truncate">{{ $user->created_at }}</td>--}}
                    {{--                <td class="text-nowrap truncate">{{ $user->updated_at }}</td>--}}
                    <td class="flex flex-row gap-2">
                        <a href="{{ route('admin.users.show', $user->id) }}"
                           class="text-green-500 hover:text-green-700 transition-all tooltip tooltip-left" data-tip="view"><i
                                class="fa-regular fa-eye"></i></a>
                        <a href="{{ route('admin.users.edit', $user->id) }}"
                           class="text-blue-500 hover:text-blue-700 transition-all tooltip tooltip-left" data-tip="edit"><i
                                class="fa-regular fa-edit"></i></a>

                        <form action="{{ route('admin.requirements.user.delete', ['requirement' => $requirement->id, 'user' => $user->id]) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 transition-all tooltip tooltip-left" data-tip="remove user"><i
                                    class="fa-regular fa-user-xmark"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>
