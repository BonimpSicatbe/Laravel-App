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
                    @foreach($requirement->tasks as $task)
                        <tr>
                            <td><i class="fa-solid fa-folder text-xl"></i></td>
                            <td><a href="{{ route('admin.tasks.show', $task->id) }}"
                                   class="hover:link">{{ $task->name }}</a></td>
                            <td>{{ $task->created_at->format('h:i A') }}</td>
                            <td></td>
                            <td class="">
                                <div class="dropdown dropdown-top dropdown-end">
                                    <div tabindex="0" role="button" class="px-1"><i
                                            class="fa-solid fa-ellipsis-vertical"></i></div>
                                    <ul tabindex="0"
                                        class="dropdown-content menu bg-base-100 rounded-box z-[1] w-52 p-2 shadow">
                                        <li>
                                            <a href="{{ route('admin.tasks.show', $task->id) }}"
                                               class="flex flex-row gap-2 text-green-500 hover:text-green-700">
                                                <i class="fa-solid fa-eye"></i>
                                                <span>View</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="" class="flex flex-row gap-2 text-blue-500 hover:text-blue-700">
                                                <i class="fa-solid fa-arrow-down-to-line"></i>
                                                <span>Download</span>
                                            </a>
                                        </li>
                                        <li>
                                            <form action="{{ route('admin.tasks.destroy', $task->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="flex flex-row gap-2 text-red-500 hover:text-red-700 w-full">
                                                    <i class="fa-solid fa-trash"></i>
                                                    <span>Delete</span>
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
