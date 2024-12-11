<x-app-layout>
    <x-app-header>View Task</x-app-header>
    @if ($errors->any())
        <x-container-section>
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="text-red-500">{{ $error }}</li>
                @endforeach
            </ul>
        </x-container-section>
    @endif
    <x-container-section>
        <div class="">
            <x-input-label>From Requirement</x-input-label>
            <div class="text-lg font-bold">{{ $task->requirement->name }}</div>
        </div>
        <form action="{{ route('admin.tasks.update', $task->id) }}" method="post" class="space-y-4">
            @csrf
            @method('patch')
            <div class="grid grid-cols-2 gap-4">
                {{--name--}}
                <div class="col-span-2">
                    <x-input-label for="name" :value="__('Name')"/>
                    <x-text-input id="name" type="text" name="name" :value="old('name', $task->name)" autofocus
                                  autocomplete="name"/>
                    <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                </div>

                {{--created at--}}
                <div class="">
                    <x-input-label for="created_at" :value="__('Created At')"/>
                    <x-text-input id="created_at" type="datetime-local" name="created_at"
                                  :value="old('created_at', $task->created_at)" autofocus autocomplete="created_at"
                                  disabled/>
                    <x-input-error :messages="$errors->get('created_at')" class="mt-2"/>
                </div>

                {{--updated at--}}
                <div class="">
                    <x-input-label for="updated_at" :value="__('Updated At')"/>
                    <x-text-input id="updated_at" type="datetime-local" name="updated_at"
                                  :value="old('updated_at', $task->updated_at)" autofocus autocomplete="updated_at"
                                  disabled/>
                    <x-input-error :messages="$errors->get('updated_at')" class="mt-2"/>
                </div>

                {{--created by / assigned by--}}
                <div class="">
                    <x-input-label for="created_by" :value="__('Created By')"/>
                    <x-text-input id="created_by" type="text" name="created_by"
                                  :value="old('created_by', $task->createdBy->name)" autofocus
                                  autocomplete="created_by" disabled/>
                    <x-input-error :messages="$errors->get('created_by')" class="mt-2"/>
                </div>

                {{--updated by--}}
                <div class="">
                    <x-input-label for="updated_by" :value="__('Updated By')"/>
                    <x-text-input id="updated_by" type="text" name="updated_by"
                                  :value="old('updated_by', $task->updatedBy->name)" autofocus
                                  autocomplete="updated_by" disabled/>
                    <x-input-error :messages="$errors->get('updated_by')" class="mt-2"/>
                </div>

                {{--status--}}
                <div class="col-span-2">
                    <x-input-label for="status" :value="__('Status')"/>
                    <x-text-input id="status" type="text" name="status" :value="old('status', $task->status)" autofocus
                                  autocomplete="status" class="capitalize" disabled/>
                    <x-input-error :messages="$errors->get('status')" class="mt-2"/>
                </div>

                {{--due date--}}
                <div class="">
                    <x-input-label for="due_date" :value="__('Due Date')"/>
                    <x-text-input id="due_date" type="datetime-local" name="due_date"
                                  :value="old('due_date', $task->due_date)" autofocus autocomplete="due_date"/>
                    <x-input-error :messages="$errors->get('due_date')" class="mt-2"/>
                </div>

                {{--priority--}}
                <div class="">
                    <x-input-label for="priority" :value="__('Priority')"></x-input-label>
                    <x-select-input name="priority" id="priority" onchange="showSelect2(this.value)" class="capitalize">
                        <option value="low"
                                class="capitalize" {{ old('priority', $task->priority) == 'low' ? 'selected' : '' }}>low
                        </option>
                        <option value="medium"
                                class="capitalize" {{ old('priority', $task->priority) == 'medium' ? 'selected' : '' }}>
                            medium
                        </option>
                        <option value="high"
                                class="capitalize" {{ old('priority', $task->priority) == 'high' ? 'selected' : '' }}>
                            high
                        </option>
                    </x-select-input>
                </div>

                {{--description--}}
                <div class="col-span-2">
                    <x-input-label for="description" :value="__('Description')"/>
                    <x-textarea rows="4" cols="50" id="description" name="description" autofocus
                                autocomplete="description">{{ old('description', $task->description) }}</x-textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2"/>
                </div>

                {{--attachments--}}
                <div class="col-span-2">
                    <x-input-label>Attachments</x-input-label>
                    <input type="file" name="uploadTaskAttachment" id="uploadTaskAttachment"/>

                    {{--
                    <div class="max-h-[200px] overflow-y-auto">
                        @for($i = 0; $i < 6; $i++)
                            <div
                                class="group flex flex-row gap-4 rounded-lg cursor-default border-b border-gray-300 p-2 hover:bg-gray-100 transition-all">
                                <i class="fa-solid fa-file-alt"></i>
                                <div class="text-md grow">$attachment->name</div>
                                <a href="route('admin.attachments.destroy', $attachment->id)"
                                   class="text-red-500 hover:text-red-700 transition-all"><i
                                        class="group-hover:text-red-500 fa-regular fa-minus-circle cursor-pointer"></i></a>
                            </div>
                        @endfor
                    </div>
                    --}}
                    @if($task->attachments->isEmpty())
                        <div class=" border-b border-gray-300 py-2">
                            <div class="text-md p-2">There are no attachments.</div>
                        </div>
                    @else
                        @foreach($task->attachments as $attachment)
                            <div
                                class="group flex flex-row gap-4 rounded-lg cursor-default border-b border-gray-300 p-2 hover:bg-gray-100 transition-all">
                                <i class="fa-solid fa-file-alt"></i>
                                <div class="text-md grow">{{ $attachment->name }}</div>
                                <a href="{{ route('admin.attachments.destroy', $attachment->id) }}"
                                   class="text-red-500 hover:text-red-700 transition-all"><i
                                        class="group-hover:text-red-500 fa-regular fa-minus-circle cursor-pointer"></i></a>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <a href="{{ route('admin.tasks.show', $task->id) }}" class="btn btn-error btn-sm text-white">Cancel</a>
            <button type="submit" class="btn btn-success btn-sm text-white">Confirm</button>
        </form>
    </x-container-section>
</x-app-layout>
