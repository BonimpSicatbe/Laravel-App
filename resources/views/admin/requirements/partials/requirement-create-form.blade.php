<form action="{{ route('admin.requirements.store') }}" method="POST" class="flex flex-col gap-4">
    @csrf

    {{--Requirement name--}}
    <div class="">
        <x-input-label for="name" :value="__('Name')"/>
        <x-text-input id="name" type="text" name="name" :value="old('name')" autofocus autocomplete="name"/>
        <x-input-error :messages="$errors->get('name')" class="mt-2"/>
    </div>

    {{--Requirement description--}}
    <div class="">
        <x-input-label for="description" :value="__('Description')"/>
        <x-textarea id="description" name="description" :value="old('description')" autofocus autocomplete="description"/>
        <x-input-error :messages="$errors->get('description')" class="mt-2"/>
    </div>

    {{--Requirement due date--}}
    <div class="">
        <x-input-label for="due_date" :value="__('Due Date')"/>
        <x-text-input
            id="due_date"
            type="datetime-local"
            name="due_date"
            :value="old('due_date', now()->format('Y-m-d\TH:i'))"
            min="{{ now()->format('Y-m-d\TH:i') }}"
            autofocus
            autocomplete="due_date"
        />
        <x-input-error :messages="$errors->get('due_date')" class="mt-2"/>
    </div>

    {{--Select Group--}}
    <div id="select_group_section" class="">
        <x-input-label for="select_group" :value="__('Send To:')"></x-input-label>
        <x-select-input name="select_group" id="select_group" onchange="showSelectGroup()" class="capitalize">
            <option value="" selected disabled>Select Group</option>
            <option value="all" class="capitalize">Select All</option>
            <option value="course" class="capitalize">Course</option>
            <option value="subject" class="capitalize">Subject</option>
            <option value="position" class="capitalize">Position</option>
        </x-select-input>
        <x-input-error :messages="$errors->get('select_group')" class="mt-2"/>
    </div>

    {{--Select Course--}}
    <div id="select_course_section" class="hidden">
        <x-input-label for="selected_course" :value="__('Select Course:')"></x-input-label>
        <x-select-input name="select_target_group" id="select_course" class="capitalize" onchange="showSelectGroup()">
            <option value="" selected disabled>Select Course</option>
            @foreach($courses as $course)
                <option value="{{ $course->id }}" class="capitalize">{{ $course->name }}</option>
            @endforeach
        </x-select-input>
        <x-input-error :messages="$errors->get('select_target_group')" class="mt-2"/>
    </div>

    {{--Select Subject--}}
    <div id="select_subject_section" class="hidden">
        <x-input-label for="selected_subject" :value="__('Select Subject:')"></x-input-label>
        <x-select-input name="select_target_group" id="select_subject" class="capitalize" onchange="showSelectGroup()">
            <option value="" selected disabled>Select Subject</option>
            @foreach($subjects as $subject)
                <option value="{{ $subject->id }}" class="capitalize">{{ $subject->name }}</option>
            @endforeach
        </x-select-input>
        <x-input-error :messages="$errors->get('select_target_group')" class="mt-2"/>
    </div>

    {{--Select Position--}}
    <div id="select_position_section" class="hidden">
        <x-input-label for="selected_position" :value="__('Select Position:')"></x-input-label>
        <x-select-input name="select_target_group" id="select_position" class="capitalize" onchange="showSelectGroup()">
            <option value="" selected disabled>Select Position</option>
            @foreach($positions as $position)
                <option value="{{ $position->id }}" class="capitalize">{{ $position->name }}</option>
            @endforeach
        </x-select-input>
        <x-input-error :messages="$errors->get('select_target_group')" class="mt-2"/>
    </div>

    {{--upload syllabus--}}
    <div class="">
        <x-input-label for="attachments" :value="__('Attachments:')"/>
        <input type="file" name="attachments[]" id="attachments" multiple>
    </div>

    <div class="flex justify-end items-center gap-2">
        <button type="button" class="btn btn-sm btn-neutral text-white" onclick="create_requirement.close()">Cancel</button>
        <button type="submit" class="btn btn-sm btn-success text-white">Create</button>
    </div>
</form>

<script>
    function showSelectGroup() {
        const selectGroup = document.getElementById('select_group').value;
        const select_course = document.getElementById('select_course_section');
        const select_subject = document.getElementById('select_subject_section');
        const select_position = document.getElementById('select_position_section');

        const courseDropdown = document.getElementById('select_course');
        const subjectDropdown = document.getElementById('select_subject');
        const positionDropdown = document.getElementById('select_position');

        if (selectGroup === 'all') {
            select_course.classList.add('hidden');
            select_subject.classList.add('hidden');
            select_position.classList.add('hidden');

            // Disable all dropdowns
            courseDropdown.disabled = true;
            subjectDropdown.disabled = true;
            positionDropdown.disabled = true;
        } else if (selectGroup === 'course') {
            select_course.classList.remove('hidden');
            select_subject.classList.add('hidden');
            select_position.classList.add('hidden');

            // Enable only the course dropdown
            courseDropdown.disabled = false;
            subjectDropdown.disabled = true;
            positionDropdown.disabled = true;
        } else if (selectGroup === 'subject') {
            select_course.classList.add('hidden');
            select_subject.classList.remove('hidden');
            select_position.classList.add('hidden');

            // Enable only the subject dropdown
            courseDropdown.disabled = true;
            subjectDropdown.disabled = false;
            positionDropdown.disabled = true;
        } else if (selectGroup === 'position') {
            select_course.classList.add('hidden');
            select_subject.classList.add('hidden');
            select_position.classList.remove('hidden');

            // Enable only the position dropdown
            courseDropdown.disabled = true;
            subjectDropdown.disabled = true;
            positionDropdown.disabled = false;
        }
    }
</script>
