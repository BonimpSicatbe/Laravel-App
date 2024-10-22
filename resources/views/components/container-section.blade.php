{{--<div class="sm:py-6 lg:py-8">--}}
<div {{ $attributes->merge(['class' => 'container mx-auto sm:px-6 lg:px-8']) }}>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div  class="p-6 bg-white border-b border-gray-200 w-full space-y-6">
            {{ $slot }}
        </div>
    </div>
</div>
