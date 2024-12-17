<div class="overflow-y-auto max-h-[250px]">
    <table class="table table-sm">
        <thead>
        <tr>
            <th>Column 1</th>
            <th>Column 2</th>
            <th>Column 3</th>
            <th>Column 4</th>
        </tr>
        </thead>

        <tbody>
        @if($requirement->userSubmittedFiles)
            <tr>
                <td colspan="4" class="text-center">No user has submitted a file yet.</td>
            </tr>
        @else
            @foreach($requirement->userSubmittedFiles as $file)
                <tr>
                    <td>{{ $file->file_name }}</td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>
