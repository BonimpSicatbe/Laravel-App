<x-app-layout>
    <x-slot:header>
        <h2 class="font-bold text-xl text-gray-700">
            {{ __($requirement->name) }}
        </h2>
    </x-slot:header>
    <div class="sm:py-6 lg:py-8">
        <div class="container mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                {{--content container--}}
                <div class="p-6 bg-white overflow-x-auto border-b border-gray-200 w-full space-y-2">
                    {{--header action section--}}
                    <div class="flex flex-row gap-2">
                        {{--filter file type--}}
                        <x-select class="focus:border-green-500" select-label="Type">
                            <option value="pdf">PDF</option>
                            <option value="png">PNG</option>
                            <option value="jpeg">JPEG</option>
                        </x-select>

                        {{--filter modified--}}
                        <x-select class="focus:border-green-500" select-label="Modified">
                            <option value="">PDF</option>
                            <option value="">PNG</option>
                            <option value="">JPEG</option>
                        </x-select>

                        {{--filter search--}}
                        <x-text-input class="" placeholder="Search..."/>

                        {{--add new file--}}
                        <button class="btn btn-outline btn-success" onclick="uploadModal.showModal()">
                            <i class="fa-solid fa-plus"></i>
                            <span>Add File</span>
                        </button>
                    </div>

                    <table class="table table-auto">
                        <thead>
                        <tr>
                            <th class="w-fit"></th>
                            <th class="w-3/5">Name</th>
                            <th class="w-1/5">Date Modified</th>
                            <th class="w-1/5">Size</th>
                            <th class="w-fit"><i class="fa-solid fa-ellipsis-vertical"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        @include('tasks.partials.show-requirement-lists', ['requirement' => $requirement])
                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
