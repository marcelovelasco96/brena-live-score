<div class="order-2 lg:order-1 rounded-[1.8rem] bg-gradient-to-b from-[#151c2b] to-[#0f1724] border border-white/10 p-5">
    <div class="h-28 rounded-3xl border border-white/10 mb-5 flex items-center gap-5 px-6 bg-cover bg-center"
        style="
                            @if ($match->team_a_background) background-image: linear-gradient(rgba(0,0,0,.25), rgba(0,0,0,.25)), url('{{ '/storage/' . $match->team_a_background }}');
                            @else
                                background-color: {{ $match->team_a_color ?? '#1d4ed8' }}; @endif
                        ">

        <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center overflow-hidden shrink-0">
            @if ($match->team_a_logo)
                <img src="{{ '/storage/' . $match->team_a_logo }}" class="w-full h-full object-contain">
            @else
                <svg viewBox="0 0 64 64" class="w-12 h-12 drop-shadow">
                    <path fill="{{ $match->team_a_jersey_color ?? '#1e40af' }}"
                        d="M22 8 L28 14 H36 L42 8 L56 16 L50 30 L44 27 V56 H20 V27 L14 30 L8 16 Z" />
                </svg>
            @endif
        </div>

        <div class="min-w-0">
            <p class="text-white/60 text-xs font-black uppercase tracking-[0.25em]">
                Local
            </p>
            <h2 class="text-3xl font-black truncate">
                {{ $match->team_a_name }}
            </h2>
        </div>
    </div>

    <div class="text-center my-8">
        <div id="team-a-score" class="text-8xl md:text-9xl font-black leading-none">
            {{ $match->team_a_score }}
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <form method="POST" action="{{ route('matches.updateScore', $match) }}">
            @csrf
            @method('PATCH')
            <input type="hidden" name="team" value="a">
            <input type="hidden" name="action" value="decrement">
            <button
                class="w-full h-12 rounded-2xl bg-red-600/90 hover:bg-red-500 border border-red-300/20 text-3xl font-black shadow-lg active:scale-95 transition">
                −
            </button>
        </form>

        <form method="POST" action="{{ route('matches.updateScore', $match) }}">
            @csrf
            @method('PATCH')
            <input type="hidden" name="team" value="a">
            <input type="hidden" name="action" value="increment">
            <button
                class="w-full h-12 rounded-2xl bg-green-600/90 hover:bg-green-500 border border-green-300/20 text-3xl font-black shadow-lg active:scale-95 transition">
                +
            </button>
        </form>
    </div>
</div>
