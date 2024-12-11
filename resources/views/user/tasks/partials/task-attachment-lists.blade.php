@if($task->attachments->isEmpty())
    <div class="text-md font-normal border border-gray-500 rounded-lg p-2">No Attachments.</div>
@else
    @foreach($task->attachments as $attachment)
        <div class="text-md font-normal border border-gray-500 rounded-lg p-2">{{ $attachment->name }}</div>
    @endforeach
@endif
