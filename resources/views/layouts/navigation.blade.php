<nav x-data="{ open: false }"
    class="sticky top-0 z-50 bg-[#090d17]/95 backdrop-blur-xl border-b border-white/10 text-white">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="h-20 flex items-center justify-between">

            {{-- Marca y navegación --}}
            <div class="flex items-center gap-8">
                <a href="{{ route('matches.index') }}" class="flex items-center gap-3 group">

                    <div
                        class="w-11 h-11 rounded-2xl bg-blue-600
                               flex items-center justify-center
                               shadow-lg shadow-blue-950/40
                               group-hover:bg-blue-500 transition">

                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">

                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    </div>

                    <div>
                        <p class="text-[10px] font-black uppercase tracking-[0.32em] text-blue-400">
                            Municipalidad de Breña
                        </p>

                        <p class="text-lg font-black leading-tight tracking-tight">
                            Breña Live Studio
                        </p>
                    </div>
                </a>

                <div class="hidden md:flex items-center gap-2">
                    <a href="{{ route('matches.index') }}"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl
                               text-sm font-black transition
                               {{ request()->routeIs('matches.*') && !request()->routeIs('matches.create')
                                   ? 'bg-white/10 text-white'
                                   : 'text-gray-400 hover:text-white hover:bg-white/5' }}">

                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">

                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 12l9-9 9 9M5 10v10h14V10M9 20v-6h6v6" />
                        </svg>

                        Inicio
                    </a>

                    <a href="{{ route('matches.create') }}"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl
                               text-sm font-black transition
                               {{ request()->routeIs('matches.create')
                                   ? 'bg-blue-600 text-white'
                                   : 'text-gray-400 hover:text-white hover:bg-white/5' }}">

                        <span class="text-lg leading-none">＋</span>
                        Nuevo partido
                    </a>
                </div>
            </div>

            {{-- Usuario desktop --}}
            <div class="hidden sm:flex items-center gap-3">
                <div
                    class="hidden lg:flex items-center gap-2 px-3 py-2
                           rounded-xl bg-green-500/10 border border-green-400/15">

                    <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>

                    <span class="text-xs font-black text-green-300">
                        Sistema operativo
                    </span>
                </div>

                <x-dropdown align="right" width="56">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center gap-3 px-3 py-2 rounded-2xl
                                   bg-white/5 hover:bg-white/10 border border-white/10
                                   transition focus:outline-none">

                            <div
                                class="w-9 h-9 rounded-xl bg-blue-600/20
                                       border border-blue-400/20
                                       flex items-center justify-center
                                       font-black text-blue-300">

                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>

                            <div class="text-left hidden lg:block">
                                <p class="text-sm font-black leading-tight">
                                    {{ Auth::user()->name }}
                                </p>

                                <p class="text-[11px] text-gray-500">
                                    Operador
                                </p>
                            </div>

                            <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">

                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-3 border-b border-gray-100">
                            <p class="text-sm font-bold text-gray-900">
                                {{ Auth::user()->name }}
                            </p>

                            <p class="text-xs text-gray-500 truncate">
                                {{ Auth::user()->email }}
                            </p>
                        </div>

                        <x-dropdown-link :href="route('profile.edit')">
                            👤 Mi perfil
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                🚪 Cerrar sesión
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- Botón móvil --}}
            <button type="button" @click="open = !open"
                class="sm:hidden w-11 h-11 rounded-xl bg-white/10
                       flex items-center justify-center
                       text-gray-300 hover:text-white transition">

                <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">

                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>

                <svg x-show="open" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">

                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    {{-- Menú móvil --}}
    <div x-show="open" x-cloak x-transition class="sm:hidden border-t border-white/10 bg-[#090d17]">

        <div class="px-4 py-4 space-y-2">
            <a href="{{ route('matches.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl
                       bg-white/5 hover:bg-white/10 font-black">
                🏠 Inicio
            </a>

            <a href="{{ route('matches.create') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl
                       bg-blue-600 hover:bg-blue-500 font-black">
                ＋ Nuevo partido
            </a>

            <a href="{{ route('profile.edit') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl
                       bg-white/5 hover:bg-white/10 font-black">
                👤 Mi perfil
            </a>

            <div class="pt-3 mt-3 border-t border-white/10">
                <p class="px-4 text-sm font-black">
                    {{ Auth::user()->name }}
                </p>

                <p class="px-4 mt-1 text-xs text-gray-500">
                    {{ Auth::user()->email }}
                </p>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit"
                    class="w-full flex items-center gap-3 px-4 py-3 rounded-xl
                           text-red-300 bg-red-500/10 hover:bg-red-500/20 font-black">
                    🚪 Cerrar sesión
                </button>
            </form>
        </div>
    </div>
</nav>
