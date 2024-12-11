<x-app-layout>
    <x-slot:header>
        <h2 class="font-bold text-xl text-gray-700">
            {{ __('Upload New File') }}
        </h2>
    </x-slot:header>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="sm:py-6 lg:py-8">
        <div class="container mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white overflow-x-auto border-b border-gray-200 w-full space-y-2">

                    {{-- create new file form modal --}}
                    <form action="{{ route('files.store') }}" method="POST" enctype="multipart/form-data"
                          class="flex flex-col w-full space-y-2 h-[500px]">
                        @csrf

                        <h1 class="text-lg font-bold">Upload New File/s</h1>

                        <x-select class="w-full" select-label="Select Task to Upload File/s">
                            <option value="">Sample Task</option>
                        </x-select>

                        <input type="file" class="file-input file-input-bordered file-input-success w-full"/>

                        <div class="grow overflow-y-auto space-y-2">
                            @for($i = 0; $i < 7; $i++)
                                <div class="">
                                    <div
                                        class="flex flex-row py-2 px-4 gap-4 items-center border border-gray-500 rounded-lg">
                                        <i class="fa-solid fa-file-lines text-2xl"></i>
                                        <div class="text-lg grow truncate">Lorem ipsum dolor sit amet, consectetur.
                                        </div>

                                        {{-- action button --}}
                                        <a href="" class="rounded-lg px-2 hover:bg-red-200 hover:text-red-500"><i
                                                class="fa-solid fa-minus"></i></a>
                                    </div>
                                </div>
                            @endfor

                        </div>

                        <div class="flex flex-row justify-end gap-2">
                            <button class="btn btn-outline btn-sm btn-error">Cancel</button>
                            <button class="btn btn-success btn-sm text-white">Confirm</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
