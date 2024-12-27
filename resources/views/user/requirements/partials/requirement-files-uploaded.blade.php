<div class="overflow-y-auto max-h-[250px] space-y-1">
    @if($userUploadedFiles->isEmpty())
        <div class="text-md">No submitted files.</div>
    @else
        @foreach($userUploadedFiles as $userUploadedFile)
            <div class="flex flex-row justify-between items-center">
                <div class="text-md">{{ $userUploadedFile->file_name }}</div>

                <div class="">
                    <a href="" class="text-green-500 hover:text-green-700 transition-all"><i class="fa-regular fa-eye"></i></a>
                </div>
            </div>
        @endforeach
    @endif
</div>
