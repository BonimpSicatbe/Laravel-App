<x-app-layout>
    <x-app-header>Create Requirement</x-app-header>

    @if ($errors->any())
        <x-container-section>
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="text-red-500">{{ $error }}</li>
                @endforeach
            </ul>
        </x-container-section>
    @endif

    <x-container-section>
        <form action="{{ route('requirements.store') }}" method="POST" class="flex flex-col gap-4">
            @csrf

            {{-- Requirement name --}}
            <div class="">
                <x-input-label for="name" :value="__('Name')"/>
                <x-text-input id="name" type="text" name="name" :value="old('name')" autofocus autocomplete="name"/>
                <x-input-error :messages="$errors->get('name')" class="mt-2"/>
            </div>

            {{-- Requirement description --}}
            <div class="">
                <x-input-label for="description" :value="__('Description')"/>
                <x-textarea id="description" name="description" :value="old('description')" autofocus autocomplete="description"/>
                <x-input-error :messages="$errors->get('description')" class="mt-2"/>
            </div>

            {{-- Requirement due date --}}
            <div class="">
                <x-input-label for="due_date" :value="__('Due Date')"/>
                <x-text-input id="due_date" type="datetime-local" name="due_date" :value="old('due_date')" autofocus autocomplete="due_date"/>
                <x-input-error :messages="$errors->get('due_date')" class="mt-2"/>
            </div>

            {{-- Select Group --}}
            <div id="select_group_section" class="">
                <x-input-label for="select_group" :value="__('Send To:')"></x-input-label>
                <x-select-input name="select_group" id="select_group" onchange="showSelectGroup()" class="capitalize">
                    <option value="" selected>Select Group</option>
                    <option value="all" class="capitalize">Select All</option>
                    <option value="course" class="capitalize">Course</option>
                    <option value="subject" class="capitalize">Subject</option>
                    <option value="position" class="capitalize">Position</option>
                </x-select-input>
            </div>

            {{-- Select Course --}}
            <div id="select_course_section" class="hidden">
                <x-input-label for="selected_course" :value="__('Select Course:')"></x-input-label>
                <x-select-input name="selected_course" id="select_course" class="capitalize">
                    <option value="" selected>Select Course</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" class="capitalize">{{ $course->name }}</option>
                    @endforeach
                </x-select-input>
            </div>

            {{-- Select Subject --}}
            <div id="select_subject_section" class="hidden">
                <x-input-label for="selected_subject" :value="__('Select Subject:')"></x-input-label>
                <x-select-input name="selected_subject" id="select_subject" class="capitalize">
                    <option value="" selected>Select Subject</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" class="capitalize">{{ $subject->name }}</option>
                    @endforeach
                </x-select-input>
            </div>

            {{-- Select Position --}}
            <div id="select_position_section" class="hidden">
                <x-input-label for="selected_position" :value="__('Select Position:')"></x-input-label>
                <x-select-input name="selected_position" id="select_position" class="capitalize">
                    <option value="" selected>Select Position</option>
                    @foreach($positions as $position)
                        <option value="{{ $position->id }}" class="capitalize">{{ $position->name }}</option>
                    @endforeach
                </x-select-input>
            </div>

            <div class="flex justify-end items-center gap-2">
                <a href="{{ route('requirements.index') }}" class="btn btn-sm btn-error text-white">Cancel</a>
                <button type="submit" class="btn btn-sm btn-success text-white">Create Requirement</button>
            </div>
        </form>
    </x-container-section>

    <script>
        function showSelectGroup() {
            const selectGroup = document.getElementById('select_group').value;
            const courseSection = document.getElementById('select_course_section');
            const subjectSection = document.getElementById('select_subject_section');
            const positionSection = document.getElementById('select_position_section');

            // Hide all sections initially
            courseSection.classList.add('hidden');
            subjectSection.classList.add('hidden');
            positionSection.classList.add('hidden');

            // Show the selected section
            switch (selectGroup) {
                case 'course':
                    courseSection.classList.remove('hidden');
                    break;
                case 'subject':
                    subjectSection.classList.remove('hidden');
                    break;
                case 'position':
                    positionSection.classList.remove('hidden');
                    break;
            }
        }
    </script>

</x-app-layout>
