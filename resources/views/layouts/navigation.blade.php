<!-- Header -->
<header id="header" class="bg-gradient-to-r from-yellow-300 to-red-600 p-2 shadow-md transition-all duration-300">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Hamburger Button -->
        <button id="sidebarToggle" class="focus:outline-none">
            <div class="hamburger">
                <div class="line1 w-6 h-1 bg-white mb-1"></div>
                <div class="line2 w-6 h-1 bg-white mb-1"></div>
                <div class="line3 w-6 h-1 bg-white"></div>
            </div>
        </button>

        <div class="text-white text-lg font-bold w-full p-1 text-center">
            <a href="/" class="hover:text-gray-200">SISTEM AGENDA BPBD PROVINSI JAWA BARAT</a>
        </div>
        <!-- Logo -->
        <div class="flex items-center">
            <img src="{{ asset('images/logo-bpbd-jawabarat.png') }}" alt="Logo" class="h-10 w-auto ml-4">
        </div>
    </div>
</header>

<!-- Sidebar -->
<div id="sidebar" class="bg-white shadow-lg p-5">

    <div class="flex flex-col items-center mb-6">
        <a href="{{ route('profile.edit') }}" class="flex flex-col items-center mb-4">
            <img class="w-24 h-24 rounded-full border-2 border-blue-500" src="{{ asset('images/user-subject.png') }}" alt="Profile Picture">
        </a>
        @auth
        <h2 class="text-lg font-semibold">{{ Auth::user()->name }}</h2>
        <p class="text-gray-500 text-sm">{{ Auth::user()->role_name }}</p>
        <form action="{{ route('logout') }}" method="POST" id="logoutForm">
            @csrf
            <button type="submit" id="logoutButton" class="mt-4 w-full flex items-center justify-center px-4 py-2 bg-red-700 text-white rounded-md hover:bg-red-500">
                <svg xmlns=" http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H4a3 3 0 01-3-3V7a3 3 0 013-3h6a3 3 0 013 3v1" />
                </svg>
                Logout
            </button>
        </form>
        @else
        <h2 class="text-lg font-semibold">Guest</h2>
        <p class="text-gray-500 text-sm">Not logged in</p>
        <button class="mt-4 w-start flex items-center justify-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
            <!-- Ikon Boxicons -->
            <box-icon name='log-in' color="white" class="w-5 h-5 mr-2"></box-icon>
            <a href="/login">Login</a>
        </button>
        @endauth
    </div>

    <nav class="space-y-4">
        <a href="/"
            class="flex items-center px-4 py-2 rounded-lg 
        {{ request()->is('/') ? 'bg-blue-300 text-black-600' : 'text-gray-700 hover:text-gray-600' }} 
        transition duration-300 ease-in-out transform hover:scale-105 hover:bg-blue-200">
            <span class="font-medium text-lg">Beranda</span>
        </a>

        <a href="{{ route('users.index') }}"
            class="flex items-center px-4 py-2 rounded-lg 
        {{ request()->is('users') ? 'bg-blue-300 text-black-600' : 'text-gray-700 hover:text-gray-600' }} 
        transition duration-300 ease-in-out transform hover:scale-105 hover:bg-blue-200">
            <span class="font-medium text-lg">Data User</span>
        </a>
        @if(auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
        <a href="{{ route('pegawai.create') }}"
            class="flex items-center px-4 py-2 rounded-lg 
        {{ request()->is('pegawai.create') ? 'bg-blue-300 text-black-600' : 'text-gray-700 hover:text-gray-600' }} 
        transition duration-300 ease-in-out transform hover:scale-105 hover:bg-blue-200">
            <span class="font-medium text-m">Data Pegawai</span>
        </a>
        @endif
        <a href="{{ route('agendas.index') }}"
            class="flex items-center px-4 py-2 rounded-lg 
        {{ request()->is('agendas') ? 'bg-blue-300 text-black-600' : 'text-gray-700 hover:text-gray-600' }} 
        transition duration-300 ease-in-out transform hover:scale-105 hover:bg-blue-200">
            <span class="font-medium text-lg">Agenda Kegiatan</span>
        </a>

        <a href="{{ route('meeting-rooms.index') }}"
            class="flex items-center px-4 py-2 rounded-lg 
        {{ request()->is('meeting-rooms') ? 'bg-blue-300 text-black-600' : 'text-gray-700 hover:text-gray-600' }} 
        transition duration-300 ease-in-out transform hover:scale-105 hover:bg-blue-200">
            <span class="font-medium text-m">Informasi Ruang Rapat</span>
        </a>


    </nav>

    <h2 class="text-gray-400 text-base mb-4 ml-4 absolute bottom-0 left-0 p-4">&copy; Hak Cipta 2024</h2>
</div>

<main id="mainContent" class="transition-all duration-300 p-8">
    @yield('content')
</main>