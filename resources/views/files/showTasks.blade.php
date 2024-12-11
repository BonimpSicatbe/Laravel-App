<x-app-layout>
    <x-slot:header>
        <h2 class="font-bold text-xl text-gray-700">
            {{ __($tasks->first()->requirement->name) }} {{-- Access the first task's requirement name --}}
        </h2>
    </x-slot:header>

    <div class="sm:py-6 lg:py-8">
        <div class="container mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                {{-- Content container --}}
                <div class="p-6 bg-white overflow-x-auto border-b border-gray-200 w-full space-y-2">
                    {{-- sort section --}}
                    <div class="flex flex-row gap-2">
                        {{--sort status--}}
                        <x-select class="focus:border-green-500" select-label="Select Status">
                            <option value="pending">Pending</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                        </x-select>

                        {{--search bar--}}
                        <x-text-input class="" placeholder="Search..."/>

                        {{--add new file--}}
                        <button class="btn btn-outline btn-success" onclick="newTaskModal.showModal()">
                            <i class="fa-solid fa-plus"></i>
                            <span>New Task</span>
                        </button>

                    </div>

                    <table class="table table-auto">
                        <thead>
                        <tr>
                            <th class="">Task Name</th>
                            <th class="">Date Modified</th>
                            <th class="">Size</th>
                            <th class="">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tasks as $task)
                            <tr>
                                <td class="space-x-2">
                                    <i class="fa-solid fa-file-lines textl-lg"></i>
                                    <a href="{{ route('tasks.show', $task->id) }}"
                                       class="hover:link">{{ $task->name }}</a>
                                </td>
                                <td>{{ $task->updated_at->format('Y-m-d H:i') }}</td>
                                <td>{{ $task->size }} KB</td> {{-- Adjust this to the actual size field --}}
                                <td class="w-fit inline-flex gap-2">
                                    <button onclick="taskModal.showModal()"
                                            class="text-gray-500 hover:text-green-500 transition-all"><i
                                            class="fa-solid fa-eye"></i></button>
                                    <form action="{{ route('tasks.destroy', $task->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-500 hover:text-red-500 transition-all"><i
                                                class="fa-solid fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{--task modal--}}
    {{-- Task modal --}}
    <dialog id="taskModal" class="modal">
        <div class="modal-box max-w-[50%] h-1/2 space-y-4">
            <h3 class="text-lg font-bold">{{ $task->name }}</h3>
            <p class="">{{ $task->description }}</p>

            {{-- File upload form with preview and edit --}}
            <form id="fileUploadForm" action="{{ route('files.store', $task->id) }}" method="POST"
                  enctype="multipart/form-data">
                @csrf
                <input type="file" id="fileInput" name="files[]" class="file-input file-input-bordered w-full"
                       multiple/>

                <div id="filePreview" class="mt-4">
                    <!-- Preview area for files -->
                </div>

                <button type="submit" class="btn btn-primary mt-2">Upload Files</button>
            </form>

            <div class="modal-action">
                <form method="dialog">
                    <button class="btn btn-sm" onclick="taskModal.close()">Cancel</button>
                </form>
            </div>
        </div>
    </dialog>
    <dialog id="uploadFilesModal" class="modal">
        <div class="modal-box max-w-[50%] h-1/2 space-y-4">
            <h3 class="text-lg font-bold">{{ $task->name }}</h3>
            <p class="">{{ $task->description }}</p>

            {{-- File upload form with preview and edit --}}
            <form id="fileUploadForm" action="{{ route('files.store', $task->id) }}" method="POST"
                  enctype="multipart/form-data">
                @csrf
                <input type="file" id="fileInput" name="files[]" class="file-input file-input-bordered w-full"
                       multiple/>

                <div id="filePreview" class="mt-4">
                    <!-- Preview area for files -->
                </div>

                <button type="submit" class="btn btn-primary mt-2">Upload Files</button>
            </form>

            <div class="modal-action">
                <form method="dialog">
                    <button class="btn btn-sm" onclick="taskModal.close()">Cancel</button>
                </form>
            </div>
        </div>
    </dialog>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const fileInput = document.getElementById('fileInput');
            const filePreview = document.getElementById('filePreview');
            const fileUploadForm = document.getElementById('fileUploadForm');

            fileInput.addEventListener('change', function (event) {
                const files = event.target.files;
                filePreview.innerHTML = ''; // Clear previous previews

                Array.from(files).forEach((file, index) => {
                    const reader = new FileReader();

                    reader.onload = function (e) {
                        const fileContainer = document.createElement('div');
                        fileContainer.classList.add('file-container', 'flex', 'items-center', 'justify-between', 'p-2', 'border', 'border-gray-200', 'rounded', 'mb-2');

                        const fileNameInput = document.createElement('input');
                        fileNameInput.type = 'text';
                        fileNameInput.value = file.name;
                        fileNameInput.classList.add('input', 'input-sm', 'w-2/3');
                        fileNameInput.dataset.index = index; // Store index for later use

                        const fileSize = document.createElement('span');
                        fileSize.textContent = `${(file.size / 1024).toFixed(2)} KB`;
                        fileSize.classList.add('text-sm', 'text-gray-500', 'w-1/3');

                        const removeButton = document.createElement('button');
                        removeButton.textContent = 'Remove';
                        removeButton.type = 'button';
                        removeButton.classList.add('btn', 'btn-xs', 'btn-error');
                        removeButton.addEventListener('click', function () {
                            filePreview.removeChild(fileContainer);
                        });

                        fileContainer.appendChild(fileNameInput);
                        fileContainer.appendChild(fileSize);
                        fileContainer.appendChild(removeButton);
                        filePreview.appendChild(fileContainer);
                    }

                    reader.readAsDataURL(file);
                });
            });

            fileUploadForm.addEventListener('submit', function (event) {
                event.preventDefault();

                const formData = new FormData(this);
                const files = fileInput.files;
                const names = Array.from(filePreview.getElementsByClassName('input')).map(input => input.value);

                Array.from(files).forEach((file, index) => {
                    formData.append(`files[${index}]`, file, names[index] || file.name);
                });

                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Files uploaded successfully.');
                            filePreview.innerHTML = ''; // Clear previews after successful upload
                        } else {
                            alert('An error occurred.');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    </script>

</x-app-layout>
