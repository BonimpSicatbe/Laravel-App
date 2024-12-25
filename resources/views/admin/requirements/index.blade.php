<x-app-layout>
    <link rel="stylesheet" href="{{ asset('css/requirements/index.css') }}">

    <x-app-header>Requirement List</x-app-header>
    <x-container-section>
        {{-- Sort and Search Section --}}
        <div class="flex flex-row items-center gap-2 justify-between">
            {{-- Sort and Search Form --}}
            <form method="GET" action="{{ route('admin.requirements.index') }}" class="flex flex-row items-center gap-2">
                {{-- Sort Status --}}
                <select name="sortStatus" id="sortStatus" class="select select-bordered">
                    <option value="all" {{ request('sortStatus') == 'all' ? 'selected' : '' }}>All Records</option>
                    <option value="pending" {{ request('sortStatus') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in_progress" {{ request('sortStatus') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="completed" {{ request('sortStatus') == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>

                {{-- Search Bar --}}
                <x-text-input name="search" value="{{ request('search') }}" placeholder="Search..."/>

                {{-- Search Button --}}
                <button type="submit" class="btn btn-primary">Search</button>

                {{--show all button--}}
                <a href="{{ route('admin.requirements.index') }}" class="btn btn-secondary">Show All</a>
            </form>

            {{-- Add New Requirement Button --}}
            <button class="btn btn-md btn-success text-white" onclick="create_requirement.showModal()">
                Create <i class="fa-solid fa-plus"></i>
            </button>
        </div>

        {{-- Requirements Table --}}
        @include('admin.requirements.partials.requirement-table-lists')
    </x-container-section>

    {{-- Create Requirement Modal --}}
    <dialog id="create_requirement" class="modal">
        <div class="modal-box w-11/12 max-w-5xl space-y-2">
            <h3 class="text-lg font-bold">Create Requirement</h3>
            @include('admin.requirements.partials.requirement-create-form')
        </div>
    </dialog>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const inputElement = document.querySelector('input[type="file"]');
        if (inputElement) {
            const pond = FilePond.create(inputElement);

            pond.getFiles();

            FilePond.setOptions({
                server: {
                    process: '{{ route('tmp_upload') }}',
                    revert: '{{ route('tmp_revert') }}',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                },
            });
        }
    });
</script>