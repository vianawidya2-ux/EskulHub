<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                {{-- MENU UTAMA --}}
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    {{-- Penilaian & Laporan (Cuma muncul buat Admin & Pembina) --}}
                    @if(Auth::user()->isAdmin() || Auth::user()->isPembina())
                        <x-nav-link :href="route('penilaian.index')" :active="request()->routeIs('penilaian.*')">
                            {{ __('Penilaian') }}
                        </x-nav-link>
                    @endif

                    <x-nav-link :href="route('penilaian.rangking')" :active="request()->routeIs('penilaian.rangking')">
                        {{ __('Rangking') }}
                    </x-nav-link>

                    @if(Auth::user()->isAdmin() || Auth::user()->isPembina())
                        <x-nav-link :href="route('laporan.index')" :active="request()->routeIs('laporan.*')">
                            {{ __('Laporan') }}
                        </x-nav-link>
                    @endif

                    {{-- MENU KHUSUS ADMIN --}}
                    @if(Auth::user()->isAdmin())
                        <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                            {{ __('User') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <div class="flex items-center space-x-4">
                    {{-- BADGE STATUS (Pakai fungsi model agar rapi) --}}
                    <span class="text-sm font-bold text-blue-600 bg-blue-50 px-3 py-1 rounded-full uppercase">
                        @if(Auth::user()->isAdmin())
                            Admin
                        @elseif(Auth::user()->isPembina())
                            Pembina
                        @else
                            Siswa
                        @endif
                    </span>
                    <span class="text-gray-500 text-sm font-medium">{{ Auth::user()->name }}</span>
                    
                    <a href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       style="background-color: #ef4444; color: white; padding: 7px 15px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 12px; transition: 0.3s;"
                       onmouseover="this.style.backgroundColor='#dc2626'"
                       onmouseout="this.style.backgroundColor='#ef4444'">
                        LOGOUT
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </div>
            </div>

            {{-- Button Hamburger (Mobile) --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- MENU MOBILE --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @if(Auth::user()->isAdmin() || Auth::user()->isPembina())
                <x-responsive-nav-link :href="route('penilaian.index')" :active="request()->routeIs('penilaian.*')">
                    {{ __('Penilaian') }}
                </x-responsive-nav-link>
            @endif

            <x-responsive-nav-link :href="route('penilaian.rangking')" :active="request()->routeIs('penilaian.rangking')">
                {{ __('Rangking') }}
            </x-responsive-nav-link>

            @if(Auth::user()->isAdmin() || Auth::user()->isPembina())
                <x-responsive-nav-link :href="route('laporan.index')" :active="request()->routeIs('laporan.*')">
                    {{ __('Laporan') }}
                </x-responsive-nav-link>
            @endif

            @if(Auth::user()->isAdmin())
                <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                    {{ __('User (Admin)') }}
                </x-responsive-nav-link>
            @endif
        </div>
    </div>
</nav>