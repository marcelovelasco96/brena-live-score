<x-broadcast-layout>
    <div class="min-h-screen bg-[#070A12] text-white">
        <div class="max-w-6xl mx-auto px-4 py-6">

            <div class="flex items-center justify-between mb-6">
                <div>
                    <p class="text-blue-400 text-xs font-black uppercase tracking-[0.35em]">
                        Breña Live Studio
                    </p>
                    <h1 class="text-3xl md:text-5xl font-black mt-1">
                        Configuración del Partido
                    </h1>
                    <p class="text-gray-400 mt-2">
                        Configura nombres, escudos, camisetas, fondos y colores antes de transmitir.
                    </p>
                </div>

                <a href="{{ route('matches.control', $match) }}"
                    class="px-4 py-3 rounded-2xl bg-blue-600 hover:bg-blue-500 font-black">
                    Ir al Control
                </a>
            </div>

            @if (session('success'))
                <div
                    class="mb-5 rounded-2xl bg-green-600/20 border border-green-500/40 px-5 py-4 text-green-300 font-bold">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('matches.updateSettings', $match) }}" enctype="multipart/form-data"
                class="space-y-5">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    {{-- LOCAL --}}
                    <div class="rounded-[2rem] bg-[#111827] border border-white/10 p-5">
                        <p class="text-blue-400 text-xs font-black uppercase tracking-[0.25em] mb-5">
                            Equipo Local
                        </p>

                        <div id="preview-a-bg"
                            class="mb-5 rounded-2xl min-h-[110px] flex items-center gap-5 px-5 bg-cover bg-center"
                            data-current-bg="{{ $match->team_a_background ? '/storage/' . $match->team_a_background : '' }}">
                            <div
                                class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center overflow-hidden">
                                <div id="preview-a-logo"
                                    data-current-logo="{{ $match->team_a_logo ? '/storage/' . $match->team_a_logo : '' }}">
                                </div>
                            </div>

                            <div id="preview-a-name" class="text-3xl font-black">
                                {{ $match->team_a_name }}
                            </div>
                        </div>

                        <label class="block text-sm font-bold text-gray-300 mb-2">Nombre</label>
                        <input id="team-a-name-input" type="text" name="team_a_name"
                            value="{{ $match->team_a_name }}"
                            class="w-full rounded-xl bg-gray-950 border-white/10 text-white mb-5">

                        <label class="block text-sm font-bold text-gray-300 mb-2">Escudo</label>
                        <input id="team-a-logo-input" type="file" name="team_a_logo" accept="image/*"
                            class="w-full rounded-xl bg-gray-950 border border-white/10 p-3 text-white mb-3">

                        <p class="mt-2 text-xs text-gray-400">
                            Archivo actual: Escudo cargado
                        </p>

                        @if ($match->team_a_logo)
                            <label class="flex items-center gap-2 text-sm text-red-300 font-bold mb-5">
                                <input id="remove-team-a-logo" type="checkbox" name="remove_team_a_logo" value="1">
                                Quitar escudo y mostrar camiseta
                            </label>
                        @endif

                        <label class="block text-sm font-bold text-gray-300 mb-2">Color de camiseta si no hay
                            escudo</label>
                        <input id="team-a-jersey-color-input" type="color" name="team_a_jersey_color"
                            value="{{ $match->team_a_jersey_color ?? '#1e40af' }}"
                            class="w-full h-14 rounded-xl bg-gray-950 border border-white/10 p-2 mb-5">

                        <label class="block text-sm font-bold text-gray-300 mb-2">Fondo personalizado</label>
                        <input id="team-a-bg-input" type="file" name="team_a_background" accept="image/*"
                            class="w-full rounded-xl bg-gray-950 border border-white/10 p-3 text-white mb-3">

                        <p class="mt-2 text-xs text-gray-400">
                            Archivo actual: Fondo cargado
                        </p>

                        @if ($match->team_a_background)
                            <label class="flex items-center gap-2 text-sm text-red-300 font-bold mb-5">
                                <input id="remove-team-a-bg" type="checkbox" name="remove_team_a_background"
                                    value="1">
                                Quitar fondo personalizado y usar color sólido
                            </label>
                        @endif

                        <label class="block text-sm font-bold text-gray-300 mb-2">Color sólido de fondo</label>
                        <input id="team-a-color-input" type="color" name="team_a_color"
                            value="{{ $match->team_a_color ?? '#1d4ed8' }}"
                            class="w-full h-14 rounded-xl bg-gray-950 border border-white/10 p-2">
                    </div>

                    {{-- VISITANTE --}}
                    <div class="rounded-[2rem] bg-[#111827] border border-white/10 p-5">
                        <p class="text-red-400 text-xs font-black uppercase tracking-[0.25em] mb-5">
                            Equipo Visitante
                        </p>

                        <div id="preview-b-bg"
                            class="mb-5 rounded-2xl min-h-[110px] flex items-center justify-end gap-5 px-5 bg-cover bg-center"
                            data-current-bg="{{ $match->team_b_background ? '/storage/' . $match->team_b_background : '' }}">
                            <div id="preview-b-name" class="text-3xl font-black text-right">
                                {{ $match->team_b_name }}
                            </div>

                            <div
                                class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center overflow-hidden">
                                <div id="preview-b-logo"
                                    data-current-logo="{{ $match->team_b_logo ? '/storage/' . $match->team_b_logo : '' }}">
                                </div>
                            </div>
                        </div>

                        <label class="block text-sm font-bold text-gray-300 mb-2">Nombre</label>
                        <input id="team-b-name-input" type="text" name="team_b_name"
                            value="{{ $match->team_b_name }}"
                            class="w-full rounded-xl bg-gray-950 border-white/10 text-white mb-5">

                        <label class="block text-sm font-bold text-gray-300 mb-2">Escudo</label>
                        <input id="team-b-logo-input" type="file" name="team_b_logo" accept="image/*"
                            class="w-full rounded-xl bg-gray-950 border border-white/10 p-3 text-white mb-3">

                        <p class="mt-2 text-xs text-gray-400">
                            Archivo actual: Escudo cargado
                        </p>

                        @if ($match->team_b_logo)
                            <label class="flex items-center gap-2 text-sm text-red-300 font-bold mb-5">
                                <input id="remove-team-b-logo" type="checkbox" name="remove_team_b_logo" value="1">
                                Quitar escudo y mostrar camiseta
                            </label>
                        @endif

                        <label class="block text-sm font-bold text-gray-300 mb-2">Color de camiseta si no hay
                            escudo</label>
                        <input id="team-b-jersey-color-input" type="color" name="team_b_jersey_color"
                            value="{{ $match->team_b_jersey_color ?? '#dc2626' }}"
                            class="w-full h-14 rounded-xl bg-gray-950 border border-white/10 p-2 mb-5">

                        <label class="block text-sm font-bold text-gray-300 mb-2">Fondo personalizado</label>
                        <input id="team-b-bg-input" type="file" name="team_b_background" accept="image/*"
                            class="w-full rounded-xl bg-gray-950 border border-white/10 p-3 text-white mb-3">

                        <p class="mt-2 text-xs text-gray-400">
                            Archivo actual: Fondo cargado
                        </p>

                        @if ($match->team_b_background)
                            <label class="flex items-center gap-2 text-sm text-red-300 font-bold mb-5">
                                <input id="remove-team-b-bg" type="checkbox" name="remove_team_b_background"
                                    value="1">
                                Quitar fondo personalizado y usar color sólido
                            </label>
                        @endif

                        <label class="block text-sm font-bold text-gray-300 mb-2">Color sólido de fondo</label>
                        <input id="team-b-color-input" type="color" name="team_b_color"
                            value="{{ $match->team_b_color ?? '#dc2626' }}"
                            class="w-full h-14 rounded-xl bg-gray-950 border border-white/10 p-2">
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button type="button" id="reset-settings-button"
                        class="px-6 py-4 rounded-2xl bg-white/10 hover:bg-white/20 font-black">
                        ↺ Restablecer cambios
                    </button>

                    <button class="px-6 py-4 rounded-2xl bg-blue-600 hover:bg-blue-500 font-black">
                        Guardar configuración
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function jerseySvg(color) {
            return `
                <svg viewBox="0 0 64 64" class="w-12 h-12 drop-shadow">
                    <path fill="${color}" d="M22 8 L28 14 H36 L42 8 L56 16 L50 30 L44 27 V56 H20 V27 L14 30 L8 16 Z"/>
                </svg>
            `;
        }

        function setupTeamPreview(team) {
            const nameInput = document.getElementById(`team-${team}-name-input`);
            const logoInput = document.getElementById(`team-${team}-logo-input`);
            const bgInput = document.getElementById(`team-${team}-bg-input`);
            const colorInput = document.getElementById(`team-${team}-color-input`);
            const jerseyColorInput = document.getElementById(`team-${team}-jersey-color-input`);

            const removeLogo = document.getElementById(`remove-team-${team}-logo`);
            const removeBg = document.getElementById(`remove-team-${team}-bg`);

            const previewBg = document.getElementById(`preview-${team}-bg`);
            const previewLogo = document.getElementById(`preview-${team}-logo`);
            const previewName = document.getElementById(`preview-${team}-name`);

            let selectedLogoUrl = null;
            let selectedBgUrl = null;

            const initialState = {
                name: nameInput.value,
                color: colorInput.value,
                jerseyColor: jerseyColorInput.value,
                currentLogo: previewLogo.dataset.currentLogo,
                currentBg: previewBg.dataset.currentBg,
            };

            function render() {
                previewName.textContent = nameInput.value || 'Equipo';

                const useCurrentLogo = previewLogo.dataset.currentLogo && !(removeLogo && removeLogo.checked);
                const useNewLogo = selectedLogoUrl && !(removeLogo && removeLogo.checked);

                if (useNewLogo) {
                    previewLogo.innerHTML = `<img src="${selectedLogoUrl}" class="w-full h-full object-contain">`;
                } else if (useCurrentLogo) {
                    previewLogo.innerHTML =
                        `<img src="${previewLogo.dataset.currentLogo}" class="w-full h-full object-contain">`;
                } else {
                    previewLogo.innerHTML = jerseySvg(jerseyColorInput.value);
                }

                const useCurrentBg = previewBg.dataset.currentBg && !(removeBg && removeBg.checked);
                const useNewBg = selectedBgUrl && !(removeBg && removeBg.checked);

                if (useNewBg) {
                    previewBg.style.backgroundImage =
                        `linear-gradient(rgba(0,0,0,.25), rgba(0,0,0,.25)), url('${selectedBgUrl}')`;
                    previewBg.style.backgroundColor = '';
                } else if (useCurrentBg) {
                    previewBg.style.backgroundImage =
                        `linear-gradient(rgba(0,0,0,.25), rgba(0,0,0,.25)), url('${previewBg.dataset.currentBg}')`;
                    previewBg.style.backgroundColor = '';
                } else {
                    previewBg.style.backgroundImage = 'none';
                    previewBg.style.backgroundColor = colorInput.value;
                }
            }

            nameInput.addEventListener('input', render);
            colorInput.addEventListener('input', render);
            jerseyColorInput.addEventListener('input', render);

            logoInput.addEventListener('change', () => {
                selectedLogoUrl = logoInput.files[0] ? URL.createObjectURL(logoInput.files[0]) : null;
                if (removeLogo) removeLogo.checked = false;
                render();
            });

            bgInput.addEventListener('change', () => {
                selectedBgUrl = bgInput.files[0] ? URL.createObjectURL(bgInput.files[0]) : null;
                if (removeBg) removeBg.checked = false;
                render();
            });

            if (removeLogo) removeLogo.addEventListener('change', render);
            if (removeBg) removeBg.addEventListener('change', render);

            render();

            return function resetTeam() {
                nameInput.value = initialState.name;
                colorInput.value = initialState.color;
                jerseyColorInput.value = initialState.jerseyColor;

                logoInput.value = '';
                bgInput.value = '';

                selectedLogoUrl = null;
                selectedBgUrl = null;

                if (removeLogo) removeLogo.checked = false;
                if (removeBg) removeBg.checked = false;

                previewLogo.dataset.currentLogo = initialState.currentLogo;
                previewBg.dataset.currentBg = initialState.currentBg;

                render();
            };
        }

        const resetTeamA = setupTeamPreview('a');
        const resetTeamB = setupTeamPreview('b');

        document.getElementById('reset-settings-button').addEventListener('click', () => {
            resetTeamA();
            resetTeamB();
        });
    </script>
</x-broadcast-layout>
