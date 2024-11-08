<x-app-layout>
    <x-app-header>Create User</x-app-header>

    <x-container-section>
        <div class="text-xl font-bold text-black">Enter User Credentials</div>
        {{--
        <form action="{{ route('admin.users.store') }}" method="post" class="space-y-2">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <x-text-input id="name" name="name" placeholder="Enter name..." class="text-black" required/>
                @error('name')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="account_number" class="block text-sm font-medium text-gray-700">Account
                    Number</label>
                <x-text-input id="account_number" name="account_number" placeholder="Enter account number..." class="text-black" required/>
                @error('account_number')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <x-text-input id="email" name="email" placeholder="Enter email..." class="text-black"
                              required/>
                @error('email')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <x-text-input type="password" id="password" name="password" placeholder="Enter password..." class="text-black" required/>
                @error('password')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <x-text-input type="password" id="confirm_password" name="password_confirmation" placeholder="Confirm password..." class="text-black" required/>
                @error('password_confirmation')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                <select name="role" id="role" class="rounded-lg text-black border-gray-500 outline-green-500 focus:border-green-500 focus:ring-green-500 w-full" required>
                    <option value="" selected disabled>Select Role</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                    <!-- Add other roles as necessary -->
                </select>
                @error('role')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="selectCourse" class="block text-sm font-medium text-gray-700">Course</label>
                <select name="selectCourse" id="selectCourse" class="rounded-lg text-black border-gray-500 outline-green-500 focus:border-green-500 focus:ring-green-500 w-full" required>
                    <option value="" selected disabled>Select Course</option>
@if(oreach->isEmpty()
option@ disabledenonendif
                        <option value="{{ $course->id }}">{{ ucwords($course->name) }}</option>
                    @endforeach
                </select>
                    @foreach($courses as $course)
                @error('selectCourse')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="selectSubject" class="block text-sm font-medium text-gray-700">Subject</label>
                <select name="selectSubject" id="selectSubject" class="rounded-lg text-black border-gray-500 outline-green-500 focus:border-green-500 focus:ring-green-500 w-full" required>
                    <option value="" selected disabled>Select Subject</option>
@if(oreach->isEmpty()
option@ disabledenonendif
                        <option value="{{ $subject->id }}">{{ ucwords($subject->name) }}</option>
                    @endforeach
                </select>
                    @foreach($subjects as $subject)
                @error('selectSubject')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="selectPosition" class="block text-sm font-medium text-gray-700">Position</label>
                <select name="selectPosition" id="selectPosition" class="rounded-lg text-black border-gray-500 outline-green-500 focus:border-green-500 focus:ring-green-500 w-full" required>
                    <option value="" selected disabled>Select Position</option>
@if(oreach->isEmpty()
option@ disabledenonendif
                        <option value="{{ $position->id }}">{{ ucwords($position->name) }}</option>
                    @endforeach
                </select>
                    @foreach($positions as $position)
                @error('selectPosition')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-sm btn-outline btn-success">Submit</button>
        </form>
        --}}
        <form action="{{ route('admin.users.store') }}" method="post" class="space-y-4">
            @csrf
            {{--acount_number--}}
            <div>
                <x-input-label for="account_number" :value="__('Account Number')"/>
                <x-text-input id="account_number" class="block mt-1 w-full" type="text" name="account_number"
                              :value="old('account_number')" required autofocus autocomplete="account_number"/>
                <x-input-error :messages="$errors->get('account_number')" class="mt-2"/>
            </div>

            {{--name--}}
            <div>
                <x-input-label for="name" :value="__('Name')"/>
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                              required autofocus autocomplete="name"/>
                <x-input-error :messages="$errors->get('name')" class="mt-2"/>
            </div>

            {{--email--}}
            <div>
                <x-input-label for="email" :value="__('Email')"/>
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                              required autofocus autocomplete="email"/>
                <x-input-error :messages="$errors->get('email')" class="mt-2"/>
            </div>

            {{--            <div>--}}
            {{--                <x-input-label for="role" :value="__('Role')"/>--}}
            {{--                <x-select-input name="role" id="role" selectLabel="Select Role" class="w-full">--}}
            {{--                    <option value="admin">Admin</option>--}}
            {{--                    <option value="coordinator">Coordinator</option>--}}
            {{--                </x-select-input>--}}
            {{--                <x-input-error :messages="$errors->get('role')" class="mt-2"/>--}}
            {{--            </div>--}}

            <div>
                <x-input-label for="course" :value="__('Course')"/>
                <x-select-input name="course" id="course" selectLabel="Select Course" class="w-full">
                    @if($courses->isEmpty())
                        <option value="" disabled>none</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                        @endforeach
                    @endif
                </x-select-input>
                <x-input-error :messages="$errors->get('course')" class="mt-2"/>
            </div>

            <div>
                <x-input-label for="subject" :value="__('Subject')"/>
                <x-select-input name="subject" id="subject" selectLabel="Select Subject" class="w-full">
                    @if($subjects->isEmpty())
                        <option value="" disabled>none</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                        @endforeach
                    @endif
                </x-select-input>
                <x-input-error :messages="$errors->get('subject')" class="mt-2"/>
            </div>

            <div>
                <x-input-label for="position" :value="__('Position')"/>
                <x-select-input name="position" id="position" selectLabel="Select Position" class="w-full">
                    @if($positions->isEmpty())
                        <option value="" disabled>none</option>
                        @foreach($positions as $position)
                            <option value="{{ $position->id }}">{{ $position->name }}</option>
                        @endforeach
                    @endif
                </x-select-input>
                <x-input-error :messages="$errors->get('position')" class="mt-2"/>
            </div>

            {{--password--}}
            <div class="">
                <x-input-label for="password" :value="__('Password')"/>
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                              autocomplete="new-password"/>
                <x-input-error :messages="$errors->get('password')" class="mt-2"/>
            </div>

            {{--confirm_password--}}
            <div class="">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')"/>
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                              name="password_confirmation" required autocomplete="new-password"/>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
            </div>

            {{--            <x-primary-button>Confirm</x-primary-button>--}}
            <button type="submit" class="btn btn-sm btn-success text-white">Confirm</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-neutral text-white">Cancel</a>
        </form>
    </x-container-section>
</x-app-layout>
