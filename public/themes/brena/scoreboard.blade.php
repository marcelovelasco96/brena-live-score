<div class="absolute top-8 left-8 scoreboard-root">

    <div class="flex items-stretch overflow-hidden rounded-2xl shadow-2xl text-white font-black">

        <div id="team-a-bg"
            class="flex items-center gap-5 px-8 py-4 bg-gradient-to-r from-blue-800 to-blue-600 min-w-[380px] bg-cover bg-center"
            @if ($match->team_a_background) style="background-image: linear-gradient(rgba(0,0,0,.25), rgba(0,0,0,.25)), url('{{ asset('storage/' . $match->team_a_background) }}');" @endif>

            <div id="team-a-logo-container"
                class="w-14 h-14 rounded-full bg-white/20 flex items-center justify-center overflow-hidden">
                @if ($match->team_a_logo)
                    <img src="{{ asset('storage/' . $match->team_a_logo) }}" class="w-full h-full object-contain">
                @else
                    <span>⚽</span>
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

                <span class="text-4xl font-light text-white/60">
                    —
                </span>

                <span id="team-b-score" class="text-6xl font-black tracking-tight drop-shadow-lg">
                    {{ $match->team_b_score }}
                </span>
            </div>
        </div>

        <div id="team-b-bg"
            class="flex items-center gap-5 px-8 py-4 bg-gradient-to-r from-red-600 to-red-900 min-w-[380px] bg-cover bg-center"
            @if ($match->team_b_background) style="background-image: linear-gradient(rgba(0,0,0,.25), rgba(0,0,0,.25)), url('{{ asset('storage/' . $match->team_b_background) }}');" @endif>

            <div id="team-b-name" class="text-3xl truncate">
                {{ $match->team_b_name }}
            </div>

            <div id="team-b-logo-container"
                class="w-14 h-14 rounded-full bg-white/20 flex items-center justify-center overflow-hidden">
                @if ($match->team_b_logo)
                    <img src="{{ asset('storage/' . $match->team_b_logo) }}" class="w-full h-full object-contain">
                @else
                    <span>⚽</span>
                @endif
            </div>
        </div>
    </div>

    <div id="penalties-row" class="{{ $match->penalties_enabled ? 'flex' : 'hidden' }} mt-1 justify-center gap-10">

        <div id="overlay-team-a-penalty-dots" class="flex gap-2">
            @foreach ($match->team_a_penalties ?? array_fill(0, 5, null) as $value)
                <div
                    class="w-4 h-4 rounded-full border
                {{ $value === 'gol' ? 'bg-green-500 border-green-300' : '' }}
                {{ $value === 'falla' ? 'bg-red-500 border-red-300' : '' }}
                {{ $value === null ? 'bg-black/50 border-white/40' : '' }}">
                </div>
            @endforeach
        </div>

        <div id="overlay-team-b-penalty-dots" class="flex gap-2">
            @foreach ($match->team_b_penalties ?? array_fill(0, 5, null) as $value)
                <div
                    class="w-4 h-4 rounded-full border
                {{ $value === 'gol' ? 'bg-green-500 border-green-300' : '' }}
                {{ $value === 'falla' ? 'bg-red-500 border-red-300' : '' }}
                {{ $value === null ? 'bg-black/50 border-white/40' : '' }}">
                </div>
            @endforeach
        </div>
    </div>

    <div class="mt-2 inline-flex overflow-hidden rounded-xl shadow-xl text-white font-black">
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
                    🔴 EN VIVO
                @break

                @case('halftime')
                    ⏸ DESCANSO
                @break

                @case('finished')
                    🏁 FINAL
                @break

                @default
                    PREVIA
            @endswitch
        </div>
    </div>
</div>
