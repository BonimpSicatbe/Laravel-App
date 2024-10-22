<x-app-layout>
    <x-app-header>File Manager</x-app-header>

    <x-container-section>
        <table class="table table-fixed">
            <thead>
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Size</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @if($files->isEmpty())
                <tr><td colspan="5" class="text-center">There are no files listed.</td></tr>
            @else
                @foreach($files as $file)
                    <tr>
                        <td>{{ $file->name }}</td>
                        <td>{{ $file->mime_type }}</td>
                        <td>{{ number_format($file->size / 1024, 2) }} KB</td> <!-- Size in KB -->
                        <td>{{ $file->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            <a href="{{ route('file.show', $file->id) }}" class="text-green-500 hover:text-green-700 transition-all">
                                <i class="fa-regular fa-eye"></i>
                            </a>
                            <form action="{{ route('file.destroy', $file->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 transition-all">
                                    <i class="fa-regular fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </x-container-section>
</x-app-layout>
