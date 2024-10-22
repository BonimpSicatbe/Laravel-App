@props(['active' => false, 'iconClass', 'as' => 'a', 'slotLabel' => ''])

@if ($as === 'a')
    <a {{ $attributes->merge(['class' => ($active ? 'bg-green-50 text-gray-800 border-green-500' : 'hover:bg-green-50 hover:text-gray-800 hover:border-green-500') . ' transition-all relative flex flex-row items-center h-10 focus:outline-none text-gray-600 border-l-4 border-transparent pr-6 w-full']) }}>
        <span class="inline-flex justify-center items-center ml-4">
            <i class="{{ $active ? 'fa-solid text-green-900' : 'fa-regular' }} {{ $iconClass }} w-5 h-5"></i>
        </span>
        <span class="ml-2 text-sm tracking-wide truncate">{{ $slotLabel }}</span>
    </a>
@else
    <button {{ $attributes->merge(['class' => ($active ? 'bg-green-50 text-gray-800 border-green-500' : 'hover:bg-green-50 hover:text-gray-800 hover:border-green-500') . ' transition-all relative flex flex-row items-center h-10 focus:outline-none text-gray-600 border-l-4 border-transparent pr-6 w-full']) }}>
        <span class="inline-flex justify-center items-center ml-4">
            <i class="{{ $active ? 'fa-solid text-green-900' : 'fa-regular' }} {{ $iconClass }} w-5 h-5"></i>
        </span>
        <span class="ml-2 text-sm tracking-wide truncate">{{ $slotLabel }}</span>
    </button>
@endif
