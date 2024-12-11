<div id="gridView" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    @foreach($requirements as $requirement)
        <div class="p-4 bg-white rounded-lg shadow-lg">
            <img src="{{ $requirement->image_path }}" alt="{{ $requirement->name }}" class="w-full h-40 object-cover rounded mb-2">
            <h3 class="text-xl font-bold">{{ $requirement->name }}</h3>
            <p class="text-gray-600">{{ $requirement->description }}</p>
            <p class="text-gray-600">Due Date: {{ $requirement->due_date }}</p>
            <p class="text-gray-600">Status: {{ $requirement->status }}</p>
        </div>
    @endforeach
</div>
