<div
    class="order-1 lg:order-2 rounded-[1.8rem] bg-gradient-to-b from-[#151c2b] to-[#0f1724]
    border border-white/10 p-5">

    {{-- SET ACTUAL --}}
    <div class="text-center">
        <p class="text-white/50 text-xs font-black uppercase tracking-[0.3em]">
            Set actual
        </p>

        <h2 id="volleyball-set-number" class="mt-2 text-5xl font-black">
            {{ $match->set_number ?? 1 }}
        </h2>

        <div class="mt-3">
            @if ($match->status === 'finished')
                <span
                    class="inline-flex rounded-full bg-red-500/15 border border-red-400/20
                    px-4 py-2 text-xs font-black uppercase tracking-widest text-red-300">
                    Partido finalizado
                </span>
            @elseif ($match->status === 'live')
                <span
                    class="inline-flex rounded-full bg-green-500/15 border border-green-400/20
                    px-4 py-2 text-xs font-black uppercase tracking-widest text-green-300">
                    En juego
                </span>
            @else
                <span
                    class="inline-flex rounded-full bg-white/10 border border-white/10
                    px-4 py-2 text-xs font-black uppercase tracking-widest text-white/60">
                    Previa
                </span>
            @endif
        </div>
    </div>

    {{-- SETS GANADOS --}}
    <div class="mt-8 grid grid-cols-2 gap-4">
        <div class="rounded-3xl border border-white/10 bg-white/[0.04] p-5 text-center">
            <p class="truncate text-sm font-black text-white/60">
                {{ $match->team_a_name }}
            </p>

            <p id="team-a-sets" class="mt-2 text-6xl font-black">
                {{ $match->team_a_sets ?? 0 }}
            </p>

            <p class="mt-1 text-xs font-black uppercase tracking-widest text-white/40">
                Sets
            </p>
        </div>

        <div class="rounded-3xl border border-white/10 bg-white/[0.04] p-5 text-center">
            <p class="truncate text-sm font-black text-white/60">
                {{ $match->team_b_name }}
            </p>

            <p id="team-b-sets" class="mt-2 text-6xl font-black">
                {{ $match->team_b_sets ?? 0 }}
            </p>

            <p class="mt-1 text-xs font-black uppercase tracking-widest text-white/40">
                Sets
            </p>
        </div>
    </div>

    {{-- ACCIONES DEL PARTIDO --}}
    <div class="mt-6 grid grid-cols-3 gap-3">

        {{-- INICIAR --}}
        <form method="POST" action="{{ route('matches.updateVolleyball', $match) }}">
            @csrf
            @method('PATCH')

            <input type="hidden" name="action" value="start">

            <button id="volleyball-start-button"
                class="w-full h-12 rounded-2xl bg-green-600/90 hover:bg-green-500
                border border-green-300/20 text-sm font-black
                shadow-lg active:scale-95 transition
                disabled:opacity-40 disabled:cursor-not-allowed"
                @disabled($match->status !== 'pre_match')>

                Iniciar
            </button>
        </form>

        {{-- FINALIZAR --}}
        <form method="POST" action="{{ route('matches.updateVolleyball', $match) }}">
            @csrf
            @method('PATCH')

            <input type="hidden" name="action" value="finish_match">

            <button id="volleyball-finish-button"
                class="w-full h-12 rounded-2xl bg-red-600/90 hover:bg-red-500
                border border-red-300/20 text-sm font-black
                shadow-lg active:scale-95 transition
                disabled:opacity-40 disabled:cursor-not-allowed"
                @disabled($match->status !== 'live')>

                Finalizar
            </button>
        </form>

        {{-- REINICIAR --}}
        <form method="POST" action="{{ route('matches.updateVolleyball', $match) }}"
            onsubmit="return confirm('¿Seguro que deseas reiniciar todo el partido?');">

            @csrf
            @method('PATCH')

            <input type="hidden" name="action" value="reset_match">

            <button id="volleyball-reset-button"
                class="w-full h-12 rounded-2xl bg-white/10 hover:bg-white/15
                border border-white/10 text-sm font-black
                shadow-lg active:scale-95 transition">

                Reiniciar
            </button>
        </form>
    </div>
</div>
