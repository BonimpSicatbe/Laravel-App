<x-app-layout>
    <x-slot:header>
        <h2 class="font-bold text-xl text-gray-700">
            {{ __('Tasks List') }}
        </h2>
    </x-slot:header>

    <div class="sm:py-6 lg:py-8">
        <div class="container mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 w-full space-y-2">
                    {{--table sort--}}
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
                        <button class="btn btn-outline btn-success" onclick="newRequirementModal.showModal()">
                            <i class="fa-solid fa-plus"></i>
                            <span>New Requirement</span>
                        </button>
                    </div>

                    <table class="table table-auto">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Created at</th>
                            <th>Due Date</th>
                            <th>Created by</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @if($tasks->isEmpty())
                            <tr>
                                <td>Tasks is empty.</td>
                            </tr>
                        @else
                            @foreach($tasks as $task)
                                <tr>
                                    <td class="text-nowrap"><a href="{{ route('admin.tasks.show', $task->id) }}"
                                                               class="hover:link">{{ $task->name }}</a></td>
                                    <td class="text-nowrap">{{ $task->created_at->format('M, d Y - h:i A') }}</td>
                                    <td class="text-nowrap">{{ $task->due_date->format('M, d Y - h:i A') }}</td>
                                    <td class="text-nowrap">{{ $task->createdBy->name }}</td>
                                    <td class="inline-flex gap-2">
                                        <a href="{{ route('admin.tasks.show', $task->id) }}" class="text-green-500 tooltip"
                                           data-tip="View"><i class="fa-regular fa-eye"></i></a>
                                        <a href="{{ route('admin.tasks.edit', $task->id) }}" class="text-blue-500 tooltip"
                                           data-tip="Edit"><i class="fa-regular fa-edit"></i></a>
                                        <button onclick="uploadFilesModal.showModal({{ $task }})"
                                                class="text-orange-500 hover:text-orange-700 transition-all tooltip"
                                                data-tip="Upload Files"><i class="fa-regular fa-upload"></i></button>
                                        <form id="delete-task-form" action="{{ route('admin.tasks.destroy', $task->id) }}"
                                              method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 tooltip" data-tip="Delete"
                                                    onclick="confirm('Are you sure you want to delete this task? This cannot be undone.')">
                                                <i class="fa-regular fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <dialog id="uploadFilesModal" class="modal">
        <div class="modal-box max-w-[50%] h-1/2 space-y-4">

            @if($tasks->isEmpty())
                <div class="text-lg">There are no tasks.</div>
            @else
                @foreach($task->attachments as $attachment)
                    <div class="text-lg">{{ $attachment->name }}</div>
                @endforeach
                <h3 class="text-lg font-bold">{{ $task->name }}</h3>
                <p class="">{{ $task->description }}</p>

                {{-- File upload form with preview and edit --}}
                <form id="fileUploadForm" action="{{ route('admin.files.store', $task->id) }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <input type="file" id="fileInput" name="files[]" class="file-input file-input-bordered w-full"
                           multiple/>

                    <div id="filePreview" class="mt-4">
                        <!-- Preview area for files -->
                    </div>

                    <button type="submit" class="btn btn-primary mt-2">Upload Files</button>
                </form>
            @endif

            <div class="modal-action">
                <form method="dialog">
                    <button class="btn btn-sm" onclick="taskModal.close()">Cancel</button>
                </form>
            </div>
        </div>
    </dialog>
</x-app-layout>
