<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('font-awesome-6-pro-main/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('filepond-master/dist/filepond.min.css') }}">

    <style>
        .fade-out {
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }
    </style>
</head>
<body class="font-sans antialiased">
<div class="min-h-screen bg-gray-100">
    <!-- Page Content -->
    <main>
        <div class="flex flex-row absolute w-full h-full">
            {{--sidebar--}}
            @if(Auth::user()->hasAnyRole('admin|super-admin'))
                <div class="flex flex-col relative w-fit">@include('admin.layouts.navigation')</div>
            @else
                <div class="flex flex-col relative w-fit">@include('user.layouts.navigation')</div>
            @endif

            <div class="flex flex-col h-full w-full gap-4 relative bg-gray-100">
                {{--interface section--}}
                @isset($header)
                    <header class="bg-white shadow">
                        <div class="container px-6 lg:px-8 flex items-center mx-auto w-full h-14">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <div class="overflow-y-auto h-full pb-4 space-y-4">
                    @if (session('success'))
                        <x-container-section id="success-message">
                            {{ session('success') }}
                        </x-container-section>
                    @endif

                    {{--content section--}}
                    {{ $slot }}
                </div>
            </div>
        </div>
    </main>
</div>

<script src="{{ asset('filepond-master/dist/filepond.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const successMessage = document.getElementById('success-message');

        if (successMessage) {
            // Wait 3 seconds before fading out
            setTimeout(function () {
                successMessage.classList.add('fade-out');
            }, 3000); // 3 seconds delay

            // Optionally remove the element after the fade-out is complete
            setTimeout(function () {
                successMessage.remove();
            }, 4000); // 4 seconds to ensure fade-out completes
        }

        /*
        *
        * FILEPOND SCRIPT
        *
        * */

        {{--const inputElement = document.querySelector('input[type="file"]');--}}
        {{--const pond = FilePond.create(inputElement);--}}

        {{--pond.getFiles();--}}

        {{--FilePond.setOptions({--}}
        {{--    server: {--}}
        {{--        process: '{{ route('tmp_upload') }}',--}}
        {{--        revert: '{{ route('tmp_revert') }}',--}}
        {{--        headers: {--}}
        {{--            'X-CSRF-TOKEN': '{{ csrf_token() }}'--}}
        {{--        },--}}
        {{--    },--}}
        {{--});--}}
    });
</script>

</body>
</html>
