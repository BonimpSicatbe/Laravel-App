{{--
@if($tasks->isempty())
    <div class="text-lg font-semibold text-gray-500 p-4">No task available</div>
@else
    @foreach($tasks as $task)

    @endforeach
@endif
--}}
@if($tasks->isempty())
    @for($i = 0; $i < 3; $i++)
        <div class="flex min-w-[500px] max-w-[500px] flex-col gap-4 rounded-lg border border-gray-500 p-4">
            <div class="flex items-center gap-4">
                <div class="bg-gray-100 h-[48px] w-[48px] shrink-0 rounded-full"></div>
                <div class="flex w-full flex-col gap-4">
                    <div class="flex flex-row justify-between">
                        <div class="text-sm bg-gray-100 h-[20px] w-fit px-4">No tasks available</div>
                        <div class="bg-gray-100 h-[12px] w-[12px]"></div>
                    </div>
                    <div class="flex flex-row items-end justify-between">
                        <div class="bg-gray-100 h-[20px] w-1/2"></div>
                        <div class="bg-gray-100 h-[12px] w-[48px]"></div>
                    </div>
                </div>
            </div>
            <div class="flex flex-row gap-2">
                <div class="bg-gray-100 h-[32px] w-full"></div>
                <div class="bg-gray-100 h-[32px] w-full"></div>
            </div>
        </div>
    @endfor
@else
    @foreach(Auth::user()->tasks as $task)
        <div class="flex min-w-[500px] max-w-[500px] flex-col gap-4 rounded-lg border border-gray-500 p-4">
            <div class="flex flex-row items-center gap-2">
                <i class="fa-solid fa-user-circle text-5xl"></i>
                <div class="flex flex-col overflow-hidden gap-2 w-full">
                    <div class="flex flex-row justify-between text-lg font-bold">
                        <div class="text-lg font-bold truncate">{{ $task->name }}</div>
                        @if($task->status != 'pending')
                            <div class="badge badge-xs badge-success"></div>
                        @endif
                    </div>
                    <div class="flex flex-row justify-between text-sm">
                        <div class="text-sm truncate">{{ $task->description }}</div>
                        <div class="text-sm text-gray-500 text-nowrap">{{ $task->created_at->format('g:m A') }}</div>
                    </div>
                </div>
            </div>

            <div class="flex sm:flex-col md:flex-row gap-2">
                <button type="button" data-task-id="{{ $task->id }}" data-task-name="{{ $task->name }}" data-task-description="{{ $task->description }}" class="grow btn btn-sm btn-outline btn-primary view-task-btn">View</button>
                <button type="button" data-task-id="{{ $task->id }}" data-task-name="{{ $task->name }}" class="grow btn btn-sm btn-outline btn-success hover:text-white upload-files-btn">Upload Files</button>
            </div>
        </div>
    @endforeach

@endif

<!-- View Task Modal -->
<dialog id="viewTaskModal" class="modal">
    <div class="modal-box space-y-2">
        <div class="flex flex-row items-center justify-between">
            <div class="text-lg font-bold">View Task</div>
            <button type="button" data-close class="flex items-center justify-center rounded-full w-[25px] h-[25px] hover:bg-red-50 hover:text-red-500">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="text-sm">Task Name</div>
        <div class="text-lg font-bold task-name"></div>
        <div class="text-sm">Task Description</div>
        <div class="text-lg font-bold task-description"></div>
    </div>
</dialog>

<!-- Submit Task Files Modal -->
<dialog id="submitTaskFilesModal" class="modal">
    <div class="modal-box">
        <div class="flex flex-row items-center justify-between gap-2">
            <div class="text-lg font-bold">Upload Task Files</div>
            <button type="button" data-close class="flex items-center justify-center rounded-full w-[25px] h-[25px] hover:bg-red-50 hover:text-red-500">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="gap-2">
            <div class="text-lg font-bold task-name"></div>
            <div class="task-attachments">
                <!-- You can fetch and list attachments here -->
            </div>
        </div>
    </div>
</dialog>


<script>
    document.addEventListener('DOMContentLoaded', () => {
        // View Task Modal
        const viewTaskModal = document.getElementById('viewTaskModal');
        document.querySelectorAll('.view-task-btn').forEach(button => {
            button.addEventListener('click', () => {
                const taskName = button.getAttribute('data-task-name');
                const taskDescription = button.getAttribute('data-task-description');

                // Inject data into modal
                viewTaskModal.querySelector('.task-name').textContent = taskName;
                viewTaskModal.querySelector('.task-description').textContent = taskDescription;

                // Show modal
                viewTaskModal.showModal();
            });
        });

        // Submit Task Files Modal
        const submitTaskFilesModal = document.getElementById('submitTaskFilesModal');
        document.querySelectorAll('.upload-files-btn').forEach(button => {
            button.addEventListener('click', () => {
                const taskId = button.getAttribute('data-task-id');
                const taskName = button.getAttribute('data-task-name');

                // Set task name in modal
                submitTaskFilesModal.querySelector('.task-name').textContent = taskName;

                // Fetch task attachments (optional: you can fetch this via Ajax if needed)
                // For now, you can render attachments directly in the modal

                // Show modal
                submitTaskFilesModal.showModal();
            });
        });

        // Close modal logic
        document.querySelectorAll('.modal [data-close]').forEach(button => {
            button.addEventListener('click', () => {
                button.closest('dialog').close();
            });
        });
    });
</script>
