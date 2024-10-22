<x-app-layout>
    <x-app-header>
        Tasks List
    </x-app-header>


    <x-container-section class="overflow-hidden">
        @include('tasks.partials.task-table-lists')
    </x-container-section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const successMessage = document.getElementById('success-message');
            if (successMessage) {
                // Apply the transition style for opacity
                successMessage.style.transition = 'opacity 1s ease-out';

                // After 5 seconds, start fading out
                setTimeout(() => {
                    successMessage.style.opacity = '0';
                }, 3000); // Wait 3 seconds before starting the fade-out

                // After the fade-out, set display to none
                setTimeout(() => {
                    successMessage.style.display = 'none';
                }, 4000); // 3s delay + 1s fade-out duration
            }
        });

        // Enable scroll restoration so that the page maintains its scroll position
        if ('scrollRestoration' in history) {
            history.scrollRestoration = 'manual';
        }

        // Preserve scroll position on page reloads
        window.addEventListener('beforeunload', function () {
            localStorage.setItem('scrollPos', window.scrollY);
        });

        window.addEventListener('load', function () {
            if (localStorage.getItem('scrollPos')) {
                window.scrollTo(0, localStorage.getItem('scrollPos'));
                localStorage.removeItem('scrollPos');
            }
        });

        $(document).ready(function () {
            // Handle input event for live search
            $('#search-input').on('input', function () {
                let query = $(this).val();
                $.ajax({
                    url: '{{ route('requirements.index') }}',
                    method: 'GET',
                    data: {name: query},
                    success: function (response) {
                        // Replace the table body with new rows
                        $('#requirements-tbody').html(response);
                    }
                });
            });
        });
    </script>
</x-app-layout>
