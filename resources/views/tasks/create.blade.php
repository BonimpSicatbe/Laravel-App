<x-app-layout>
    <x-app-header>Create Tasks</x-app-header>

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
    <x-container-section>@include('requirements.partials.requirement-details')</x-container-section>

    {{--input task details--}}
    <x-container-section>
        <form action="{{ route('tasks.store', request()->requirement) }}" method="post" class="flex flex-col gap-4">
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
                <x-select-input name="priority" id="priority" onchange="showSelect2(this.value)" class="capitalize">
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
                <x-input-label for="uploadTaskFile" :value="__('Upload Attachments')"/>
                <input type="file" id="uploadTaskFile" name="uploadTaskFile[]" multiple/>
            </div>

            <div class="flex justify-end items-center gap-2">
                <a href="{{ route('requirements.show', request()->requirement) }}"
                   class="btn btn-sm btn-neutral text-white">Done</a>
                <button type="submit" class="btn btn-sm btn-success text-white">Create Task</button>
            </div>
        </form>
    </x-container-section>

    {{--task lists--}}
    <x-container-section>
        <div class="">
            <div class="text-lg font-bold">Task Lists</div>
            @include('tasks.partials.task-table-lists')
        </div>
    </x-container-section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Get a reference to the file input element
            const inputElement = document.querySelector('input[id="uploadTaskFile"]');

            // Create a FilePond instance
            const pond = FilePond.create(inputElement);

            // Set options for FilePond
            FilePond.setOptions({
                server: {
                    url: '/upload-task-file',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                },
            });
        });
    </script>
</x-app-layout>
