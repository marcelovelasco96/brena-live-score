<div
    class="rounded-[1.8rem] bg-gradient-to-b from-[#172033] to-[#0b1020] border border-blue-400/10 p-6 max-w-3xl mx-auto">

    <div class="flex justify-between items-center mb-6">

        <div>
            <p class="text-blue-400 text-xs font-black uppercase tracking-[0.25em]">
                Modo de transmisión
            </p>

            <h2 class="text-2xl font-black text-white mt-2">
                Banner Institucional
            </h2>
        </div>

        <form data-full-refresh="true" method="POST" action="/matches/{{ $match->id }}/banner">
            @csrf
            @method('PATCH')

            <input type="hidden" name="broadcast_mode" value="sports">
            <input type="hidden" name="banner_enabled" value="{{ $match->banner_enabled ? 1 : 0 }}">
            <input type="hidden" name="banner_label" value="{{ $match->banner_label }}">
            <input type="hidden" name="banner_title" value="{{ $match->banner_title }}">

            <button class="px-5 h-11 rounded-xl bg-white/10 hover:bg-white/20 font-black">
                ← Volver al marcador
            </button>

        </form>

    </div>

    <form data-full-refresh="true" method="POST" action="/matches/{{ $match->id }}/banner">

        @csrf
        @method('PATCH')

        <input type="hidden" name="broadcast_mode" value="banner">

        <label class="flex items-center gap-3 text-white font-bold">

            <input type="checkbox" name="banner_enabled" value="1" {{ $match->banner_enabled ? 'checked' : '' }}>

            Mostrar banner

        </label>

        <label class="flex items-center gap-3 text-white font-bold">
            <input type="checkbox" name="banner_show_label" value="1"
                {{ $match->banner_show_label ? 'checked' : '' }}>

            Mostrar categoría
        </label>

        <div>

            <label class="block mb-2 text-sm font-bold text-gray-300">
                Categoría
            </label>

            <input type="text" name="banner_label" value="{{ $match->banner_label }}" placeholder="COLEGIO INVITADO"
                class="w-full rounded-xl bg-gray-900 border border-white/10 text-white">

        </div>

        <div>

            <label class="block mb-2 text-sm font-bold text-gray-300">
                Nombre principal
            </label>

            <input type="text" name="banner_title" value="{{ $match->banner_title }}"
                placeholder="I.E. MARIANO MELGAR"
                class="w-full rounded-xl bg-gray-900 border border-white/10 text-white">

        </div>

        <button class="w-full h-14 rounded-2xl bg-blue-600 hover:bg-blue-500 font-black">
            ACTUALIZAR BANNER
        </button>

    </form>

</div>
