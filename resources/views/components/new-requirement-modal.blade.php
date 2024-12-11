<dialog id="newRequirementModal" class="modal">
    <div class="modal-box w-11/12 max-w-5xl bg-white">
        <div class="flex flex-row justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900">Upload New Requirement</h3>
            <button type="button" onclick="newRequirementModal.close()"
                    class="text-xs flex items-center justify-center rounded-full w-5 h-5 hover:bg-red-500 hover:text-white">
                <i class="fa-solid fa-xmark"></i></button>
        </div>
        <form action="{{ route('requirements.store') }}" method="post" class="space-y-4">
            @csrf
            {{--requirement--}}
            <div id="requirementSection" class="space-y-2">
                {{--<div class="text-xl font-bold">Requirement</div>--}}

                <!-- Requirement Fields -->
                <x-text-input type="text" name="requirementName" placeholder="Requirement Name..."/>
                <textarea type="text" name="requirementDescription" placeholder="Requirement Description..."
                          class="border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm w-full"></textarea>
                <x-text-input type="datetime-local" name="requirementDueDate"/>
                <div class="flex flex-row gap-2">

                    <x-select name="selectFrom" id="selectGroup" onchange="sendToChange(this.value)" selectLabel="Sent To:" class="grow transition-all">
                        <option value="course">Course</option>
                        <option value="subject">Subject</option>
                        <option value="position">Position</option>
                    </x-select>
                    <x-select name="selectCourse" id="selectCourse" onchange="displayTaskSection(this)" selectLabel="Select Course" class="hidden w-1/2">
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                        @endforeach
                    </x-select>
                    <x-select name="selectSubject" id="selectSubject" onchange="displayTaskSection(this)" selectLabel="Select Subject" class="hidden w-1/2">
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                        @endforeach
                    </x-select>
                    <x-select name="selectPosition" id="selectPosition" onchange="displayTaskSection(this)" selectLabel="Select Position" class="hidden w-1/2">
                        @foreach($positions as $position)
                            <option value="{{ $position->id }}">{{ $position->name }}</option>
                        @endforeach
                    </x-select>

                </div>
            </div>

            {{--task--}}
            <div id="taskSection" class="hidden space-y-2"> {{--initially hidden--}}
                {{--header w/ create task button--}}
                <div class="flex flex-row justify-between items-center gap-2">
                    <div class="text-lg font-bold">Task</div>
                    <button type="button" class="btn btn-sm btn-outline" onclick="addTask()">
                        <i class="fa-solid fa-plus"></i>
                        <span>Add Task</span>
                    </button>
                </div>

                {{--dynamic task section--}}
                <div id="taskContainer" class="space-y-2">
                    {{--task template to be cloned--}}
                    <div class="task-group space-y-2">
                        <x-text-input type="text" name="taskName[]" id="taskName"
                                      placeholder="Enter Task Name..."></x-text-input>
                        <textarea type="text" name="taskDescription[]" id="taskDescription"
                                  placeholder="Enter Task Description..."
                                  class="border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm w-full"></textarea>
                        <div class="flex flex-row gap-2">
                            {{--                            <x-text-input type="datetime-local" name="taskDueDate[]"/>--}}
                            <x-select selectLabel="Select Priority" name="taskPriority[]" id="selectPriority"
                                      class="w-full">
                                {{--status to automatically be set to (pending)--}}
                                <option value="low" selected>Low</option>
                                <option value="medium">Medium</option>
                                <option value="high">High</option>
                            </x-select>
                        </div>

                        <div class="text-sm font-bold text-nowrap">Attach File/s</div>
                        <div id="fileSection" class="">
                            <input type="file" name="taskFiles[][]"
                                   class="file-input file-input-bordered file-input-sm w-full focus:outline-none focus:ring-green-500 focus:border-green-500"
                                   multiple/>
                        </div>
                        <button type="button" onclick="removeTask(this)" class="btn btn-sm btn-outline btn-error">
                            <i class="fa-solid fa-minus"></i>
                            <span>Remove Task</span>
                        </button>
                    </div>
                </div>

                {{--add another file button--}}
                {{--
                <div id="uploadedFileLists" class="flex flex-col gap-2">
                    <div
                        class="flex flex-row items-center text-sm text-left border border-gray-500 rounded-lg space-x-2 p-2 hover:bg-gray-50 transition-all">
                        <i class="fa-solid fa-file-lines"></i>
                        <span class="grow">Sample file name 1</span>
                        <button onclick="viewUploadedFileModal.showModal()"
                                class="text-green-500 hover:text-green-700 transition-all"><i
                                class="fa-solid fa-eye"></i></button>
                        <button onclick="" class="text-red-500 hover:text-red-700 transition-all"><i
                                class="fa-solid fa-minus"></i></button>
                    </div>
                </div>
                --}}
            </div>

            <!-- Submit Button -->
            <div class="flex flex-row gap-2 justify-end">
                <button type="button" onclick="newRequirementModal.close()" class="btn btn-sm btn-error text-white">
                    Cancel
                </button>
                <button type="submit" class="btn btn-sm btn-success text-white">Confirm</button>
            </div>
        </form>
    </div>

    <div class="modal" role="dialog" id="viewFileModal">
        <div class="modal-box">
            <h3 class="text-lg font-bold">Attachment File Name</h3>
            <p class="py-4">Attachment Content</p> {{--show attachment--}}
            <div class="modal-action">
                <button onclick="newRequirementModal.close()" class="btn">Close</button>
            </div>
        </div>
    </div>
</dialog>
<dialog id="viewUploadedFileModal" class="modal">
    <div class="modal-box min-w-[25%] min-h-[25%] max-h-[80%] max-w-[80%]">
        <div class="text-lg">File Name</div>

        {{--display / preview file content--}}
        <div class=""></div>

        <div class="flex flex-row gap-2">
            <button type="button" onclick="viewUploadedFileModal.close()" class="btn btn-sm btn-outline">Close</button>
            <button type="button" onclick="viewUploadedFileModal.close()" class="btn btn-sm btn-outline">Delete</button>
        </div>
    </div>
</dialog>

<script>
    {{--hide other selects depending on the first select--}}
    function sendToChange(value) {
        const selectCourse = document.getElementById('selectCourse');
        const selectSubject = document.getElementById('selectSubject');
        const selectPosition = document.getElementById('selectPosition');

        switch (value) {
            case 'course':
                selectCourse.classList.remove('hidden');
                selectSubject.classList.add('hidden');
                selectPosition.classList.add('hidden');

                break;
            case 'subject':
                selectCourse.classList.add('hidden');
                selectSubject.classList.remove('hidden');
                selectPosition.classList.add('hidden');

                break;
            case 'position':
                selectCourse.classList.add('hidden');
                selectSubject.classList.add('hidden');
                selectPosition.classList.remove('hidden');

                break;
        }
    }

    function displayTaskSection() {
        document.getElementById('taskSection').classList.remove('hidden');

    }
    function addTask() {
        const taskContainer = document.getElementById('taskContainer');
        const taskGroup = document.querySelector('.task-group').cloneNode(true);
        taskGroup.style.display = 'block';  // Show the cloned element
        taskContainer.appendChild(taskGroup);
    }
    function removeTask(button) {
        button.parentElement.remove()
    }
</script>
