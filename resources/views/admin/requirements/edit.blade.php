<x-app-layout>
    <x-app-header>Edit Requirement</x-app-header>
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
        <form action="{{ route('admin.requirements.update', $requirement->id) }}" method="post" class="space-y-4">
            @csrf
            @method('patch')
            <div class="grid grid-cols-2 gap-4">
                {{--name--}}
                <div class="col-span-2">
                    <x-input-label for="name" :value="__('Name')"/>
                    <x-text-input id="name" type="text" name="name" :value="old('name', $requirement->name)" autofocus
                                  autocomplete="name"/>
                    <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                </div>

                {{--created at--}}
                <div class="">
                    <x-input-label for="created_at" :value="__('Created At')"/>
                    <x-text-input id="created_at" type="datetime-local" name="created_at"
                                  :value="old('created_at', $requirement->created_at)" autofocus
                                  autocomplete="created_at"
                                  disabled/>
                    <x-input-error :messages="$errors->get('created_at')" class="mt-2"/>
                </div>

                {{--updated at--}}
                <div class="">
                    <x-input-label for="updated_at" :value="__('Updated At')"/>
                    <x-text-input id="updated_at" type="datetime-local" name="updated_at"
                                  :value="old('updated_at', $requirement->updated_at)" autofocus
                                  autocomplete="updated_at"
                                  disabled/>
                    <x-input-error :messages="$errors->get('updated_at')" class="mt-2"/>
                </div>

                {{--created by / assigned by--}}
                <div class="">
                    <x-input-label for="created_by" :value="__('Created By')"/>
                    <x-text-input id="created_by" type="text" name="created_by"
                                  :value="old('created_by', $requirement->createdBy->name)" autofocus
                                  autocomplete="created_by" disabled/>
                    <x-input-error :messages="$errors->get('created_by')" class="mt-2"/>
                </div>

                {{--updated by--}}
                <div class="">

                    <x-input-label for="updated_by" :value="__('Updated By')"/>
                    <x-text-input id="updated_by" type="text" name="updated_by"
                                  :value="old('updated_by', $requirement->updatedBy->name)" autofocus
                                  autocomplete="updated_by" disabled/>
                    <x-input-error :messages="$errors->get('updated_by')" class="mt-2"/>
                </div>

                {{--status--}}
                <div class="col-span-2">
                    <x-input-label for="status" :value="__('Status')"/>
                    <x-text-input id="status" type="text" name="status" :value="old('status', $requirement->status)"
                                  autofocus
                                  autocomplete="status" class="capitalize" disabled/>
                    <x-input-error :messages="$errors->get('status')" class="mt-2"/>
                </div>

                {{--due date--}}
                <div class="">
                    <x-input-label for="due_date" :value="__('Due Date')"/>
                    <x-text-input id="due_date" type="datetime-local" name="due_date"
                                  :value="old('due_date', $requirement->due_date)" autofocus autocomplete="due_date"/>
                    <x-input-error :messages="$errors->get('due_date')" class="mt-2"/>
                </div>

                {{--priority--}}
                <div class="">
                    <x-input-label for="priority" :value="__('Priority')"></x-input-label>
                    <x-select-input name="priority" id="priority" onchange="showSelect2(this.value)" class="capitalize">
                        <option value="low"
                                class="capitalize" {{ old('priority', $requirement->priority) == 'low' ? 'selected' : '' }}>
                            low
                        </option>
                        <option value="medium"
                                class="capitalize" {{ old('priority', $requirement->priority) == 'medium' ? 'selected' : '' }}>
                            medium
                        </option>
                        <option value="high"
                                class="capitalize" {{ old('priority', $requirement->priority) == 'high' ? 'selected' : '' }}>
                            high
                        </option>
                    </x-select-input>
                </div>
                {{--description--}}
                <div class="col-span-2">
                    <x-input-label for="description" :value="__('Description')"/>
                    <x-textarea rows="4" cols="50" id="description" name="description" autofocus autocomplete="description">{{ old('description', $requirement->description) }}</x-textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2"/>
                </div>
            </div>
            <a href="{{ route('admin.requirements.show', $requirement->id) }}"
               class="btn btn-error btn-sm text-white">Cancel</a>
            <button type="submit" class="btn btn-success btn-sm text-white">Confirm</button>
        </form>
    </x-container-section>
</x-app-layout>
