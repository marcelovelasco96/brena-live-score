<x-app-layout>
    <div class="min-h-[calc(100vh-5rem)] bg-[#070A12] text-white">
        <div class="max-w-[1180px] mx-auto px-4 sm:px-6 lg:px-8 py-7">

            {{-- Encabezado --}}
            <div class="grid grid-cols-1 lg:grid-cols-[1fr_auto] lg:items-end gap-4 mb-6">
                <div>
                    <a href="{{ route('matches.index') }}"
                        class="inline-flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-white transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>

                        Volver al centro de transmisiones
                    </a>

                    <p class="mt-4 text-blue-400 text-xs font-black uppercase tracking-[0.35em]">
                        Breña Live Studio
                    </p>

                    <h1 class="mt-2 text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight">
                        Crear nuevo partido
                    </h1>

                    <p class="mt-3 max-w-2xl text-gray-400">
                        Registra los datos principales del evento. Al crearlo, ingresarás
                        directamente al panel de producción.
                    </p>
                </div>

                <div
                    class="justify-self-start lg:justify-self-end inline-flex items-center gap-2
                           rounded-xl bg-green-500/10 border border-green-400/15
                           px-4 py-2 text-xs font-black text-green-300">
                    <span class="w-2 h-2 rounded-full bg-green-400"></span>
                    Listo para configurar
                </div>
            </div>

            {{-- Errores --}}
            @if ($errors->any())
                <div class="mb-6 rounded-2xl bg-red-500/10 border border-red-400/20 px-5 py-4">
                    <p class="font-black text-red-300">
                        Revisa la información ingresada:
                    </p>

                    <ul class="mt-2 space-y-1 text-sm text-red-200">
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('matches.store') }}"
                class="overflow-hidden rounded-[2rem] bg-[#0f1724]
                       border border-white/10 shadow-2xl shadow-black/20">
                @csrf

                <div class="p-5 sm:p-7 space-y-6">

                    {{-- Paso 1 --}}
                    <section
                        class="overflow-hidden rounded-[1.6rem] bg-[#0b1220]
                               border border-white/10">

                        <div class="flex items-center gap-4 px-5 sm:px-6 py-5 border-b border-white/10">
                            <div
                                class="shrink-0 w-11 h-11 rounded-2xl bg-blue-600/15
                                       border border-blue-400/20 flex items-center justify-center
                                       text-blue-300 font-black">
                                1
                            </div>

                            <div>
                                <h2 class="text-lg sm:text-xl font-black">
                                    Información del evento
                                </h2>

                                <p class="mt-1 text-sm text-gray-500">
                                    Define el deporte y el nombre que identificará la transmisión.
                                </p>
                            </div>
                        </div>

                        <div class="p-6 sm:p-7 grid grid-cols-1 lg:grid-cols-[240px_1fr] gap-5">
                            <div>
                                <label for="sport"
                                    class="block mb-2 text-xs font-black uppercase
                                           tracking-[0.18em] text-gray-400">
                                    Deporte
                                </label>

                                <div class="relative">
                                    <select id="sport" name="sport"
                                        style="
                                            background-color: #070c16;
                                            color: #ffffff;
                                            border-color: rgba(255,255,255,.12);
                                            color-scheme: dark;
                                        "
                                        class="appearance-none w-full min-h-[54px] rounded-xl
                                               border px-4 pr-11
                                               hover:border-white/20 transition
                                               focus:border-blue-500 focus:ring-2
                                               focus:ring-blue-500/20">

                                        <option value="football" @selected(old('sport', 'football') === 'football')>
                                            Fútbol
                                        </option>

                                        <option value="volleyball" @selected(old('sport') === 'volleyball')>
                                            Vóley
                                        </option>
                                    </select>

                                    <svg class="pointer-events-none absolute right-4 top-1/2
                                               w-4 h-4 -translate-y-1/2 text-gray-500"
                                        fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>

                            <div>
                                <label for="title"
                                    class="block mb-2 text-xs font-black uppercase
                                           tracking-[0.18em] text-gray-400">
                                    Título o nombre del evento
                                </label>

                                <input id="title" type="text" name="title" value="{{ old('title') }}"
                                    placeholder="Ej: Interbarrios 2026 - Fecha 01"
                                    style="
                                        background-color: #070c16;
                                        color: #ffffff;
                                        border-color: rgba(255,255,255,.12);
                                    "
                                    class="w-full min-h-[54px] rounded-xl border px-4
                                           shadow-inner shadow-black/20
                                           placeholder:text-gray-600
                                           hover:border-white/20 transition
                                           focus:border-blue-500 focus:ring-2
                                           focus:ring-blue-500/20">
                            </div>
                        </div>
                    </section>

                    {{-- Paso 2 --}}
                    <section
                        class="overflow-hidden rounded-[1.6rem] bg-[#0b1220]
                               border border-white/10">

                        <div class="flex items-center gap-4 px-5 sm:px-6 py-5 border-b border-white/10">
                            <div
                                class="shrink-0 w-11 h-11 rounded-2xl bg-blue-600/15
                                       border border-blue-400/20 flex items-center justify-center
                                       text-blue-300 font-black">
                                2
                            </div>

                            <div>
                                <h2 class="text-lg sm:text-xl font-black">
                                    Equipos participantes
                                </h2>

                                <p class="mt-1 text-sm text-gray-500">
                                    Registra los nombres que aparecerán en el marcador y el overlay.
                                </p>
                            </div>
                        </div>

                        <div class="p-6 sm:p-7">

                            {{-- Vista previa --}}
                            <div
                                class="grid grid-cols-[minmax(0,1fr)_auto_minmax(0,1fr)]
                                       items-center gap-3 sm:gap-6 mb-6
                                       rounded-2xl bg-black/25 border border-white/10
                                       px-4 sm:px-6 py-5">

                                <div class="min-w-0 text-right">
                                    <p
                                        class="text-[10px] font-black uppercase
                                              tracking-[0.18em] text-blue-400">
                                        Local
                                    </p>

                                    <p id="new-match-local-preview"
                                        class="mt-1 text-lg sm:text-2xl font-black truncate">
                                        {{ old('team_a_name') ?: 'Equipo local' }}
                                    </p>
                                </div>

                                <div
                                    class="shrink-0 min-w-[76px] h-16 px-5 rounded-2xl
                                           bg-[#070c16] border border-white/10
                                           flex items-center justify-center
                                           text-[2rem] font-black tracking-tight">
                                    VS
                                </div>

                                <div class="min-w-0">
                                    <p
                                        class="text-[10px] font-black uppercase
                                              tracking-[0.18em] text-red-400">
                                        Visitante
                                    </p>

                                    <p id="new-match-visitor-preview"
                                        class="mt-1 text-lg sm:text-2xl font-black truncate">
                                        {{ old('team_b_name') ?: 'Equipo visitante' }}
                                    </p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                                {{-- Local --}}
                                <div
                                    class="rounded-2xl bg-blue-500/[0.05]
                                           border border-blue-400/15 p-5">

                                    <div class="flex items-center gap-3 mb-5">
                                        <div
                                            class="w-11 h-11 rounded-2xl bg-blue-600/20
                                                   border border-blue-400/15
                                                   flex items-center justify-center">
                                            <span class="w-3 h-3 rounded-full bg-blue-400"></span>
                                        </div>

                                        <div>
                                            <p
                                                class="text-[10px] font-black uppercase
                                                      tracking-[0.18em] text-blue-400">
                                                Local
                                            </p>

                                            <h3 class="mt-1 font-black">
                                                Equipo local
                                            </h3>
                                        </div>
                                    </div>

                                    <label for="team_a_name"
                                        class="block mb-2 text-xs font-black uppercase
                                               tracking-[0.18em] text-gray-400">
                                        Nombre del equipo
                                    </label>

                                    <input id="team_a_name" type="text" name="team_a_name"
                                        value="{{ old('team_a_name') }}" required placeholder="Ej: Breña FC"
                                        style="
                                            background-color: #070c16;
                                            color: #ffffff;
                                            border-color: rgba(255,255,255,.12);
                                        "
                                        class="w-full min-h-[54px] rounded-xl border px-4
                                               shadow-inner shadow-black/20
                                               placeholder:text-gray-600
                                               hover:border-white/20 transition
                                               focus:border-blue-500 focus:ring-2
                                               focus:ring-blue-500/20">
                                </div>

                                {{-- Visitante --}}
                                <div
                                    class="rounded-2xl bg-red-500/[0.05]
                                           border border-red-400/15 p-5">

                                    <div class="flex items-center gap-3 mb-5">
                                        <div
                                            class="w-11 h-11 rounded-2xl bg-red-600/20
                                                   border border-red-400/15
                                                   flex items-center justify-center">
                                            <span class="w-3 h-3 rounded-full bg-red-400"></span>
                                        </div>

                                        <div>
                                            <p
                                                class="text-[10px] font-black uppercase
                                                      tracking-[0.18em] text-red-400">
                                                Visitante
                                            </p>

                                            <h3 class="mt-1 font-black">
                                                Equipo visitante
                                            </h3>
                                        </div>
                                    </div>

                                    <label for="team_b_name"
                                        class="block mb-2 text-xs font-black uppercase
                                               tracking-[0.18em] text-gray-400">
                                        Nombre del equipo
                                    </label>

                                    <input id="team_b_name" type="text" name="team_b_name"
                                        value="{{ old('team_b_name') }}" required placeholder="Ej: Sport Arica"
                                        style="
                                            background-color: #070c16;
                                            color: #ffffff;
                                            border-color: rgba(255,255,255,.12);
                                        "
                                        class="w-full min-h-[54px] rounded-xl border px-4
                                               shadow-inner shadow-black/20
                                               placeholder:text-gray-600
                                               hover:border-white/20 transition
                                               focus:border-red-500 focus:ring-2
                                               focus:ring-red-500/20">
                                </div>
                            </div>
                        </div>
                    </section>

                    {{-- Nota --}}
                    <div
                        class="flex items-start gap-3 rounded-2xl
                               bg-blue-500/[0.05] border border-blue-400/10
                               px-5 py-4">

                        <svg class="shrink-0 w-5 h-5 mt-0.5 text-blue-300" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>

                        <p class="text-sm text-gray-400 leading-relaxed">
                            Después de crear el partido podrás añadir escudos, fondos,
                            colores de camiseta y personalizar por completo la salida gráfica.
                        </p>
                    </div>
                </div>

                {{-- Acciones --}}
                <div
                    class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end
                           gap-3 px-5 sm:px-7 py-5 border-t border-white/10 bg-black/10">

                    <a href="{{ route('matches.index') }}"
                        class="min-h-[52px] px-5 rounded-xl bg-white/5 hover:bg-white/10
                               border border-white/10
                               inline-flex items-center justify-center
                               font-black text-gray-300 transition">
                        Cancelar
                    </a>

                    <button type="submit"
                        class="min-h-[52px] px-6 rounded-xl bg-blue-600 hover:bg-blue-500
                               inline-flex items-center justify-center gap-2
                               font-black shadow-lg shadow-blue-950/30
                               transition active:scale-95">

                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>

                        Crear partido
                    </button>
                </div>
            </form>

            <p class="mt-5 text-center text-xs text-gray-600">
                Los nombres, escudos, fondos y colores podrán ajustarse posteriormente
                desde Configurar.
            </p>
        </div>
    </div>

    <script>
        const localNameInput = document.getElementById('team_a_name');
        const visitorNameInput = document.getElementById('team_b_name');
        const localPreview = document.getElementById('new-match-local-preview');
        const visitorPreview = document.getElementById('new-match-visitor-preview');

        localNameInput?.addEventListener('input', () => {
            localPreview.textContent =
                localNameInput.value.trim() || 'Equipo local';
        });

        visitorNameInput?.addEventListener('input', () => {
            visitorPreview.textContent =
                visitorNameInput.value.trim() || 'Equipo visitante';
        });
    </script>
</x-app-layout>
