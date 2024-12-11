@props(['disabled' => false])

<textarea {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'textarea textarea-bordered h-24 w-full']) !!}>{{ $slot }}</textarea>

