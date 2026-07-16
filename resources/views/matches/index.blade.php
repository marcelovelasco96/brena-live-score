<x-app-layout>
    <div class="min-h-screen bg-[#070A12] text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- Encabezado principal --}}
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-8">
                <div>
                    <p class="text-blue-400 text-xs font-black uppercase tracking-[0.35em]">
                        Breña Live Studio
                    </p>

                    <h1 class="mt-2 text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight">
                        Centro de transmisiones
                    </h1>

                    <p class="mt-3 text-gray-400 max-w-2xl">
                        Crea eventos, configura la identidad visual y controla en tiempo real
                        la salida que se mostrará durante la transmisión.
                    </p>
                </div>

                <a href="{{ route('matches.create') }}"
                    class="inline-flex items-center justify-center gap-2 h-14 px-6 rounded-2xl
                           bg-blue-600 hover:bg-blue-500 text-white font-black
                           shadow-xl shadow-blue-950/30 transition active:scale-95">
                    <span class="text-xl">＋</span>
                    Nuevo partido
                </a>
            </div>

            {{-- Resumen --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                <div class="rounded-3xl bg-[#111827] border border-white/10 p-5">
                    <p class="text-xs font-black uppercase tracking-[0.2em] text-gray-500">
                        Total de eventos
                    </p>

                    <p class="mt-2 text-4xl font-black">
                        {{ $matches->count() }}
                    </p>
                </div>

                <div class="rounded-3xl bg-[#111827] border border-white/10 p-5">
                    <p class="text-xs font-black uppercase tracking-[0.2em] text-gray-500">
                        En vivo
                    </p>

                    <p class="mt-2 text-4xl font-black text-green-400">
                        {{ $matches->where('status', 'live')->count() }}
                    </p>
                </div>

                <div class="rounded-3xl bg-[#111827] border border-white/10 p-5">
                    <p class="text-xs font-black uppercase tracking-[0.2em] text-gray-500">
                        Finalizados
                    </p>

                    <p class="mt-2 text-4xl font-black text-gray-300">
                        {{ $matches->where('status', 'finished')->count() }}
                    </p>
                </div>
            </div>

            {{-- Lista de partidos --}}
            @forelse ($matches as $match)
                @php
                    $statusLabel = match ($match->status) {
                        'live' => 'EN VIVO',
                        'halftime' => 'DESCANSO',
                        'finished' => 'FINALIZADO',
                        default => 'PREVIA',
                    };

                    $statusClasses = match ($match->status) {
                        'live' => 'bg-red-500/15 text-red-300 border-red-400/20',
                        'halftime' => 'bg-yellow-500/15 text-yellow-300 border-yellow-400/20',
                        'finished' => 'bg-gray-500/15 text-gray-300 border-gray-400/20',
                        default => 'bg-blue-500/15 text-blue-300 border-blue-400/20',
                    };
                @endphp

                <article
                    class="mb-5 overflow-hidden rounded-[2rem] bg-[#0f1724]
                           border border-white/10 shadow-2xl shadow-black/20">

                    <div class="p-5 sm:p-7">
                        <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-6">

                            {{-- Información y marcador --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-3 mb-5">
                                    <span
                                        class="inline-flex px-3 py-1.5 rounded-full border
                                               text-[11px] font-black tracking-[0.18em]
                                               {{ $statusClasses }}">
                                        {{ $statusLabel }}
                                    </span>

                                    <span class="text-xs font-black uppercase tracking-[0.18em] text-gray-500">
                                        {{ $match->sport === 'football' ? 'Fútbol' : 'Vóley' }}
                                    </span>

                                    @if ($match->title)
                                        <span class="text-sm text-gray-400">
                                            {{ $match->title }}
                                        </span>
                                    @endif
                                </div>

                                <div class="grid grid-cols-[1fr_auto_1fr] items-center gap-3 sm:gap-6">
                                    <div class="min-w-0 text-right">
                                        <p class="text-lg sm:text-2xl font-black truncate">
                                            {{ $match->team_a_name }}
                                        </p>
                                        <p class="mt-1 text-xs uppercase tracking-[0.18em] text-blue-400 font-black">
                                            Local
                                        </p>
                                    </div>

                                    <div
                                        class="flex items-center gap-3 sm:gap-5 px-4 sm:px-6 py-3
                                               rounded-2xl bg-black/30 border border-white/10">
                                        <span class="text-3xl sm:text-5xl font-black">
                                            {{ $match->team_a_score ?? 0 }}
                                        </span>

                                        <span class="text-gray-600 text-xl font-black">—</span>

                                        <span class="text-3xl sm:text-5xl font-black">
                                            {{ $match->team_b_score ?? 0 }}
                                        </span>
                                    </div>

                                    <div class="min-w-0">
                                        <p class="text-lg sm:text-2xl font-black truncate">
                                            {{ $match->team_b_name }}
                                        </p>
                                        <p class="mt-1 text-xs uppercase tracking-[0.18em] text-red-400 font-black">
                                            Visitante
                                        </p>
                                    </div>
                                </div>

                                <div class="flex justify-center mt-5">
                                    <span
                                        class="px-4 py-2 rounded-xl bg-white/5 border border-white/10
                                               text-xs font-black text-gray-400">
                                        Periodo: {{ $match->period ?? '1T' }}
                                    </span>
                                </div>
                            </div>

                            {{-- Acciones --}}
                            <div class="grid grid-cols-1 sm:grid-cols-3 xl:grid-cols-1 gap-3 xl:w-48">
                                <a href="{{ route('matches.control', $match) }}"
                                    class="h-12 px-5 rounded-2xl bg-blue-600 hover:bg-blue-500
                                           inline-flex items-center justify-center gap-2
                                           font-black transition active:scale-95">
                                    🎮 Control
                                </a>

                                <a href="{{ route('matches.settings', $match) }}"
                                    class="h-12 px-5 rounded-2xl bg-white/10 hover:bg-white/20
                                           border border-white/10
                                           inline-flex items-center justify-center gap-2
                                           font-black transition active:scale-95">
                                    ⚙️ Configurar
                                </a>

                                <a href="{{ route('matches.overlay', $match) }}" target="_blank"
                                    class="h-12 px-5 rounded-2xl bg-red-600 hover:bg-red-500
                                           inline-flex items-center justify-center gap-2
                                           font-black transition active:scale-95">
                                    📺 Overlay
                                </a>
                            </div>
                        </div>
                    </div>
                </article>
            @empty
                <div
                    class="rounded-[2rem] bg-[#111827] border border-dashed border-white/15
                           px-6 py-16 text-center">

                    <div
                        class="mx-auto w-20 h-20 rounded-3xl bg-blue-600/15
                               flex items-center justify-center text-4xl">
                        🎥
                    </div>

                    <h2 class="mt-6 text-2xl font-black">
                        Aún no hay transmisiones
                    </h2>

                    <p class="mt-2 text-gray-400">
                        Crea el primer partido y comienza a configurar tu salida en vivo.
                    </p>

                    <a href="{{ route('matches.create') }}"
                        class="mt-6 inline-flex items-center justify-center h-12 px-6
                               rounded-2xl bg-blue-600 hover:bg-blue-500 font-black transition">
                        Crear primer partido
                    </a>
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>
