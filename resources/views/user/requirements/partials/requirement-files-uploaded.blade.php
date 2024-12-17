@if(is_null($submittedRequirementFiles))
    <div class="text-md">No submitted files.</div>
@else
    @foreach($submittedRequirementFiles as $submittedFile)
        <div class="">{{ $submittedFile->file_name }}</div>
    @endforeach
@endif
