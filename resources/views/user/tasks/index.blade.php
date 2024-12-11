<x-app-layout>
    <x-app-header>
        Tasks List
    </x-app-header>
    
    <x-container-section class="overflow-hidden">
        @include('user.tasks.partials.task-table-lists')
    </x-container-section>
</x-app-layout>
