<div class="absolute top-8 left-8 scoreboard-root">

    {{-- MARCADOR + PENALES --}}
    <div class="relative">
        <div class="flex items-stretch overflow-hidden rounded-2xl shadow-2xl text-white font-black">

            <div id="team-a-bg" class="flex items-center gap-5 px-8 py-4 min-w-[380px] bg-cover bg-center"
                @if ($match->team_a_background) style="background-image: linear-gradient(rgba(0,0,0,.25), rgba(0,0,0,.25)), url('/storage/{{ $match->team_a_background }}');"
                @else
                    style="background-image: none; background-color: {{ $match->team_a_color ?? '#1d4ed8' }};" @endif>

                <div id="team-a-logo-container"
                    class="w-14 h-14 rounded-full bg-white/20 flex items-center justify-center overflow-hidden">
                    @if ($match->team_a_logo)
                        <img src="/storage/{{ $match->team_a_logo }}" class="w-full h-full object-contain">
                    @else
                        <svg viewBox="0 0 64 64" class="w-10 h-10 drop-shadow">
                            <path id="team-a-jersey-fill" fill="{{ $match->team_a_jersey_color ?? '#1e40af' }}"
                                d="M22 8 L28 14 H36 L42 8 L56 16 L50 30 L44 27 V56 H20 V27 L14 30 L8 16 Z" />
                        </svg>
                    @endif
                </div>

                <div id="team-a-name" class="text-3xl truncate">
                    {{ $match->team_a_name }}
                </div>
            </div>

            <div
                class="relative flex items-center justify-center px-10 min-w-[190px] bg-gradient-to-b from-[#232323] to-[#050505] border-y border-white/10 shadow-[0_0_30px_rgba(0,0,0,.45)]">
                <div class="absolute inset-x-0 top-0 h-px bg-white/20"></div>
                <div class="absolute inset-x-0 bottom-0 h-px bg-black/60"></div>

                <div class="flex items-center gap-5">
                    <span id="team-a-score" class="text-6xl font-black tracking-tight drop-shadow-lg">
                        {{ $match->team_a_score }}
                    </span>

                    <span class="text-3xl font-light text-white/60">—</span>

                    <span id="team-b-score" class="text-6xl font-black tracking-tight drop-shadow-lg">
                        {{ $match->team_b_score }}
                    </span>
                </div>
            </div>

            <div id="team-b-bg" class="flex items-center justify-end gap-5 px-8 py-4 min-w-[380px] bg-cover bg-center"
                @if ($match->team_b_background) style="background-image: linear-gradient(rgba(0,0,0,.25), rgba(0,0,0,.25)), url('/storage/{{ $match->team_b_background }}');"
                @else
                    style="background-image: none; background-color: {{ $match->team_b_color ?? '#dc2626' }};" @endif>

                <div id="team-b-name" class="text-3xl truncate text-right">
                    {{ $match->team_b_name }}
                </div>

                <div id="team-b-logo-container"
                    class="w-14 h-14 rounded-full bg-white/20 flex items-center justify-center overflow-hidden">
                    @if ($match->team_b_logo)
                        <img src="/storage/{{ $match->team_b_logo }}" class="w-full h-full object-contain">
                    @else
                        <svg viewBox="0 0 64 64" class="w-10 h-10 drop-shadow">
                            <path id="team-b-jersey-fill" fill="{{ $match->team_b_jersey_color ?? '#dc2626' }}"
                                d="M22 8 L28 14 H36 L42 8 L56 16 L50 30 L44 27 V56 H20 V27 L14 30 L8 16 Z" />
                        </svg>
                    @endif
                </div>
            </div>
        </div>

        {{-- FILA INFERIOR: CRONÓMETRO + PENALES --}}
        <div class="mt-1 flex items-center gap-4">
            <div class="inline-flex overflow-hidden rounded-xl shadow-xl text-white font-black">
                <div id="timer-text" class="px-6 py-2 bg-black/90 text-2xl">
                    {{ gmdate('i:s', $match->currentTimerSeconds()) }}
                </div>

                <div id="period-text" class="px-5 py-2 bg-blue-700 text-2xl">
                    {{ $match->period }}
                </div>

                <div id="status-text"
                    class="px-5 py-2 text-2xl font-black transition-all duration-300
            {{ match ($match->status) {
                'live' => 'bg-red-600 text-white',
                'halftime' => 'bg-yellow-400 text-black',
                'finished' => 'bg-gray-700 text-white',
                default => 'bg-slate-600 text-white',
            } }}">
                    @switch($match->status)
                        @case('live')
                            EN VIVO
                        @break

                        @case('halftime')
                            DESCANSO
                        @break

                        @case('finished')
                            FINALIZADO
                        @break

                        @default
                            PREVIA
                    @endswitch
                </div>
            </div>

            <div id="penalties-row"
                class="{{ $match->penalties_enabled ? 'flex' : 'hidden' }} items-center gap-5 rounded-full bg-black/85 px-5 py-2 shadow-xl">

                <div id="overlay-team-a-penalty-dots" class="flex gap-2">
                    @foreach ($match->team_a_penalties ?? array_fill(0, 5, null) as $value)
                        <div
                            class="w-4 h-4 rounded-full border
                    {{ $value === 'gol' ? 'bg-green-500 border-green-300' : '' }}
                    {{ $value === 'falla' ? 'bg-red-500 border-red-300' : '' }}
                    {{ $value === null ? 'bg-gray-600 border-gray-400' : '' }}">
                        </div>
                    @endforeach
                </div>

                <div style="width: 4px; height: 24px; background: #000; border-radius: 9999px; margin: 0 10px;">
                </div>

                <div id="overlay-team-b-penalty-dots" class="flex gap-2">
                    @foreach ($match->team_b_penalties ?? array_fill(0, 5, null) as $value)
                        <div
                            class="w-4 h-4 rounded-full border
                    {{ $value === 'gol' ? 'bg-green-500 border-green-300' : '' }}
                    {{ $value === 'falla' ? 'bg-red-500 border-red-300' : '' }}
                    {{ $value === null ? 'bg-gray-600 border-gray-400' : '' }}">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
