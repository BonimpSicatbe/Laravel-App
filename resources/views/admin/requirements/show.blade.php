<!--
TODO:
    requirements text map
    requirements class map
    sort functionality
    search functionality
-->

<x-app-layout>
    <x-app-header>
        View Requirement
    </x-app-header>

    {{--for error checking todo to be removed--}}
    @if ($errors->any())
        <x-container-section>
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="text-red-500">{{ $error }}</li>
                @endforeach
            </ul>
        </x-container-section>
    @endif

    {{--requirement details--}}
    <x-container-section>
        @include('admin.requirements.partials.requirement-details')
        {{--
            <div class="">
                <x-input-label class="capitalize">attachment lists</x-input-label>
                <div class="max-h-[250px] overflow-y-auto">
                    @for($i = 0; $i < 7; $i++)
                        <div class="rounded-lg p-2 transition-all hover:shadow-lg">Lorem ipsum dolor.</div>
                    @endfor
                </div>
            </div>
        --}}
    </x-container-section>

    {{--task list--}}
    <x-container-section>
        <div class="space-y-2">
            <div class="flex flex-row items-center gap-2">
                {{--label--}}
                <div class="text-md font-bold space-x-2 grow">
                    <i class="fa-regular fa-list"></i>
                    <span>Tasks</span>
                </div>

                {{--new task--}}
                <button name="addTask" id="addTask" onclick="newTaskModal.showModal()"
                        class="btn btn-sm btn-outline">
                    <i class="fa-regular fa-plus"></i>
                    <span>Add Task</span>
                </button>
            </div>

            @include('admin.requirements.partials.requirement-task-table-lists')
        </div>
    </x-container-section>

    {{--assigned users--}}
    <x-container-section>
        <div class="space-y-2">
            <div class="flex flex-row items-center gap-2">
                <div class="text-lg font-bold grow">
                    <i class="fa-regular fa-users"></i>
                    <span>Assigned Users</span>
                </div>

                <button name="addAssignedUser" id="addAssignedUser" onclick="newAssignedUserModal.showModal()"
                        class="btn btn-sm btn-outline">
                    <i class="fa-regular fa-plus"></i>
                    <span>Assign New User</span>
                </button>
            </div>
            @include('admin.requirements.partials.requirement-assigned-users-table-lists')
        </div>
    </x-container-section>

    <dialog id="newTaskModal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box xl:min-w-[50%] sm:min-w-[75%]">
{{--            <div class="text-lg font-bold">Add Task</div>--}}
            <form action="{{ route('admin.tasks.store', request()->requirement) }}" method="post" class="flex flex-col gap-4">
                @csrf
                <div class="text-lg font-bold">Enter Task Details</div>

                <input type="hidden" name="requirement_id" value="{{ $requirement->id }}">
                {{--task name--}}
                <div class="">
                    <x-input-label for="name" :value="__('Name')"/>
                    <x-text-input id="name" class="" type="text" name="name" :value="old('name')" autofocus
                                  autocomplete="name"/>
                    <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                </div>

                {{--task description--}}
                <div class="">
                    <x-input-label for="description" :value="__('Description')"/>
                    <x-textarea id="description" name="description" class="" :value="old('description')" autofocus
                                autocomplete="description"/>
                    <x-input-error :messages="$errors->get('description')" class="mt-2"/>
                </div>

                {{--task priority--}}
                <div class="">
                    <x-input-label for="priority" :value="__('Priority')"></x-input-label>
                    <x-select-input name="priority" id="priority" class="capitalize">
                        <option value="low" class="capitalize" selected>low</option>
                        <option value="medium" class="capitalize">medium</option>
                        <option value="high" class="capitalize">high</option>
                    </x-select-input>
                </div>

                {{--task due date--}}
                <div class="">
                    <x-input-label for="due_date" :value="__('Due Date')"/>
                    <x-text-input id="due_date" class="" type="datetime-local" name="due_date" :value="old('due_date')"
                                  autofocus autocomplete="due_date"/>
                    <x-input-error :messages="$errors->get('due_date')" class="mt-2"/>
                </div>

                <div class="">
                    <x-input-label for="uploadTaskAttachment" :value="__('Upload Attachments')"/>
                    <input type="file" id="uploadTaskAttachment" name="uploadTaskAttachment" multiple/>
                </div>

                <div class="flex justify-end items-center gap-2">
                    <button type="button" onclick="newTaskModal.close()" class="btn btn-sm btn-error text-white">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-success text-white">Create Task</button>
                </div>
            </form>
        </div>
    </dialog>

    <dialog id="newAssignedUserModal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <div class="text-lg font-bold">Add Task</div>
            <form action="{{ route('admin.tasks.store', $requirement->id) }}" method="post" class="space-y-2">
                @csrf
                {{--task priority--}}
                <div class="">
                    <x-input-label for="priority" :value="__('Priority')"></x-input-label>
                    <x-select-input name="priority" id="priority" onchange="showSelect2(this.value)" class="capitalize">
                        <option value="low" class="capitalize" selected>low</option>
                        <option value="medium" class="capitalize">medium</option>
                        <option value="high" class="capitalize">high</option>
                    </x-select-input>
                </div>

                {{--buttons--}}
                <div class="flex flex-row justify-end gap-2">
                    <button type="button" onclick="newAssignedUserModal.close()"
                            class="btn btn-sm btn-error text-white rounded-lg">Cancel
                    </button>
                    <button type="submit" class="btn btn-sm btn-success text-white rounded-lg">Confirm</button>
                </div>
            </form>
        </div>
    </dialog>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Get a reference to the file input element
            const inputElement = document.querySelector('input[id="uploadTaskAttachment"]');

            // Create a FilePond instance
            const pond = FilePond.create(inputElement);

            // Set options for FilePond
            FilePond.setOptions({
                server: {
                    process: {
                        url: '{{ route('admin.tasks.upload') }}',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        onload: (response) => {
                            const { folder } = JSON.parse(response);
                            document.querySelector('input[name="uploadTaskAttachment"]').value = folder;
                        }
                    },
                    revert: './revert.php',
                }
            });
        });

    </script>
</x-app-layout>
