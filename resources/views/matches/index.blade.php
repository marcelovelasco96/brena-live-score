<x-app-layout>
    <div class="min-h-[calc(100vh-5rem)] bg-[#070A12] text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-7">

            {{-- Encabezado --}}
            <section
                class="relative overflow-hidden rounded-[2rem]
                       bg-gradient-to-br from-[#111b30] via-[#0f1724] to-[#080d18]
                       border border-white/10 px-6 py-7 lg:px-8 lg:py-9 mb-6">

                <div
                    class="absolute -top-24 -right-20 w-72 h-72
                           rounded-full bg-blue-600/15 blur-3xl">
                </div>

                <div
                    class="absolute -bottom-28 left-1/3 w-64 h-64
                           rounded-full bg-purple-600/10 blur-3xl">
                </div>

                <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div>

                        <p class="text-blue-400 text-xs font-black uppercase tracking-[0.35em]">
                            PLATAFORMA OFICIAL
                        </p>

                        <h1 class="mt-2 text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight">
                            Centro de transmisiones
                        </h1>

                        <p class="mt-3 text-gray-400 max-w-2xl text-sm sm:text-base">
                            Administra eventos, configura su identidad visual y controla
                            la señal gráfica desde un solo lugar.
                        </p>
                    </div>

                    <a href="{{ route('matches.create') }}"
                        class="shrink-0 inline-flex items-center justify-center gap-2
                               h-14 px-6 rounded-2xl bg-blue-600 hover:bg-blue-500
                               text-white font-black shadow-xl shadow-blue-950/30
                               transition active:scale-95">

                        <span class="text-xl leading-none">＋</span>
                        Nuevo partido
                    </a>
                </div>
            </section>

            {{-- KPIs compactos --}}
            <section class="grid grid-cols-3 gap-3 sm:gap-4 mb-6">
                <div
                    class="rounded-2xl sm:rounded-3xl bg-[#111827]
                           border border-white/10 px-4 py-4 sm:px-5 sm:py-5">

                    <div class="flex items-center justify-between gap-2">
                        <div>
                            <p
                                class="text-[9px] sm:text-[11px] font-black uppercase
                                       tracking-[0.15em] text-gray-500">
                                Eventos
                            </p>

                            <p class="mt-1 text-2xl sm:text-4xl font-black">
                                {{ $matches->count() }}
                            </p>
                        </div>

                        <div
                            class="hidden sm:flex w-11 h-11 rounded-2xl
                                   bg-blue-500/10 text-blue-300
                                   items-center justify-center text-xl">
                            🎥
                        </div>
                    </div>
                </div>

                <div
                    class="rounded-2xl sm:rounded-3xl bg-[#111827]
                           border border-white/10 px-4 py-4 sm:px-5 sm:py-5">

                    <div class="flex items-center justify-between gap-2">
                        <div>
                            <p
                                class="text-[9px] sm:text-[11px] font-black uppercase
                                       tracking-[0.15em] text-gray-500">
                                En vivo
                            </p>

                            <p class="mt-1 text-2xl sm:text-4xl font-black text-green-400">
                                {{ $matches->where('status', 'live')->count() }}
                            </p>
                        </div>

                        <div
                            class="hidden sm:flex w-11 h-11 rounded-2xl
                                   bg-green-500/10 text-green-300
                                   items-center justify-center text-xl">
                            ●
                        </div>
                    </div>
                </div>

                <div
                    class="rounded-2xl sm:rounded-3xl bg-[#111827]
                           border border-white/10 px-4 py-4 sm:px-5 sm:py-5">

                    <div class="flex items-center justify-between gap-2">
                        <div>
                            <p
                                class="text-[9px] sm:text-[11px] font-black uppercase
                                       tracking-[0.15em] text-gray-500">
                                Finalizados
                            </p>

                            <p class="mt-1 text-2xl sm:text-4xl font-black text-gray-300">
                                {{ $matches->where('status', 'finished')->count() }}
                            </p>
                        </div>

                        <div
                            class="hidden sm:flex w-11 h-11 rounded-2xl
                                   bg-white/5 text-gray-400
                                   items-center justify-center text-xl">
                            ✓
                        </div>
                    </div>
                </div>
            </section>

            {{-- Cabecera de eventos --}}
            <div class="flex items-center justify-between mb-4 px-1">
                <div>
                    <h2 class="text-xl sm:text-2xl font-black">
                        Eventos
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Selecciona un evento para comenzar a operar.
                    </p>
                </div>
            </div>

            {{-- Lista --}}
            <section class="space-y-4">
                @forelse ($matches as $match)
                    @php
                        $statusLabel = match ($match->status) {
                            'live' => 'EN VIVO',
                            'halftime' => 'DESCANSO',
                            'finished' => 'FINALIZADO',
                            default => 'PREVIA',
                        };

                        $statusDot = match ($match->status) {
                            'live' => 'bg-red-400 animate-pulse',
                            'halftime' => 'bg-yellow-400',
                            'finished' => 'bg-gray-500',
                            default => 'bg-blue-400',
                        };

                        $statusClasses = match ($match->status) {
                            'live' => 'bg-red-500/10 text-red-300 border-red-400/20',
                            'halftime' => 'bg-yellow-500/10 text-yellow-300 border-yellow-400/20',
                            'finished' => 'bg-gray-500/10 text-gray-300 border-gray-400/20',
                            default => 'bg-blue-500/10 text-blue-300 border-blue-400/20',
                        };
                    @endphp

                    <article
                        class="group rounded-[2rem] bg-[#0f1724]
                               border border-white/10
                               hover:border-blue-400/25
                               shadow-xl shadow-black/15
                               transition overflow-hidden">

                        <div class="p-5 sm:p-6">
                            <div class="flex flex-col xl:flex-row xl:items-center gap-5">

                                {{-- Estado e información --}}
                                <div class="xl:w-52 shrink-0">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span
                                            class="inline-flex items-center gap-2 px-3 py-1.5
                                                   rounded-full border text-[10px]
                                                   font-black tracking-[0.15em]
                                                   {{ $statusClasses }}">

                                            <span class="w-2 h-2 rounded-full {{ $statusDot }}"></span>
                                            {{ $statusLabel }}
                                        </span>

                                        <span
                                            class="text-[10px] uppercase tracking-[0.15em]
                                                   font-black text-gray-500">
                                            {{ $match->sport === 'football' ? 'Fútbol' : 'Vóley' }}
                                        </span>
                                    </div>

                                    <p class="mt-3 text-sm font-bold text-gray-300 line-clamp-2">
                                        {{ $match->title ?: 'Partido en vivo' }}
                                    </p>

                                    <p class="mt-1 text-xs text-gray-600">
                                        Periodo {{ $match->period ?? '1T' }}
                                    </p>
                                </div>

                                {{-- Marcador principal --}}
                                <div class="flex-1">
                                    <div
                                        class="grid grid-cols-[minmax(0,1fr)_auto_minmax(0,1fr)]
                                               items-center gap-3 sm:gap-6">

                                        <div class="min-w-0 text-right">
                                            <p
                                                class="text-base sm:text-xl lg:text-2xl
                                                       font-black truncate">
                                                {{ $match->team_a_name }}
                                            </p>

                                            <p
                                                class="mt-1 text-[10px] font-black uppercase
                                                       tracking-[0.18em] text-blue-400">
                                                Local
                                            </p>
                                        </div>

                                        <div
                                            class="flex items-center gap-3 sm:gap-5
                                                   px-4 sm:px-7 py-3
                                                   rounded-2xl bg-black/30
                                                   border border-white/10">

                                            <span class="text-3xl sm:text-5xl font-black">
                                                {{ $match->team_a_score ?? 0 }}
                                            </span>

                                            <span class="text-gray-600 font-black">
                                                —
                                            </span>

                                            <span class="text-3xl sm:text-5xl font-black">
                                                {{ $match->team_b_score ?? 0 }}
                                            </span>
                                        </div>

                                        <div class="min-w-0">
                                            <p
                                                class="text-base sm:text-xl lg:text-2xl
                                                       font-black truncate">
                                                {{ $match->team_b_name }}
                                            </p>

                                            <p
                                                class="mt-1 text-[10px] font-black uppercase
                                                       tracking-[0.18em] text-red-400">
                                                Visitante
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Acciones --}}
                                <div class="grid grid-cols-3 gap-2 xl:w-[330px] shrink-0">

                                    <a href="{{ route('matches.control', $match) }}"
                                        class="h-11 px-3 rounded-xl
                                               bg-blue-600 hover:bg-blue-500
                                               inline-flex items-center justify-center gap-2
                                               text-xs sm:text-sm font-black
                                               transition active:scale-95">
                                        <span class="hidden sm:inline">🎮</span>
                                        Control
                                    </a>

                                    <a href="{{ route('matches.settings', $match) }}"
                                        class="h-11 px-3 rounded-xl
                                               bg-white/10 hover:bg-white/20
                                               border border-white/10
                                               inline-flex items-center justify-center gap-2
                                               text-xs sm:text-sm font-black
                                               transition active:scale-95">
                                        <span class="hidden sm:inline">⚙️</span>
                                        Configurar
                                    </a>

                                    <a href="{{ route('matches.overlay', $match) }}" target="_blank"
                                        class="h-11 px-3 rounded-xl
                                               bg-red-600 hover:bg-red-500
                                               inline-flex items-center justify-center gap-2
                                               text-xs sm:text-sm font-black
                                               transition active:scale-95">
                                        <span class="hidden sm:inline">📺</span>
                                        Overlay
                                    </a>
                                </div>
                            </div>
                        </div>
                    </article>
                @empty
                    <div
                        class="rounded-[2rem] bg-[#111827]
                               border border-dashed border-white/15
                               px-6 py-14 text-center">

                        <div
                            class="mx-auto w-20 h-20 rounded-3xl
                                   bg-blue-600/15
                                   flex items-center justify-center text-4xl">
                            🎥
                        </div>

                        <h2 class="mt-6 text-2xl font-black">
                            No hay eventos creados
                        </h2>

                        <p class="mt-2 text-gray-400">
                            Crea el primer partido para comenzar una transmisión.
                        </p>

                        <a href="{{ route('matches.create') }}"
                            class="mt-6 inline-flex items-center justify-center
                                   h-12 px-6 rounded-2xl
                                   bg-blue-600 hover:bg-blue-500
                                   font-black transition">
                            Crear primer partido
                        </a>
                    </div>
                @endforelse
            </section>
        </div>
    </div>
</x-app-layout>
