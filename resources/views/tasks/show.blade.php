<x-app-layout>
    <x-app-header>Show Task</x-app-header>

    {{--details--}}
    <x-container-section>
        {{--details--}}
        <div class="grid sm:grid-cols-1 lg:grid-cols-2 gap-4">
            {{--name--}}
            <div class="col-span-2 flex flex-row justify-between items-center">
                <div class="">
                    <x-input-label>{{ ucwords($task->requirement->name) }}</x-input-label>
                    <div class="text-xl font-bold">{{ ucwords($task->name) }}</div>
                </div>
                <a href="{{ route('tasks.edit', $task->id) }}" class="text-blue-500 hover:text-blue-700 transition-all">
                    <i class="fa-regular fa-edit"></i>
                    <span>Edit</span>
                </a>
            </div>

            {{--created at--}}
            <div class="">
                <x-input-label class="capitalize">created at</x-input-label>
                <div class="text-md capitalize">{{ $task->created_at->format('M, d Y - H:i A') }}</div>
            </div>
            {{--updated at--}}
            <div class="">
                <x-input-label class="capitalize">updated at</x-input-label>
                <div class="text-md capitalize">{{ $task->updated_at->format('M, d Y - H:i A') }}</div>
            </div>
            {{--due date--}}
            <div class="">
                <x-input-label class="capitalize">due date</x-input-label>
                <div class="text-md capitalize">{{ $task->due_date->format('M, d Y - H:i A') }}</div>
            </div>
            {{--updated by--}}
            <div class="">
                <x-input-label class="capitalize">updated by</x-input-label>
                <div class="text-md capitalize">{{ $task->updatedBy->name }}</div>
            </div>
            {{--created by / assigned by--}}
            <div class="">
                <x-input-label class="capitalize">created by / assigned by</x-input-label>
                <div class="text-md capitalize">{{ $task->createdBy->name }}</div>
            </div>
            {{--status--}}
            <div class="">
                <x-input-label class="capitalize">status</x-input-label>
                <div class="text-md capitalize">{{ $task->status }}</div>
            </div>
            {{--priority--}}
            <div class="">
                <x-input-label class="capitalize">priority</x-input-label>
                <div class="text-md capitalize">{{ $task->priority }}</div>
            </div>
            {{--description--}}
            <div class="col-span-2">
                <x-input-label class="capitalize">description</x-input-label>
                <div class="text-md normal-case">{{ $task->description }}</div>
            </div>
        </div>
        {{--attachments--}}
        <div class="">
            <x-input-label class="capitalize">attachments</x-input-label>
            @if($task->attachments->isEmpty())
                <div class="text-md font-normal border border-gray-500 rounded-lg p-2">No Attachments.</div>
            @else
                @foreach($task->attachments as $attachment)
                    <div class="text-md font-normal border border-gray-500 rounded-lg p-2">{{ $attachment->name }}</div>
                @endforeach
            @endif
        </div>

    </x-container-section>

    {{--uploaded files--}}
    <x-container-section>
        {{--name--}}
        <div class="text-lg font-bold">
            <i class="fa-regular fa-file-alt mr-2"></i>
            <span>Uploaded Files</span>
        </div>

        {{--file attachments--}}
        <div class="flex flex-col gap-2 overflow-y-auto max-h-[500px]">
            <!--
            {{-- sort section --}}
            <div class="flex flex-row gap-2">
                {{--sort status--}}
            <x-select-input class="focus:border-green-500" select-label="Select Status">
                <option value="pending">Pending</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
            </x-select-input>

{{--sort status--}}
            <x-select-input class="focus:border-green-500" select-label="Select Status">
                <option value="pending">Pending</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
            </x-select-input>

{{--search bar--}}
            <x-text-input class="" placeholder="Search..."/>

{{--add new file--}}
            <button class="btn btn-outline btn-success" onclick="newRequirementModal.showModal()">
                <i class="fa-solid fa-plus"></i>
                <span>New Requirement</span>
            </button>

        </div>
-->
            {{--table--}}
            @include('tasks.partials.tasks-uploaded-file-table-lists')
        </div>
    </x-container-section>

    {{--admin - included users list--}}
    <x-container-section>
        <div class="text-lg font-bold">
            <i class="fa-regular fa-users mr-2"></i>
            <span>Assigned Users</span>
        </div>
        @include('requirements.partials.requirement-assigned-users-table-lists')
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
