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
        @include('admin.requirements.partials.requirement-create-form', ['courses' => $courses, 'subjects' => $subjects, 'positions' => $positions])
    </x-container-section>
</x-app-layout>
