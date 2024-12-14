<x-app-layout>
    {{--    @section('head')--}}
    <link rel="stylesheet" href="{{ asset('css/requirements/index.css') }}">
    {{--    @endsection--}}

    <x-app-header>Requirement List</x-app-header>
    <x-container-section>
        {{-- sort section --}}
        <div class="flex flex-row items-center gap-2">
            {{--sort status--}}
            <select name="sortStatus" id="sortStatus" class="select select-bordered">
                <option value="all" selected>All Records</option>
                <option value="pending">Pending</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
            </select>
            {{--<x-select-input class="focus:border-green-500 w-fit" select-label="Select Status"></x-select-input>--}}

            {{--search bar--}}
            <x-text-input class="" placeholder="Search..."/>

            {{--add new file--}}
            {{--            <a href="{{ route('admin.requirements.create') }}" class="btn btn-md btn-success text-white">Create <i class="fa-solid fa-plus"></i></a>--}}
            <button class="btn btn-md btn-success text-white" onclick="create_requirement.showModal()">Create <i class="fa-solid fa-plus"></i></button>
        </div>

        {{-- requirements table --}}
        @include('admin.requirements.partials.requirement-table-lists')
    </x-container-section>

    <dialog id="create_requirement" class="modal">
        <div class="modal-box w-11/12 max-w-5xl space-y-2">
            <h3 class="text-lg font-bold">Create Requirement</h3>
            @include('admin.requirements.partials.requirement-create-form')
        </div>
    </dialog>


</x-app-layout>
