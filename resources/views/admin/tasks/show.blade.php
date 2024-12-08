<x-app-layout>
    <x-app-header>Show Task</x-app-header>

    {{--details--}}
    <x-container-section>
        {{--details--}}
        @include('admin.tasks.partials.task-requirement-details')

        {{-- Attachments --}}
        <div>
            <x-input-label class="capitalize">Attachments</x-input-label>
            @if($task->attachments->isEmpty())
                <div class="text-md font-normal border border-gray-500 rounded-lg p-2">
                    No Attachments.
                </div>
            @else
                <ul class="">
                    @foreach($task->attachments as $attachment)
                        <li class="flex items-center justify-between border border-gray-500 rounded-lg p-2 mb-2">
                            <span class="text-sm font-normal">{{ $attachment->file_name }}</span>
                            <div class="flex space-x-2">
                                {{-- View Button --}}
                                <a
                                    href="{{ route('attachments.show', $attachment->id) }}"
                                    target="_blank"
                                    class="text-green-500 hover:underline">
                                    <i class="fa-regular fa-eye"></i>
                                </a>

                                {{-- Download Button --}}
                                <a href="{{ route('attachments.download', $attachment->id) }}" target="_blank" class="text-blue-500 hover:underline">
                                    <i class="fa-regular fa-download"></i>
                                </a>

                                {{-- Delete Button --}}
                                <form
                                    action="{{ route('attachments.destroy', $attachment->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this attachment?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline">
                                        <i class="fa-regular fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </x-container-section>

    {{--uploaded files--}}
    <x-container-section>
        {{--name--}}
        <div class="flex flex-row justify-between">
            <div class="text-lg font-bold grow">
                <i class="fa-regular fa-file-alt mr-2"></i>
                <span>Uploaded Files</span>
            </div>
            <button class="btn btn-sm btn-success text-white" onclick="uploadTaskFiles.showModal()">
                <i class="fa-solid fa-plus"></i>
                <span>Upload</span>
            </button>
        </div>

        {{--file attachments--}}
        <div class="flex flex-col gap-2 overflow-y-auto max-h-[500px]">
            {{--table--}}
            @include('admin.tasks.partials.tasks-uploaded-file-table-lists')
        </div>
    </x-container-section>

    {{--admin - included users list--}}
    <x-container-section>
        <div class="text-lg font-bold">
            <i class="fa-regular fa-users mr-2"></i>
            <span>Assigned Users</span>
        </div>
        @include('admin.tasks.partials.task-assigned-users-table-lists')
    </x-container-section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const viewButtons = document.querySelectorAll('.view-attachment-btn');
            const modal = document.getElementById('viewAttachmentFile');
            const attachmentName = document.getElementById('attachment-name');
            const attachmentContent = document.getElementById('attachment-content');

            viewButtons.forEach(button => {
                button.addEventListener('click', () => {
                    // Get the attachment data
                    const name = button.getAttribute('data-attachment-name');
                    const url = button.getAttribute('data-attachment-url');

                    // Set the modal content
                    attachmentName.textContent = name;

                    // Check the type of file and display accordingly
                    if (url.endsWith('.jpg') || url.endsWith('.jpeg') || url.endsWith('.png')) {
                        // Display images directly
                        attachmentContent.innerHTML = `<img src="${url}" alt="${name}" class="w-full h-auto">`;
                    } else if (url.endsWith('.pdf')) {
                        // Display PDFs using an iframe
                        attachmentContent.innerHTML = `<iframe src="${url}" width="100%" height="500px"></iframe>`;
                    } else {
                        // If it's another file type (like .docx or unknown), provide a download link
                        attachmentContent.innerHTML = `<a href="${url}" target="_blank" class="text-blue-500 underline">Download or view ${name}</a>`;
                    }

                    // Show the modal
                    modal.showModal();
                });
            });
        });
    </script>
</x-app-layout>

{{--add assigned user--}}


{{--upload task files--}}
<dialog id="uploadTaskFiles" class="modal">
    <div class="modal-box w-11/12 max-w-5xl space-y-2">
        {{--        <p class="py-4">Click the button below to close</p>--}}
        <h3 class="text-lg font-bold">Upload Task Files</h3>

        <div class="modal-action">
            <form action="{{ route('admin.tasks.store', $task->requirement) }}" class="flex flex-col gap-2 w-full">
                <input type="file" id="attachments" name="attachments" multiple/>

                <div class="text-end">
                    {{--                    <a href="{{ route('admin.tasks.show', $task->id) }}" class="btn btn-sm">Close</a>--}}
                    <button type="button" onclick="uploadTaskFiles.close()" class="btn btn-sm">Close</button>
                    <button type="submit" class="btn btn-sm btn-success text-white">Upload</button>
                </div>
            </form>
        </div>
    </div>
</dialog>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const inputElement = document.querySelector('input[id="attachments"]');

        const pond = FilePond.create(inputElement);

        FilePond.setOptions({
            server: {
                process: '{{ route('admin.file.upload') }}',
                revert: '{{ route('admin.file.revert') }}',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
            },
        });
    });
</script>
