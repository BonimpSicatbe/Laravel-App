<div class="grid xs:grid-cols-2 sm:grid-cols-3 gap-4 w-full">
    <div class="text-center shadow rounded-lg p-4">
        <div class="text-gray-400">Requirements</div>
        <div class="stat-value text-primary">{{ $total_requirements->count() }}</div>
    </div>

    <div class="text-center shadow rounded-lg p-4">
        <div class="text-gray-400">Tasks</div>
        <div class="stat-value text-primary">{{ $total_tasks->count() }}</div>
    </div>

    <div class="text-center shadow rounded-lg p-4">
        <div class="text-gray-400">Files</div>
        <div class="stat-value text-primary">{{ $total_attachments->count() }}</div>
    </div>

    <div class="text-center shadow rounded-lg p-4">
        <div class="text-gray-400">Pending Tasks</div>
        <div class="stat-value text-primary">{{ $total_attachments->count() }}</div>
    </div>

    <div class="text-center shadow rounded-lg p-4">
        <div class="text-gray-400">In Progress Tasks</div>
        <div class="stat-value text-primary">{{ $total_attachments->count() }}</div>
    </div>

    <div class="text-center shadow rounded-lg p-4">
        <div class="text-gray-400">Completed Tasks</div>
        <div class="stat-value text-primary">{{ $total_attachments->count() }}</div>
    </div>
</div>
