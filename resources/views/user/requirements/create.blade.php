<x-app-layout>
    <x-app-header>Create Requirement</x-app-header>

    <x-container-section>
        <div class="">
            <h3 class="text-lg font-bold">Upload Requirement Files</h3>
        </div>

        <form action="{{ route('user.requirements.store') }}" method="post">
            @csrf
            <input type="file" name="userFileUpload[]" id="userFileUpload" class="" multiple>
            <button type="submit" class="btn btn-sm btn-success text-white">Upload File</button>
        </form>
    </x-container-section>

</x-app-layout>
