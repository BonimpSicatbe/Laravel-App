<x-app-layout>

    <x-app-header>Portfolio</x-app-header>

    <x-container-section>
        <div class="text-lg font-bold">Submitted Files</div>
        @if($files->isEmpty())
            <div class="text-sm">There are no files uploaded.</div>
        @else
            @foreach($files as $file)
                <div class="rounded-sm p-2 capitalize">name {{ $task->name }}</div>
                <div class="rounded-sm p-2 capitalize">path {{ $task->path }}</div>
                <div class="rounded-sm p-2 capitalize">mime_type {{ $task->mime_type }}</div>
                <div class="rounded-sm p-2 capitalize">size {{ $task->size }}</div>
                <div class="rounded-sm p-2 capitalize">user_id {{ $task->user_id }}</div>
                <div class="rounded-sm p-2 capitalize">requirement_id {{ $task->requirement_id }}</div>
                <div class="rounded-sm p-2 capitalize">task_id {{ $task->task_id }}</div>
                <div class="rounded-sm p-2 capitalize">folder_id {{ $task->folder_id }}</div>
                <div class="rounded-sm p-2 capitalize">created_at {{ $task->created_at }}</div>
                <div class="rounded-sm p-2 capitalize">updated_at {{ $task->updated_at }}</div>
            @endforeach
        @endif
    </x-container-section>
</x-app-layout>
