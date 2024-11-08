<select id="task" name="task"
        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm rounded-md">
    @foreach($tasks as $task)
        <option value="{{ $task->name }}">{{ $task->name }}</option>
    @endforeach
</select>
