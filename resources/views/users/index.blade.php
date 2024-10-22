<x-app-layout>
    <x-app-header>Users Lists</x-app-header>


    <x-container-section>
        {{--user label--}}
        <div class="flex flex-row items-center gap-2">
            <x-select-input selectLabel="Select Role">
                <option value="all">All</option>
                <option value="instructor">Instructor</option>
                <option value="coordinator">Coordinator</option>
                <option value="admin">Admin</option>
            </x-select-input>
            <x-text-input type="search" id="searchName" placeholder="Search Name..."></x-text-input>
            <x-text-input type="search" id="searchEmail" placeholder="Search Email..."></x-text-input>
            <a href="{{ route('users.create') }}" class="btn btn-md btn-outline btn-success"><i
                        class="fa-solid fa-plus"></i>
                <span>Add User</span></a>
            {{--
            <button onclick="addUserModal.showModal()" type="button" class="btn btn-md btn-outline">
                <i class="fa-solid fa-plus"></i>
                <span>Add User</span>
            </button>
            --}}
        </div>

        @include('users.partials.user-table-lists')
    </x-container-section>
</x-app-layout>

