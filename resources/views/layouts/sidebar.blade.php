

<!-- Sidebar -->
<nav class="sticky top-0 z-50 w-full">
   <div class="px-3 py-3 lg:px-5 lg:pl-3 bg-white">
       <div class="flex items-center justify-between">
           <!-- Logo -->
           <div class="flex items-center justify-start rtl:justify-end">
               <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
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
                       <img src="{{asset('fwef.png')}}" class="h-14 me-3" alt="FlowBite Logo" />
                   </a>
           </div>
           <!-- User Menu -->
           <div class="hidden sm:flex sm:items-center sm:ms-6">
               @auth
               <x-dropdown align="right" width="48">
                   <x-slot name="trigger">
                       <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                           <div>{{ Auth::user()->name }}</div>

                           <div class="ms-1">
                               <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
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

                           <x-dropdown-link :href="route('logout')"
                               onclick="event.preventDefault();
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

    
 <aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
        <ul class="space-y-2 font-medium">
           <li>
              @auth
              <a href="{{'dashboard'}}" class="flex items-center p-2 text-gray-900 rounded-lg hover:text-white hover:bg-red-500 w-full dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:text-white group" aria-current="page">
                
                @else
                   <a href="{{'welcome'}}" class="flex items-center p-2 text-gray-900 rounded-lg hover:text-white hover:bg-red-500 w-full dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:text-white group" aria-current="page">
               @endauth
                <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-white dark:group-hover:text-white" aria-hidden="true" width="20" height="20" fill="currentColor" class="bi bi-house-fill text-gray-500" viewBox="0 0 16 16">
                  <path d=" M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293z "/>
                  <path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293z"/>
                </svg>
                @auth
                <span class="ms-3">Beranda</span>   
               @else
               <span class="ms-3">Selamat Datang</span>
                @endauth
            </a>
           </li>
         <li>
          @Auth
 
          @if(Auth::user()->role == 'guru')
          
          <li>
            <a href="{{ route('nilai.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:text-white hover:bg-red-500 w-full dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:text-white group">
                <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-white dark:group-hover:text-white" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M2.5 0a.5.5 0 0 1 .5.5v13a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-13a.5.5 0 0 1 .5-.5h1zM4 0h8a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V1a1 1 0 0 1 1-1z"/>
                </svg>
                <span class="flex-1 ms-3 whitespace-nowrap">Nilai</span>
            </a>
            
          </li>
          <li>
              <a href="{{ route('nilai.create') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:text-white hover:bg-red-500 w-full dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:text-white group">
                  <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-white dark:group-hover:text-white"  width="20" height="20" fill="currentColor" class="bi bi-book-fill  text-gray-500" viewBox="0 0 16 16">
                      <path d="M8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783"/>
                  </svg>
                  <span class="flex-1 ms-3 whitespace-nowrap">Buat Nilai</span>
              </a>
          </li>
      
          @else
           <li>
              <a href="{{ route('nilai.chart') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:text-white hover:bg-red-500 w-full dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:text-white group">
                <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-white dark:group-hover:text-white"  width="20" height="20" fill="currentColor" class="bi bi-book-fill  text-gray-500" viewBox="0 0 16 16">
                  <path d="M8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783"/>
                </svg>
                 <span class="flex-1 ms-3 whitespace-nowrap">Nilai</span>
              </a>
           </li>
           @endif
@endauth

            @auth   
            <li>
                <a href="{{ route('komen.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:text-white hover:bg-red-500 w-full dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:text-white group">
                  <svg xmlns="http://www.w3.org/2000/svg"class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-white dark:group-hover:text-white"  width="20" height="20" fill="currentColor"  class="bi bi-question-square-fill" viewBox="0 0 16 16">
                    <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm3.496 6.033a.237.237 0 0 1-.24-.247C5.35 4.091 6.737 3.5 8.005 3.5c1.396 0 2.672.73 2.672 2.24 0 1.08-.635 1.594-1.244 2.057-.737.559-1.01.768-1.01 1.486v.105a.25.25 0 0 1-.25.25h-.81a.25.25 0 0 1-.25-.246l-.004-.217c-.038-.927.495-1.498 1.168-1.987.59-.444.965-.736.965-1.371 0-.825-.628-1.168-1.314-1.168-.803 0-1.253.478-1.342 1.134-.018.137-.128.25-.266.25h-.825zm2.325 6.443c-.584 0-1.009-.394-1.009-.927 0-.552.425-.94 1.01-.94.609 0 1.028.388 1.028.94 0 .533-.42.927-1.029.927"/>
                  </svg>
                   <span class="flex-1 ms-3 whitespace-nowrap">Ruang Diskusi</span>
                </a>
             </li>




            @endauth
           
           
            <span class="flex-1 whitespace-nowrap text-gray-900">Pengaturan Akun</span>
           @Auth
                 <li>
                    <a href="{{route ('profile.edit') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:text-white hover:bg-red-500 w-full dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:text-white group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-white dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                          </svg>
                     
                       <span class="flex-1 ms-3 whitespace-nowrap">{{ Auth::user()->name }}</span>
                    </a>
                 </li>
  
                 <li>
                    <form method="POST" action="{{ route('logout') }}">
                       @csrf
                       <a href="{{route ('dashboard') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:text-white hover:bg-red-500 w-full dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:text-white group"
                       onclick="event.preventDefault();
                       this.closest('form').submit();">
                          <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-white dark:group-hover:text-white" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-door-closed-fill" viewBox="0 0 16 16">
                            <path d="M12 1a1 1 0 0 1 1 1v13h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V2a1 1 0 0 1 1-1zm-2 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
                          </svg>
                          <span class="flex-1 ms-3 whitespace-nowrap">Keluar</span>
                       </a>
                    </form>
                 </li>
              @endauth
        </ul>
     </div>
  </aside>
  
  
  