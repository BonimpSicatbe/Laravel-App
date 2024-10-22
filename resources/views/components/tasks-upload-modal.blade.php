<!-- resources/views/components/upload-modal.blade.php -->
{{--
TODO:
    upload functionality
    task description in upload modal

--}}
<dialog id="uploadModal" class="modal">
    <div class="modal-box flex flex-col h-[75%] min-w-[75%]">
        <h3 class="text-lg font-medium text-gray-900">Upload New File/s</h3>
        <form id="uploadForm" action="{{ route('files.store') }}" method="POST" enctype="multipart/form-data"
              class="flex flex-col grow overflow-hidden">
            @csrf
            <div class="mt-4">
                <label for="task" class="block text-sm font-medium text-gray-700">Select Task to Upload File/s</label>
                @include('tasks.partials.tasks-upload-modal-options', ['tasks' => $tasks])

                {{-- display the description of the task and its required attachments --}}
                <div id="taskDescription" class=""></div>
            </div>

            <div class="mt-4">
                <label for="files" class="block text-sm font-medium text-gray-700">Choose Files</label>
                <input id="files" name="files[]" type="file" multiple
                       class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100"/>
            </div>

            <div id="fileList" class="grow mt-4 space-y-2 overflow-y-auto">
                <!-- Preview of selected files will be shown here -->
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <button type="button"
                        class="btn btn-sm btn-error text-white"
                        onclick="uploadModal.close()">Cancel
                </button>
                <button type="submit"
                        class="btn btn-sm btn-success text-white"
                        onclick="toggleModal('uploadModal')">Confirm
                </button>
            </div>
        </form>

    </div>
</dialog>


<script>
    document.getElementById('files').addEventListener('change', function (event) {
        const fileList = document.getElementById('fileList');
        fileList.innerHTML = '';
        const files = event.target.files;

        for (let i = 0; i < files.length; i++) {
            const fileItem = document.createElement('div');
            fileItem.classList.add('flex', 'items-center', 'justify-between', 'p-2', 'bg-white', 'border', 'rounded-md');
            fileItem.innerHTML = `
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M6 2C4.895 2 4 2.895 4 4v12c0 1.105.895 2 2 2h8c1.105 0 2-.895 2-2V8l-6-6H6zm3 6h-2v2H6v-2H4v4h2v-2h1v2h2v-4zm3-1V3.5L14.5 7H12z" />
                    </svg>
                    <span class="ml-3 text-sm text-gray-700">${files[i].name}</span>
                </div>
                <button class="text-red-500" onclick="removeFile(${i})">-</button>
            `;
            fileList.appendChild(fileItem);
        }
    });

    function removeFile(index) {
        const filesInput = document.getElementById('files');
        const dt = new DataTransfer();
        const {files} = filesInput;

        for (let i = 0; i < files.length; i++) {
            if (i !== index) {
                dt.items.add(files[i]);
            }
        }

        filesInput.files = dt.files;
        filesInput.dispatchEvent(new Event('change'));
    }
</script>

