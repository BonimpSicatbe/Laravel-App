<x-app-layout>
    <x-app-header>Create Requirement</x-app-header>

    <x-container-section>
        <div class="">
            <h3 class="text-lg font-bold">Upload Requirement Files</h3>
        </div>

        <form action="{{ route('user.requirements.store', ['requirement_id' => request()->requirement_id]) }}" method="post">
            @csrf
            <input type="file" name="userFileUpload[]" id="userFileUpload" class="" multiple>
            <x-input-error :messages="$errors->get('userFileUpload')" class="mt-2"/>
            <button type="submit" class="btn btn-sm btn-success text-white">Upload File</button>
        </form>
    </x-container-section>

</x-app-layout>
