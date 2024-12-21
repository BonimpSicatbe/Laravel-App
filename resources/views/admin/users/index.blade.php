<x-app-layout>
    <x-app-header>Users Lists</x-app-header>

    <x-container-section>
        {{-- Search and Filters Form --}}
        <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-row items-center gap-2">
            {{-- Select Role --}}
            <x-select-input name="role" selectLabel="Select Role">
                <option value="all" {{ request('role') == 'all' ? 'selected' : '' }}>All</option>
                <option value="instructor" {{ request('role') == 'instructor' ? 'selected' : '' }}>Instructor</option>
                <option value="coordinator" {{ request('role') == 'coordinator' ? 'selected' : '' }}>Coordinator</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            </x-select-input>

            {{-- Search Name --}}
            <x-text-input type="search" name="searchName" id="searchName" placeholder="Search Name..."
                          value="{{ request('searchName') }}"></x-text-input>

            {{-- Search Email --}}
            <x-text-input type="search" name="searchEmail" id="searchEmail" placeholder="Search Email..."
                          value="{{ request('searchEmail') }}"></x-text-input>

            {{-- Submit Button --}}
            <button type="submit" class="btn btn-md btn-outline btn-primary">
                <i class="fa-solid fa-search"></i>
                <span>Search</span>
            </button>

            {{-- Add User Button --}}
            <a href="{{ route('admin.users.create') }}" class="btn btn-md btn-outline btn-success">
                <i class="fa-solid fa-plus"></i>
                <span>Add User</span>
            </a>
        </form>

        {{-- User Table --}}
        @include('admin.users.partials.user-table-lists')
    </x-container-section>
</x-app-layout>
