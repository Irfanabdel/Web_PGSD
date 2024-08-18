<!-- Navbar -->
<nav class="sticky top-0 z-50 w-full bg-white border-b border-gray-200">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center justify-start rtl:justify-end">
                <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 transition ease-in-out duration-150">
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                    </svg>
                </button>
                <!-- Logo Link -->
                @auth
                <a href="{{ route('dashboard') }}" class="flex ms-1 md:me-24">
                    @else
                    <a href="{{ route('welcome') }}" class="flex ms-1 md:me-24">
                        @endauth
                        <img src="{{asset('/image/fwef.png')}}" class="h-14 me-3 transition-transform duration-300 hover:scale-105" alt="FlowBite Logo" />
                    </a>
            </div>

            <!-- User Menu -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 hover:bg-gray-100 focus:outline-none transition ease-in-out duration-150">
                            <!-- Menampilkan Foto Profil Pengguna -->
                            <div class="flex items-center">
                                @if (auth()->user()->image)
                                <img src="{{ asset('storage/' . auth()->user()->image) }}" alt="Profile Image" class="w-8 h-8 rounded-full border border-gray-300">
                                @else
                                <div class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center bg-gray-200">
                                    <!-- Ikon Orang Kosong -->
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-gray-500">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9A3.75 3.75 0 1112 5.25 3.75 3.75 0 0115.75 9zM4.5 18.75A6.75 6.75 0 0112 12a6.75 6.75 0 017.5 6.75" />
                                    </svg>
                                </div>
                                @endif
                            </div>

                            <div class="ms-1 text-gray-700">{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4 text-gray-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                   this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- Sidebar Menu -->
<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform duration-300 ease-in-out -translate-x-full sm:translate-x-0 bg-white shadow-lg" aria-label="Sidebar">
    <div class="h-full px-4 py-6 overflow-y-auto">
        <ul class="space-y-4 font-medium">
            <!-- Home / Welcome Link -->
            @auth
            <li>
                <a href="{{ route('dashboard') }}" class="flex items-center p-3 rounded-lg transition-colors duration-300 ease-in-out group {{ request()->is('dashboard') ? 'bg-red-500 text-white' : 'text-gray-900 hover:bg-red-500 hover:text-white' }}">
                    <svg class="w-6 h-6 transition-colors duration-300 ease-in-out group-hover:text-white" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293z"/>
                        <path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293z"/>
                    </svg>
                    <span class="ms-4 font-semibold">Beranda</span>
                </a>
            </li>
            @endauth

            <!-- Conditional Links -->
            @auth
            @if(Auth::user()->role == 'guru')
            <!-- Teacher Links -->
            <li>
                <a href="{{ route('grades.index') }}" class="flex items-center p-3 rounded-lg transition-colors duration-300 ease-in-out group {{ request()->is('grades') ? 'bg-red-500 text-white' : 'text-gray-900 hover:bg-red-500 hover:text-white' }}">
                    <svg class="w-6 h-6 transition-colors duration-300 ease-in-out group-hover:text-white" fill="currentColor" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M2.5 0a.5.5 0 0 1 .5.5v13a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-13a.5.5 0 0 1 .5-.5h1zM4 0h8a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V1a1 1 0 0 1 1-1z" />
                    </svg>
                    <span class="ms-4 font-semibold">Nilai</span>
                </a>
            </li>
        
            <li>
                <a href="{{ route('themes.index') }}" class="flex items-center p-3 rounded-lg transition-colors duration-300 ease-in-out group {{ request()->is('themes/index') ? 'bg-red-500 text-white' : 'text-gray-900 hover:bg-red-500 hover:text-white' }}">
                    <svg class="w-6 h-6 transition-colors duration-300 ease-in-out group-hover:text-white" fill="currentColor" viewBox="0 0 16 16">
                        <path <path d="M8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783" />
                    </svg>
                    <span class="ms-4 font-semibold">Tema</span>
                </a>
            </li>
            @else
            <!-- Student Links -->
            <li>
                <a href="{{ route('grades.chart') }}" class="flex items-center p-3 rounded-lg transition-colors duration-300 ease-in-out group {{ request()->is('chart') ? 'bg-red-500 text-white' : 'text-gray-900 hover:bg-red-500 hover:text-white' }}">
                    <svg class="w-6 h-6 transition-colors duration-300 ease-in-out group-hover:text-white" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783" />
                    </svg>
                    <span class="ms-4 font-semibold">Nilai</span>
                </a>
            </li>
            @endif
            @endauth

            <!-- Discussion Room Link -->
            @auth
            <li>
                <a href="{{ route('komen.index') }}" class="flex items-center p-3 rounded-lg transition-colors duration-300 ease-in-out group {{ request()->is('diskusi') ? 'bg-red-500 text-white' : 'text-gray-900 hover:bg-red-500 hover:text-white' }}">
                    <svg class="w-6 h-6 transition-colors duration-300 ease-in-out group-hover:text-white" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm3.496 6.033a.237.237 0 0 1-.24-.247C5.35 4.091 6.737 3.5 8.005 3.5c1.396 0 2.672.73 2.672 2.24 0 1.08-.635 1.594-1.244 2.057-.737.559-1.01.768-1.01 1.486v.105a.213.213 0 0 1-.226.25h-.825c-.095 0-.183-.059-.22-.146a3.4 3.4 0 0 1-1.48-1.454C6.813 6.315 6.13 6.033 5.732 6.033zM7.881 11.5h.862c.095 0 .184.059.22.146.268.659.996 1.354 1.71 1.636.123.047.207.164.207.295v.73c0 .183-.175.31-.35.267a2.994 2.994 0 0 1-1.968-1.73c-.054-.13-.204-.2-.346-.198h-.337a.226.226 0 0 1-.226-.226v-.808c0-.124.1-.226.226-.226z"/>
                    </svg>
                    <span class="ms-4 font-semibold">Ruang Diskusi</span>
                </a>
            </li>
            @endauth

            <!-- Account Settings -->
            <li>
                <span class="flex items-center p-3 text-gray-900 font-bold">Pengaturan Akun</span>
            </li>
            @auth
            <li>
                <a href="{{ route('profile.edit') }}" class="flex items-center p-3 rounded-lg transition-colors duration-300 ease-in-out group {{ request()->is('profile') ? 'bg-red-500 text-white' : 'text-gray-900 hover:bg-red-500 hover:text-white' }}">
                    <svg class="w-6 h-6 transition-colors duration-300 ease-in-out group-hover:text-white" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                    </svg>
                    <span class="ms-4 font-semibold">{{ Auth::user()->name }}</span>
                </a>
            </li>
            @endauth
        </ul>
    </div>
</aside>
