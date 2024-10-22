<div class="h-screen">
    <div class="flex flex-col w-[275px] bg-white h-full border-r">
        <div class="flex items-center justify-start h-14 border-b text-3xl font-bold text-black px-5">
            iTrack
        </div>
        <div class="overflow-y-auto overflow-x-hidden flex-grow">
            <ul class="flex flex-col justify-between h-full py-4 space-y-1">
                <div>
                    <li class="px-5">
                        <div class="flex flex-row items-center h-8">
                            <div class="text-sm font-light tracking-wide text-gray-500">Menu</div>
                        </div>
                    </li>
                    <x-nav-link href="{{ route('dashboard.index') }}" :active="request()->is('dashboard*')" iconClass="fa-home" slotLabel="Dashboard"/>
                    <x-nav-link href="{{ route('portfolios.index') }}" :active="request()->is('portfolios*')" iconClass="fa-table-columns" slotLabel="Portfolio"/>
                    <x-nav-link href="{{ route('files.index') }}" :active="request()->is('files*')" iconClass="fa-folder-open" slotLabel="File Manager"/>
                    <x-nav-link href="" :active="request()->is('archive*')" iconClass="fa-archive" slotLabel="Archive"/>
                    <x-nav-link href="{{ route('notifications.index') }}" :active="request()->is('notifications*')" iconClass="fa-bell" slotLabel="Notifications"/>

                    <li class="px-5">
                        <div class="flex flex-row items-center h-8">
                            <div class="text-sm font-light tracking-wide text-gray-500">Tasks</div>
                        </div>
                    </li>
                    <x-nav-link href="{{ route('requirements.index') }}" :active="request()->is('requirements*')" iconClass="fa-tasks" slotLabel="Requirements"/>
                    <x-nav-link href="{{ route('tasks.index') }}" :active="request()->is('tasks*')" iconClass="fa-clipboard-list" slotLabel="Tasks"/>
                    <x-nav-link href="" :active="request()->is('progress*')" iconClass="fa-spinner" slotLabel="Progress"/>
                    <x-nav-link href="" :active="request()->is('recent*')" iconClass="fa-clock-rotate-left" slotLabel="Recent"/>

                    <li class="px-5">
                        <div class="flex flex-row items-center h-8">
                            <div class="text-sm font-light tracking-wide text-gray-500">Admin</div>
                        </div>
                    </li>
                    <x-nav-link href="{{ route('users.index') }}" :active="request()->is('users*')" iconClass="fa-users" slotLabel="Users"/>
{{--                    <x-nav-link href="" :active="request()->is('progress*')" iconClass="fa-spinner" slotLabel="Progress"/>--}}
{{--                    <x-nav-link href="" :active="request()->is('recent*')" iconClass="fa-clock-rotate-left" slotLabel="Recent"/>--}}
                </div>

                <div>
                    <li class="px-5">
                        <div class="flex flex-row items-center h-8">
                            <div class="text-sm font-light tracking-wide text-gray-500">Settings</div>
                        </div>
                    </li>

                    <x-nav-link href="{{ route('profile.edit') }}" :active="request()->is('profile*')"
                                iconClass="fa-user" slotLabel="Profile"/>

                    <x-nav-link href="" :active="request()->is('settings*')"
                                iconClass="fa-gear" slotLabel="Settings"/>

                    @guest
                        <x-nav-link href="{{ route('login') }}" :active="request()->is('login')"
                                    iconClass="fa-right-to-bracket" slotLabel="Login"/>
                        <x-nav-link href="{{ route('register') }}" :active="request()->is('register')"
                                    iconClass="fa-user-plus" slotLabel="Register"/>
                    @endguest

                    @auth
                        <form action="/logout" method="post">
                            @csrf
                            <x-nav-link as="button" :active="false" href="" iconClass="fa-sign-out"
                                        slotLabel="Logout"/>
                        </form>
                    @endauth

                </div>
            </ul>
        </div>
    </div>
</div>
