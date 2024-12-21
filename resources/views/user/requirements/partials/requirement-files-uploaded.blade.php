<div class="overflow-y-auto max-h-[250px]">
    @if(is_null($user->submittedFiles))
        <div class="text-md">No submitted files.</div>
    @else
        @foreach($user->submittedFiles as $submittedFile)
            <div class="flex flex-row justify-between items-center">
                <div class="text-md">{{ $submittedFile->file_name }}</div>

                <div class="">
                    <a href="" class="text-green-500 hover:text-green-700 transition-all"><i class="fa-regular fa-eye"></i></a>
                </div>
            </div>
        @endforeach
    @endif
</div>
