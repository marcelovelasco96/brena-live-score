<x-broadcast-layout>
    <div class="min-h-screen bg-[#070A12] text-white">
        <div class="max-w-7xl mx-auto px-4 py-5">

            {{-- Header --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <div>
                    <p class="text-blue-400 text-xs font-black uppercase tracking-[0.35em]">
                        Breña Live Studio
                    </p>
                    <h1 class="text-3xl md:text-5xl font-black mt-1">
                        Panel de Producción
                    </h1>
                    <p class="text-gray-400 mt-2">
                        {{ $match->title ?? 'Partido en vivo' }}
                    </p>
                </div>

                <div class="grid grid-cols-2 md:flex gap-3 w-full md:w-auto">
                    <a href="{{ route('matches.index') }}"
                        class="w-full md:w-auto px-4 py-3 rounded-2xl bg-white/10 hover:bg-white/20 font-bold text-center">
                        Partidos
                    </a>

                    <a href="{{ route('matches.settings', $match) }}"
                        class="w-full md:w-auto px-4 py-3 rounded-2xl bg-white/10 hover:bg-white/20 font-bold text-center">
                        Configurar
                    </a>

                    <a href="{{ route('matches.overlay', $match) }}" target="_blank"
                        class="w-full md:w-auto px-4 py-3 rounded-2xl bg-blue-600 hover:bg-blue-500 font-black text-center">
                        Overlay
                    </a>

                    <button type="button"
                        onclick="navigator.clipboard.writeText('{{ route('matches.overlay', $match) }}'); this.textContent='✅';"
                        class="w-full md:w-auto px-4 py-3 rounded-2xl bg-white/10 hover:bg-white/20 font-bold">
                        🔗
                    </button>
                </div>
            </div>

            {{-- Main control panel --}}
            <div id="sports-controls"
                class="grid rounded-[2.5rem] bg-[#0f1724] border border-white/10 p-4 shadow-2xl grid-cols-1 lg:grid-cols-3 gap-4">

                @include('matches.control.local-panel')

                @if ($match->sport === 'football')
                    @include('matches.control.sports-panel')
                @elseif ($match->sport === 'volleyball')
                    @include('matches.control.volleyball-panel')
                @endif

                @include('matches.control.visitor-panel')

            </div>

            {{-- Live preview --}}
            <div class="mt-5 rounded-[2rem] bg-[#111827] border border-white/10 p-5 overflow-hidden">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-blue-400 text-xs font-black uppercase tracking-[0.25em]">
                        🎥 SALIDA EN VIVO
                    </p>

                    <button type="button" id="toggle-preview-button"
                        class="lg:hidden px-3 py-2 rounded-xl bg-white/10 hover:bg-white/20 text-xs font-black">
                        Mostrar
                    </button>
                </div>

                <div id="preview-container" class="hidden lg:block">
                    <div
                        class="relative h-32 sm:h-40 lg:h-52 rounded-3xl bg-black border border-white/10 overflow-hidden">

                        {{-- Mobile --}}
                        <iframe src="/overlay/{{ $match->id }}" class="absolute border-0 block lg:hidden"
                            style="
                width: 1920px;
                height: 270px;
                transform-origin: top left;
                transform: scale(0.46) translate(-20px, -8px);
            "
                            scrolling="no">
                        </iframe>

                        {{-- Desktop --}}
                        <iframe src="/overlay/{{ $match->id }}" class="absolute border-0 hidden lg:block"
                            style="
                width: 1920px;
                height: 270px;
                transform-origin: top left;
                transform: scale(0.90) translate(-18px, -8px);
            "
                            scrolling="no">
                        </iframe>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('form[action*="/matches/"]').forEach(form => {

            if (form.dataset.fullRefresh === 'true') {
                return;
            }

            form.addEventListener('submit', async function(e) {
                e.preventDefault();

                const formData = new FormData(this);

                const actionUrl = new URL(this.getAttribute('action'), window.location.origin);

                const response = await fetch(actionUrl.pathname + actionUrl.search, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': formData.get('_token'),
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (!response.ok) {
                    console.error(await response.text());
                    alert('Error al actualizar. Revisa la consola.');
                    return;
                }

                const data = await response.json();

                const teamAScore = document.getElementById('team-a-score');
                const teamBScore = document.getElementById('team-b-score');
                const timerText = document.getElementById('timer-text');
                const periodText = document.getElementById('period-text');
                const teamASets = document.getElementById('team-a-sets');
                const teamBSets = document.getElementById('team-b-sets');
                const volleyballSetNumber = document.getElementById('volleyball-set-number');

                if (teamAScore) teamAScore.textContent = data.team_a_score;
                if (teamBScore) teamBScore.textContent = data.team_b_score;
                if (timerText) timerText.textContent = data.timer_text;
                if (periodText) periodText.textContent = data.period;

                if (teamASets && data.team_a_sets !== undefined) {
                    teamASets.textContent = data.team_a_sets;
                }

                if (teamBSets && data.team_b_sets !== undefined) {
                    teamBSets.textContent = data.team_b_sets;
                }

                if (volleyballSetNumber && data.set_number !== undefined) {
                    volleyballSetNumber.textContent = data.set_number;
                }

                const startButton = document.getElementById('volleyball-start-button');
                const finishButton = document.getElementById('volleyball-finish-button');

                if (startButton && finishButton && data.status) {
                    startButton.disabled = data.status !== 'pre_match';
                    finishButton.disabled = data.status !== 'live';

                    startButton.classList.toggle('opacity-40', startButton.disabled);
                    startButton.classList.toggle('cursor-not-allowed', startButton.disabled);

                    finishButton.classList.toggle('opacity-40', finishButton.disabled);
                    finishButton.classList.toggle('cursor-not-allowed', finishButton.disabled);
                }

                if (data.team_a_penalties !== undefined) {
                    renderPenaltyDots('a', data.team_a_penalties);
                }

                if (data.team_b_penalties !== undefined) {
                    renderPenaltyDots('b', data.team_b_penalties);
                }

                if (data.penalties_enabled !== undefined) {
                    const penaltiesToggle = document.getElementById('penalties-toggle');

                    penaltiesToggle.textContent = data.penalties_enabled ? 'Penales ACTIVOS' :
                        'Penales OFF';

                    penaltiesToggle.classList.remove('bg-yellow-400', 'text-black', 'bg-white/10',
                        'hover:bg-white/20');

                    if (data.penalties_enabled) {
                        penaltiesToggle.classList.add('bg-yellow-400', 'text-black');
                    } else {
                        penaltiesToggle.classList.add('bg-white/10', 'hover:bg-white/20');
                    }
                }

                window.currentMatchStatus = data.status;
                window.currentMatchPeriod = data.period;

                updateTimerButtons();
            });
        });

        const controlDataUrl = "/overlay/{{ $match->id }}/data";

        async function refreshControlTimer() {
            try {
                const response = await fetch(controlDataUrl, {
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                const minutes = String(Math.floor(data.timer_seconds / 60)).padStart(2, '0');
                const seconds = String(data.timer_seconds % 60).padStart(2, '0');

                document.getElementById('timer-text').textContent = `${minutes}:${seconds}`;
                document.getElementById('timer-text').classList.remove('invisible');
                document.getElementById('team-a-score').textContent = data.team_a_score;
                document.getElementById('team-b-score').textContent = data.team_b_score;
                document.getElementById('period-text').textContent = data.period;

                if (data.team_a_penalties !== undefined) {
                    renderPenaltyDots('a', data.team_a_penalties);
                }

                if (data.team_b_penalties !== undefined) {
                    renderPenaltyDots('b', data.team_b_penalties);
                }

                if (data.penalties_enabled !== undefined) {
                    const penaltiesToggle = document.getElementById('penalties-toggle');

                    penaltiesToggle.textContent = data.penalties_enabled ? 'Penales ACTIVOS' : 'Penales OFF';

                    penaltiesToggle.classList.remove('bg-yellow-400', 'text-black', 'bg-white/10', 'hover:bg-white/20');

                    if (data.penalties_enabled) {
                        penaltiesToggle.classList.add('bg-yellow-400', 'text-black');
                    } else {
                        penaltiesToggle.classList.add('bg-white/10', 'hover:bg-white/20');
                    }
                }

                window.currentMatchStatus = data.status;
                window.currentMatchPeriod = data.period;

                updateTimerButtons();
            } catch (error) {
                console.error('Error actualizando cronómetro del panel:', error);
            }
        }

        refreshControlTimer();
        setInterval(refreshControlTimer, 1000);

        window.currentMatchStatus = "{{ $match->status }}";
        window.currentMatchPeriod = "{{ $match->period }}";

        function renderPenaltyDots(team, penalties) {
            const container = document.getElementById(`team-${team}-penalty-dots`);

            if (!container || !Array.isArray(penalties)) return;

            container.innerHTML = '';

            penalties.forEach(value => {
                const dot = document.createElement('div');

                dot.className = 'w-8 h-8 rounded-full border-2';

                if (value === 'gol') {
                    dot.classList.add('bg-green-500', 'border-green-300');
                } else if (value === 'falla') {
                    dot.classList.add('bg-red-500', 'border-red-300');
                } else {
                    dot.classList.add('bg-black/40', 'border-white/40');
                }

                container.appendChild(dot);
            });
        }

        function updateTimerButtons() {
            const status = window.currentMatchStatus;
            const period = window.currentMatchPeriod;

            document.querySelectorAll('[data-timer-action]').forEach(button => {
                const action = button.dataset.timerAction;

                let enabled = true;

                if (status === 'pre_match') {
                    enabled = ['start', 'reset'].includes(action);
                }

                if (status === 'live') {
                    if (period === '1T') {
                        enabled = [
                            'start',
                            'pause',
                            'set_45',
                            'add_minute',
                            'subtract_minute',
                            'finish'
                        ].includes(action);
                    } else {
                        enabled = [
                            'start',
                            'pause',
                            'add_minute',
                            'subtract_minute',
                            'finish'
                        ].includes(action);
                    }
                }

                if (status === 'halftime') {
                    enabled = ['start_second_half', 'reset'].includes(action);
                }

                if (status === 'finished') {
                    enabled = ['reset'].includes(action);
                }

                button.disabled = !enabled;

                button.classList.toggle('opacity-40', !enabled);
                button.classList.toggle('cursor-not-allowed', !enabled);
            });
        }

        const togglePreviewButton = document.getElementById('toggle-preview-button');
        const previewContainer = document.getElementById('preview-container');

        if (togglePreviewButton && previewContainer) {
            togglePreviewButton.addEventListener('click', () => {
                previewContainer.classList.toggle('hidden');

                togglePreviewButton.textContent = previewContainer.classList.contains('hidden') ?
                    'Mostrar' :
                    'Ocultar';
            });
        }

        updateTimerButtons();
    </script>
</x-broadcast-layout>
