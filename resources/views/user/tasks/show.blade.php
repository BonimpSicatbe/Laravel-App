<x-app-layout>
    <x-app-header>Show Task</x-app-header>

    {{--details--}}
    <x-container-section>
        {{--details--}}
        @include('user.tasks.partials.task-requirement-details')

        {{--attachments--}}
        <div class="">
            <x-input-label class="capitalize">attachments</x-input-label>
            @include('user.tasks.partials.task-attachment-lists')
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
            {{--table--}}
            @include('user.tasks.partials.tasks-uploaded-file-table-lists')
        </div>
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
