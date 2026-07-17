<div class="scoreboard-root absolute left-8 top-8">

    {{-- CABECERA --}}
    <div
        class="mx-auto mb-1 w-fit rounded-t-xl border border-b-0 border-white/10
        bg-[#07131d] px-7 py-2 shadow-xl">

        <div class="flex items-center gap-4">
            <span class="text-xs font-black uppercase tracking-[0.25em] text-white">
                MUNICIPALIDAD DE BREÑA
            </span>

            <span class="text-yellow-400">•</span>

            <span class="text-xs font-black uppercase tracking-[0.25em] text-yellow-300">
                COPA INTERBARRIOS 2026
            </span>
        </div>
    </div>

    {{-- MARCADOR --}}
    <div
        class="flex h-[96px] w-[1230px] items-stretch overflow-hidden
        rounded-2xl border border-white/15 bg-[#07131d]
        font-black text-white shadow-2xl">

        {{-- BARRA LOCAL --}}
        <div class="w-3 shrink-0" style="background-color: {{ $match->team_a_color ?? '#1d4ed8' }}">
        </div>

        {{-- EQUIPO LOCAL --}}
        <div id="team-a-bg"
            class="relative flex w-[310px] shrink-0 items-center gap-4
            overflow-hidden bg-cover bg-center px-6"
            @if ($match->team_a_background) style="
                    background-image:
                    linear-gradient(90deg, rgba(5,17,27,.97), rgba(5,17,27,.76)),
                    url('/storage/{{ $match->team_a_background }}');
                "
            @else
                style="background-color: #07131d;" @endif>

            <div id="team-a-logo-container"
                class="flex h-14 w-14 shrink-0 items-center justify-center
                overflow-hidden rounded-full bg-white/10">

                @if ($match->team_a_logo)
                    <img src="/storage/{{ $match->team_a_logo }}" class="h-full w-full object-contain">
                @else
                    <svg viewBox="0 0 64 64" class="h-10 w-10">
                        <path id="team-a-jersey-fill" fill="{{ $match->team_a_jersey_color ?? '#1e40af' }}"
                            d="M22 8 L28 14 H36 L42 8 L56 16 L50 30 L44 27 V56 H20 V27 L14 30 L8 16 Z" />
                    </svg>
                @endif
            </div>

            <div class="min-w-0">
                <div id="team-a-name" class="max-w-[215px] truncate text-3xl font-black uppercase">
                    {{ $match->team_a_name }}
                </div>
            </div>
        </div>

        {{-- SETS LOCAL --}}
        <div
            class="flex w-[82px] shrink-0 flex-col items-center justify-center
            border-l border-white/10 bg-[#0d2630]">

            <span class="text-[11px] font-black uppercase tracking-[0.18em] text-cyan-300">
                Sets
            </span>

            <span id="team-a-sets" class="mt-1 text-4xl font-black leading-none">
                {{ $match->team_a_sets ?? 0 }}
            </span>
        </div>

        {{-- PUNTOS LOCAL --}}
        <div class="flex w-[125px] shrink-0 items-center justify-center
            bg-cyan-400 text-[#061018]">

            <span id="team-a-score" class="text-7xl font-black leading-none">
                {{ $match->team_a_score }}
            </span>
        </div>

        {{-- CENTRO --}}
        <div class="relative flex w-[160px] shrink-0 flex-col items-center
            justify-center bg-[#061018]">

            <div class="absolute left-0 top-0 h-full w-3 bg-cyan-400"
                style="clip-path: polygon(0 0, 100% 50%, 0 100%);">
            </div>

            <div class="absolute right-0 top-0 h-full w-3 bg-cyan-400"
                style="clip-path: polygon(100% 0, 0 50%, 100% 100%);">
            </div>

            <span class="text-[10px] uppercase tracking-[0.22em] text-white/45">
                Set actual
            </span>

            <span id="set-number-text" class="mt-1 text-2xl font-black leading-none">
                {{ $match->set_number ?? 1 }}
            </span>

            <span id="status-text"
                class="mt-2 rounded-full px-3 py-1 text-[10px]
                font-black uppercase tracking-[0.15em]
                {{ match ($match->status) {
                    'live' => 'bg-red-600 text-white',
                    'finished' => 'bg-gray-600 text-white',
                    default => 'bg-yellow-400 text-black',
                } }}">

                @switch($match->status)
                    @case('live')
                        En vivo
                    @break

                    @case('finished')
                        Final
                    @break

                    @default
                        Previa
                @endswitch
            </span>
        </div>

        {{-- PUNTOS VISITANTE --}}
        <div class="flex w-[125px] shrink-0 items-center justify-center
            bg-cyan-400 text-[#061018]">

            <span id="team-b-score" class="text-7xl font-black leading-none">
                {{ $match->team_b_score }}
            </span>
        </div>

        {{-- SETS VISITANTE --}}
        <div
            class="flex w-[82px] shrink-0 flex-col items-center justify-center
            border-r border-white/10 bg-[#0d2630]">

            <span class="text-[11px] font-black uppercase tracking-[0.18em] text-cyan-300">
                Sets
            </span>

            <span id="team-b-sets" class="mt-1 text-4xl font-black leading-none">
                {{ $match->team_b_sets ?? 0 }}
            </span>
        </div>

        {{-- EQUIPO VISITANTE --}}
        <div id="team-b-bg"
            class="relative flex w-[330px] shrink-0 items-center justify-end gap-4
            overflow-visible bg-cover bg-center pl-6 pr-10"
            @if ($match->team_b_background) style="
                    background-image:
                    linear-gradient(270deg, rgba(5,17,27,.97), rgba(5,17,27,.76)),
                    url('/storage/{{ $match->team_b_background }}');
                "
            @else
                style="background-color: #07131d;" @endif>

            <div class="absolute inset-y-0 right-0 w-3"
                style="background-color: {{ $match->team_b_color ?? '#dc2626' }}">
            </div>

            <div class="min-w-0 text-right">
                <div id="team-b-name" class="max-w-[215px] truncate text-3xl font-black uppercase">
                    {{ $match->team_b_name }}
                </div>
            </div>

            <div id="team-b-logo-container"
                class="flex h-14 w-14 shrink-0 items-center justify-center
                overflow-hidden rounded-full bg-white/10">

                @if ($match->team_b_logo)
                    <img src="/storage/{{ $match->team_b_logo }}" class="h-full w-full object-contain">
                @else
                    <svg viewBox="0 0 64 64" class="h-10 w-10">
                        <path id="team-b-jersey-fill" fill="{{ $match->team_b_jersey_color ?? '#dc2626' }}"
                            d="M22 8 L28 14 H36 L42 8 L56 16 L50 30 L44 27 V56 H20 V27 L14 30 L8 16 Z" />
                    </svg>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        async function refreshVolleyballScoreboard() {
            try {
                const response = await fetch(
                    "/overlay/{{ $match->id }}/data", {
                        headers: {
                            Accept: 'application/json'
                        }
                    }
                );

                if (!response.ok) return;

                const data = await response.json();

                const teamAScore = document.getElementById('team-a-score');
                const teamBScore = document.getElementById('team-b-score');
                const teamASets = document.getElementById('team-a-sets');
                const teamBSets = document.getElementById('team-b-sets');
                const setNumber = document.getElementById('set-number-text');
                const status = document.getElementById('status-text');

                if (teamAScore) teamAScore.textContent = data.team_a_score;
                if (teamBScore) teamBScore.textContent = data.team_b_score;
                if (teamASets) teamASets.textContent = data.team_a_sets ?? 0;
                if (teamBSets) teamBSets.textContent = data.team_b_sets ?? 0;
                if (setNumber) setNumber.textContent = data.set_number ?? 1;

                if (status) {
                    status.className =
                        'mt-2 rounded-full px-3 py-1 text-[10px] font-black uppercase tracking-[0.15em]';

                    if (data.status === 'live') {
                        status.textContent = 'En vivo';
                        status.classList.add('bg-red-600', 'text-white');
                    } else if (data.status === 'finished') {
                        status.textContent = 'Final';
                        status.classList.add('bg-gray-600', 'text-white');
                    } else {
                        status.textContent = 'Previa';
                        status.classList.add('bg-yellow-400', 'text-black');
                    }
                }
            } catch (error) {
                console.error('Error actualizando marcador de vóley:', error);
            }
        }

        refreshVolleyballScoreboard();
        setInterval(refreshVolleyballScoreboard, 1000);
    });
</script>
