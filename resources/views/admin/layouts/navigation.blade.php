<div class="h-screen">
    <div class="flex flex-col w-[275px] bg-white h-full border-r">
        <div class="flex items-center justify-start gap-4 h-14 border-b text-3xl font-bold text-black px-5">
            iTrack
            <span class="text-sm font-normal">({{ Auth::user()->roles->first()->name }})</span>
        </div>
        <div class="overflow-y-auto overflow-x-hidden flex-grow">
            <ul class="flex flex-col justify-between h-full py-4 space-y-1">
                <div class="overflow-y-auto grow">
                    {{--menu--}}
                    <li class="px-5">
                        <div class="flex flex-row items-center h-8">
                            <div class="text-sm font-light tracking-wide text-gray-500">Menu</div>
                        </div>
                    </li>
                    <x-nav-link href="{{ route('admin.dashboard.index') }}" :active="request()->is('admin/dashboard*')"
                                iconClass="fa-home" slotLabel="Dashboard"/>
                    <x-nav-link href="{{ route('admin.portfolios.index') }}" :active="request()->is('admin/portfolios*')"
                                iconClass="fa-table-columns" slotLabel="Portfolio"/>
                    <x-nav-link href="{{ route('admin.files.index') }}" :active="request()->is('admin/files*')"
                                iconClass="fa-folder-open" slotLabel="Files"/>
                    <x-nav-link href="" :active="request()->is('admin/archive*')" iconClass="fa-archive"
                                slotLabel="Archive"/>
                    <x-nav-link href="{{ route('admin.notifications.index') }}"
                                :active="request()->is('admin/notifications*')"
                                iconClass="fa-bell" slotLabel="Notifications"/>

                    {{--tasks--}}
                    <li class="px-5">
                        <div class="flex flex-row items-center h-8">
                            <div class="text-sm font-light tracking-wide text-gray-500">Tasks</div>
                        </div>
                    </li>
                    <x-nav-link href="{{ route('admin.requirements.index') }}" :active="request()->is('admin/requirements*')"
                                iconClass="fa-tasks" slotLabel="Requirements"/>
                    <x-nav-link href="{{ route('admin.tasks.index') }}" :active="request()->is('admin/tasks*')"
                                iconClass="fa-clipboard-list" slotLabel="Tasks"/>
                    <x-nav-link href="" :active="request()->is('admin/progress*')" iconClass="fa-spinner"
                                slotLabel="Progress"/>
                    <x-nav-link href="" :active="request()->is('admin/recent*')" iconClass="fa-clock-rotate-left"
                                slotLabel="Recent"/>

                    {{--admin--}}
                    <li class="px-5">
                        <div class="flex flex-row items-center h-8">
                            <div class="text-sm font-light tracking-wide text-gray-500">Admin</div>
                        </div>
                    </li>
                    <x-nav-link href="{{ route('admin.users.index') }}" :active="request()->is('admin/users*')"
                                iconClass="fa-users" slotLabel="Users"/>
                    <x-nav-link href="{{ route('admin.roles.index') }}" :active="request()->is('admin/roles*')"
                                iconClass="fa-briefcase" slotLabel="Roles"/>
                    <x-nav-link href="{{ route('admin.permissions.index') }}" :active="request()->is('admin/permissions*')"
                                iconClass="fa-unlock" slotLabel="Permissions"/>
                    {{--                    <x-nav-link href="" :active="request()->is('admin/progress*')" iconClass="fa-spinner" slotLabel="Progress"/>--}}
                    {{--                    <x-nav-link href="" :active="request()->is('admin/recent*')" iconClass="fa-clock-rotate-left" slotLabel="Recent"/>--}}
                </div>

                <div>
                    <li class="px-5">
                        <div class="flex flex-row items-center h-8">
                            <div class="text-sm font-light tracking-wide text-gray-500">Settings</div>
                        </div>
                    </li>

                    <x-nav-link href="{{ route('profile.edit') }}" :active="request()->is('admin/profile*')"
                                iconClass="fa-user" slotLabel="Profile"/>

                    <x-nav-link href="" :active="request()->is('admin/settings*')"
                                iconClass="fa-gear" slotLabel="Settings"/>

                    @guest
                        <x-nav-link href="{{ route('login') }}" :active="request()->is('admin/login')"
                                    iconClass="fa-right-to-bracket" slotLabel="Login"/>
                        <x-nav-link href="{{ route('register') }}" :active="request()->is('admin/register')"
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
