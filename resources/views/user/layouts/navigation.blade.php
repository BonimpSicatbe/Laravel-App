<div class="h-screen" id="sidebar">
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
                    <x-nav-link href="{{ route('user.dashboard.index') }}" :active="request()->is('user/dashboard*')"
                                iconClass="fa-home" slotLabel="Dashboard"/>
                    <x-nav-link href="{{ route('user.portfolios.index') }}" :active="request()->is('user/portfolios*')"
                                iconClass="fa-table-columns" slotLabel="Portfolio"/>
                    <x-nav-link href="{{ route('user.files.index') }}" :active="request()->is('user/files*')"
                                iconClass="fa-folder-open" slotLabel="Files"/>
                    <x-nav-link href="" :active="request()->is('user/archive*')" iconClass="fa-archive"
                                slotLabel="Archive"/>
                    <x-nav-link href="{{ route('user.notifications.index') }}" :active="request()->is('user/notifications*')"
                                iconClass="fa-bell" slotLabel="Notifications"/>

                    {{--tasks--}}
                    <li class="px-5">
                        <div class="flex flex-row items-center h-8">
                            <div class="text-sm font-light tracking-wide text-gray-500">Tasks</div>
                        </div>
                    </li>
                    <x-nav-link href="{{ route('user.requirements.index') }}" :active="request()->is('user/requirements*')"
                                iconClass="fa-tasks" slotLabel="Requirements"/>
                    <x-nav-link href="{{ route('user.tasks.index') }}" :active="request()->is('user/tasks*')"
                                iconClass="fa-clipboard-list" slotLabel="Tasks"/>
                    <x-nav-link href="" :active="request()->is('user/progress*')" iconClass="fa-spinner"
                                slotLabel="Progress"/>
                    <x-nav-link href="" :active="request()->is('user/recent*')" iconClass="fa-clock-rotate-left"
                                slotLabel="Recent"/>
                </div>



                <div>
                    <li class="px-5">
                        <div class="flex flex-row items-center h-8">
                            <div class="text-sm font-light tracking-wide text-gray-500">Settings</div>
                        </div>
                    </li>

                    <x-nav-link href="{{ route('profile.edit') }}" :active="request()->is('user/profile*')"
                                iconClass="fa-user" slotLabel="Profile"/>

                    <x-nav-link href="" :active="request()->is('user/settings*')"
                                iconClass="fa-gear" slotLabel="Settings"/>

                    {{--
                    @guest
                        <x-nav-link href="{{ route('login') }}" :active="request()->is('user/login')"
                                    iconClass="fa-right-to-bracket" slotLabel="Login"/>
                        <x-nav-link href="{{ route('register') }}" :active="request()->is('user/register')"
                                    iconClass="fa-user-plus" slotLabel="Register"/>
                    @endguest
                    --}}
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


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('sidebar');
    })
</script>
