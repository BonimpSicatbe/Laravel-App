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
        @include('user.requirements.partials.requirement-details')
    </x-container-section>
    
    {{--attachments--}}
    <x-container-section>
        <div class="text-lg font-bold">Attachments</div>
        <div class="overflow-y-auto max-h-[250px]">
            @include('user.requirements.partials.requirement-attachments-list')
        </div>
    </x-container-section>

    {{--files uploaded--}}
    <x-container-section>
        <div class="text-lg font-bold">Files Uploaded</div>
        <div class="overflow-y-auto max-h-[250px]">
            @include('user.requirements.partials.requirement-files-uploaded')
        </div>
    </x-container-section>
</x-app-layout>
