<div
    class="order-1 lg:order-2 rounded-[1.8rem] bg-gradient-to-b from-[#172033] to-[#0b1020] border border-blue-400/10 p-5">

    {{-- PANEL MARCADOR --}}
    <div>

        <div class="flex justify-between items-center mb-5">

            <div>
                <p class="text-blue-400 text-xs font-black uppercase tracking-[0.25em]">
                    Modo de transmisión
                </p>

                <h2 class="text-2xl font-black text-white">
                    Marcador Deportivo
                </h2>
            </div>

            <form data-full-refresh="true" method="POST" action="/matches/{{ $match->id }}/banner">
                @csrf
                @method('PATCH')

                <input type="hidden" name="broadcast_mode" value="banner">
                <input type="hidden" name="banner_enabled" value="{{ $match->banner_enabled ? 1 : 0 }}">
                <input type="hidden" name="banner_label" value="{{ $match->banner_label }}">
                <input type="hidden" name="banner_title" value="{{ $match->banner_title }}">

                <button class="px-5 h-11 rounded-xl bg-blue-600 hover:bg-blue-500 font-black transition">
                    Banner →
                </button>

            </form>

        </div>

        <div class="text-center">
            <p class="text-blue-400 text-xs font-black uppercase tracking-[0.25em] mb-4">Tiempo de juego
            </p>

            <div id="timer-text" class="text-7xl md:text-8xl font-black tracking-tight">
                {{ floor($match->timer_seconds / 60) }}:{{ str_pad($match->timer_seconds % 60, 2, '0', STR_PAD_LEFT) }}
            </div>

            <div id="period-text"
                class="inline-flex mt-5 px-6 py-2 rounded-full bg-blue-600/20 text-blue-300 font-black">
                {{ $match->period }}
            </div>
        </div>

        <div class="mt-8 space-y-3">
            <form method="POST" action="{{ route('matches.updateTimer', $match) }}">
                @csrf
                @method('PATCH')
                <input type="hidden" name="action" value="start">
                <button data-timer-action="start"
                    class="w-full h-20 rounded-3xl bg-green-600 hover:bg-green-500 border border-green-300/20 font-black text-lg shadow-xl active:scale-95 transition">
                    ▶ INICIAR / REANUDAR
                </button>
            </form>

            <div class="grid grid-cols-2 gap-3">
                <form method="POST" action="{{ route('matches.updateTimer', $match) }}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="action" value="pause">
                    <button data-timer-action="pause"
                        class="w-full h-14 rounded-2xl bg-white/10 hover:bg-white/20 border border-white/10 font-black active:scale-95 transition">
                        ⏸ Pausar
                    </button>
                </form>

                <form method="POST" action="{{ route('matches.updateTimer', $match) }}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="action" value="finish">
                    <button data-timer-action="finish"
                        class="w-full h-14 rounded-2xl bg-red-600 hover:bg-red-500 border border-red-300/20 font-black active:scale-95 transition">
                        Finalizar
                    </button>
                </form>

                <form method="POST" action="{{ route('matches.updateTimer', $match) }}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="action" value="set_45">
                    <button data-timer-action="set_45"
                        class="w-full h-14 rounded-2xl bg-white/10 hover:bg-white/20 border border-white/10 font-black active:scale-95 transition">
                        ⏱ Descanso
                    </button>
                </form>

                <form method="POST" action="{{ route('matches.updateTimer', $match) }}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="action" value="start_second_half">
                    <button data-timer-action="start_second_half"
                        class="w-full h-14 rounded-2xl bg-white/10 hover:bg-white/20 border border-white/10 font-black active:scale-95 transition">
                        ▶ Iniciar 2T
                    </button>
                </form>

                <form method="POST" action="{{ route('matches.updateTimer', $match) }}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="action" value="subtract_minute">
                    <button data-timer-action="subtract_minute"
                        class="w-full h-14 rounded-2xl bg-white/10 hover:bg-white/20 border border-white/10 font-black active:scale-95 transition">
                        − 1 min
                    </button>
                </form>

                <form method="POST" action="{{ route('matches.updateTimer', $match) }}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="action" value="add_minute">
                    <button data-timer-action="add_minute"
                        class="w-full h-14 rounded-2xl bg-white/10 hover:bg-white/20 border border-white/10 font-black active:scale-95 transition">
                        + 1 min
                    </button>
                </form>
            </div>

            <form method="POST" action="{{ route('matches.updateTimer', $match) }}">
                @csrf
                @method('PATCH')
                <input type="hidden" name="action" value="reset">
                <button data-timer-action="reset"
                    class="w-full h-12 rounded-2xl bg-white/5 hover:bg-white/10 border border-white/10 font-black active:scale-95 transition">
                    Reiniciar partido
                </button>
            </form>

            <div class="mt-4 rounded-3xl bg-black/30 border border-white/10 p-4">
                <form method="POST" action="{{ route('matches.updatePenalties', $match) }}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="action" value="toggle">

                    <button id="penalties-toggle"
                        class="w-full h-12 rounded-2xl font-black active:scale-95 transition
                                    {{ $match->penalties_enabled ? 'bg-yellow-400 text-black' : 'bg-white/10 hover:bg-white/20' }}">
                        Penales {{ $match->penalties_enabled ? 'ACTIVOS' : 'OFF' }}
                    </button>
                </form>

                <div class="grid grid-cols-2 gap-4 mt-4">
                    @foreach (['a' => 'Local', 'b' => 'Visitante'] as $team => $label)
                        @php
                            $penalties =
                                $team === 'a'
                                    ? $match->team_a_penalties ?? array_fill(0, 5, null)
                                    : $match->team_b_penalties ?? array_fill(0, 5, null);
                        @endphp

                        <div>
                            <p
                                class="text-xs font-black uppercase mb-2 {{ $team === 'a' ? 'text-blue-300' : 'text-red-300' }}">
                                {{ $label }}
                            </p>

                            <div id="team-{{ $team }}-penalty-dots" class="grid grid-cols-5 gap-2 mb-3">
                                @foreach ($penalties as $value)
                                    <div
                                        class="w-8 h-8 rounded-full border-2
                            {{ $value === 'gol' ? 'bg-green-500 border-green-300' : '' }}
                            {{ $value === 'falla' ? 'bg-red-500 border-red-300' : '' }}
                            {{ $value === null ? 'bg-black/40 border-white/40' : '' }}">
                                    </div>
                                @endforeach
                            </div>

                            <div class="grid grid-cols-2 gap-2">
                                <form method="POST" action="{{ route('matches.updatePenalties', $match) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="team" value="{{ $team }}">
                                    <input type="hidden" name="action" value="gol">
                                    <button
                                        class="w-full h-10 rounded-xl bg-green-600 hover:bg-green-500 font-black text-sm">
                                        Gol
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('matches.updatePenalties', $match) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="team" value="{{ $team }}">
                                    <input type="hidden" name="action" value="falla">
                                    <button
                                        class="w-full h-10 rounded-xl bg-red-600 hover:bg-red-500 font-black text-sm">
                                        Falla
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <form class="mt-4" method="POST" action="{{ route('matches.updatePenalties', $match) }}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="action" value="reset">

                    <button
                        class="w-full h-10 rounded-xl bg-white/10 hover:bg-white/20 border border-white/10 font-black text-sm">
                        Reiniciar tanda
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
