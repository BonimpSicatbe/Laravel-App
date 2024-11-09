{{-- todo: turn labels into variables, if attachment none, display none --}}

{{--@foreach($notificationRequirements as $notificationRequirement)--}}

    <button
        class="flex flex-row items-center rounded-lg border border-gray-500 gap-4 py-2 px-4 hover:bg-green-100 hover:shadow-lg transition-all"
        onclick="modal.showModal()">
        <i class="fa-solid fa-file-pdf text-3xl"></i>
        <div class="flex flex-col grow text-left overflow-hidden">
            <div class="text-md font-bold truncate">Requirement File Name</div>
            <div class="text-sm truncate">Requirement File Size</div>
        </div>
    </button>
    <dialog id="modal" class="modal">
        <div class="modal-box sm:w-[75%] sm:h-[75%]">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"><i class="fa-solid fa-xmark"></i>
                </button>
            </form>
            <h3 class="text-lg font-bold">Hello!</h3>
            <p class="py-4">Press ESC key or click on ✕ button to close</p>
        </div>
    </dialog>

{{--@endforeach--}}
