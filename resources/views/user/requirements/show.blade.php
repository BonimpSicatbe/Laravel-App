<!--
TODO:
    requirements text map
    requirements class map
    sort functionality
    search functionality
-->

<x-app-layout>
    <x-app-header>
        View Requirement
    </x-app-header>

    {{-- for error checking todo to be removed --}}
    @if ($errors->any())
        <x-container-section>
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="text-red-500">{{ $error }}</li>
                @endforeach
            </ul>
        </x-container-section>
    @endif

    {{-- requirement details --}}
    <x-container-section>
        @include('user.requirements.partials.requirement-details')
    </x-container-section>

    {{-- files uploaded --}}
    <x-container-section>
        <div class="flex flex-row items-center justify-between gap-4">
            <div class="text-lg font-bold">Files Uploaded</div>
            <a href="{{ route('user.requirements.create', ['requirement_id' => $requirement]) }}" class="btn btn-sm btn-success text-white">
                <i class="fa-solid fa-upload"></i>
                <span>Upload File</span>
            </a>

            {{-- <div class="">
                <input type="file" name="userRequirementFileUpload[]" id="userRequirementFileUpload" class="hidden" multiple>
                <label for="userRequirementFileUpload" class="btn btn-sm btn-success text-white">
                    <i class="fa-regular fa-upload"></i>
                    <span>Upload File</span>
                </label>

                <button onclick="userFileUploadModal.showModal()" class="btn btn-success btn-sm text-white">
                    <i class="fa-solid fa-upload"></i>
                    <span>Upload File</span>
                </button>
            </div> --}}
        </div>
        @include('user.requirements.partials.requirement-files-uploaded')
    </x-container-section>

    {{-- <dialog id="userFileUploadModal" class="modal">
        <div class="modal-box w-11/12 max-w-5xl space-y-4">
            <h3 class="text-lg font-bold">Upload Requirement Files</h3>

            @include('user.requirements.partials.requirement-attachments-list')

            <div class="text-right">
                <form action="{{ route('user.requirements.store') }}" method="post" class="">
                    @csrf
                    <input type="file" name="userFileUpload[]" id="userFileUpload" class="" multiple>
                    <div class="">
                        <button type="button" class="btn btn-sm" onclick="userFileUploadModal.close()">Close</button>
                        <button type="submit" class="btn btn-sm btn-success text-white">Upload File</button>
                    </div>
                </form>
            </div>
        </div>
    </dialog> --}}
</x-app-layout>
