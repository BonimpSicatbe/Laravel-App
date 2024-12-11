<x-app-layout>
    <x-app-header>Edit User</x-app-header>

    <x-container-section>
        <div class="flex flex-row items-center gap-6">
            <div class="bg-gray-200 rounded-full w-[100px] h-[100px]"></div> {{--circle image placeholder--}}
            <div class="flex flex-col gap-2">
                <div class="text-lg font-bold">Personal Info</div>
                <div class="text-sm font-normal text-gray-500">You can update your profile photo and personal
                    details
                    here.
                </div>
                <div class="space-x-2">
                    {{--                    <button type="button" class="btn btn-sm btn-outline btn-error">Cancel</button>--}}
                    <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-neutral text-white">Back</a>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.users.update', $user->id) }}" method="post" class="space-y-4">
            @csrf
            @method('patch')
            <div>
                <x-input-label for="name" :value="__('Name')"/>
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                              :value="old('name', $user->name)" required autofocus autocomplete="name"/>
                <x-input-error class="mt-2" :messages="$errors->get('name')"/>
            </div>

            <div>
                <x-input-label for="email" :value="__('Email')"/>
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                              :value="old('email', $user->email)" required autocomplete="email"/>
                <x-input-error class="mt-2" :messages="$errors->get('email')"/>
            </div>

            <div>
                <x-input-label for="role" :value="__('Role')"/>
                <x-text-input id="role" name="role" type="text" class="mt-1 block w-full"
                              :value="old('role', $user->role)" required autocomplete="role"/>
                <x-input-error class="mt-2" :messages="$errors->get('role')"/>
            </div>

            <div>
                <x-input-label for="position" :value="__('Position')"/>
                <x-text-input id="position" name="position" type="text" class="mt-1 block w-full"
                              :value="old('position', $user->position)" required autocomplete="position"/>
                <x-input-error class="mt-2" :messages="$errors->get('position')"/>
            </div>

            <div class="flex flex-row gap-4">
                <div class="w-full">
                    <x-input-label for="created_at" :value="__('Created At')"/>
                    <x-text-input id="created_at" name="created_at" type="datetime-local" class="mt-1 block w-full"
                                  :value="old('created_at', $user->created_at)" required autocomplete="username" disabled/>
                    <x-input-error class="mt-2" :messages="$errors->get('created_at')"/>
                </div>

                <div class="w-full">
                    <x-input-label for="updated_at" :value="__('Updated At')"/>
                    <x-text-input id="updated_at" name="updated_at" type="datetime-local" class="mt-1 block w-full"
                                  :value="old('updated_at', $user->updated_at)" required autocomplete="username" disabled/>
                    <x-input-error class="mt-2" :messages="$errors->get('updated_at')"/>
                </div>
            </div>

            <div>
                <x-input-label for="course" :value="__('Course/s')"/>
                <div class="space-y-2">
                    @if($courses->isEmpty())
                        <div class="text-md font-medium space-x-2">
                            <i class="fa-regular fa-minus"></i>
                            <span>There is no course listed.</span>
                        </div>
                    @else
                        @foreach($courses as $course)
                            <div class="text-md font-medium space-x-2">
                                <i class="fa-regular fa-minus"></i>
                                <span>{{ $course->course->name }}</span>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <div>
                <x-input-label for="subject" :value="__('Subject')"/>
                @if($subjects->isEmpty())
                    <div class="text-md font-medium space-x-2">
                        <i class="fa-regular fa-minus"></i>
                        <span>There is no subject listed.</span>
                    </div>
                @else
                    @foreach($subjects as $subject)
                        <div class="text-md font-medium space-x-2">
                            <i class="fa-regular fa-minus"></i>
                            <span>{{ $subject->subject->name }}</span>
                        </div>
                    @endforeach
                @endif
            </div>

            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </form>
    </x-container-section>
</x-app-layout>
