const dataUrl = window.overlayDataUrl;

let previousScoreA = null;
let previousScoreB = null;

function formatTimer(secondsValue) {
    const minutes = String(Math.floor(secondsValue / 60)).padStart(2, '0');
    const seconds = String(secondsValue % 60).padStart(2, '0');
    return `${minutes}:${seconds}`;
}

function setDisplay(id, show) {
    const element = document.getElementById(id);
    if (element) element.style.display = show ? 'block' : 'none';
}

function setText(id, value) {
    const element = document.getElementById(id);
    if (element) element.textContent = value ?? '';
}

function updateLogo(containerId, imageUrl) {
    const container = document.getElementById(containerId);
    if (!container || !imageUrl) return;

    const currentImg = container.querySelector('img');
    if (currentImg && currentImg.getAttribute('src') === imageUrl) return;

    container.innerHTML = `<img src="${imageUrl}" class="w-full h-full object-contain">`;
}

function updateBackground(elementId, imageUrl, color) {
    const element = document.getElementById(elementId);
    if (!element) return;

    if (imageUrl) {
        element.style.backgroundImage =
            `linear-gradient(rgba(0,0,0,.25), rgba(0,0,0,.25)), url('${imageUrl}')`;
        element.style.backgroundColor = '';
    } else {
        element.style.backgroundImage = 'none';
        element.style.backgroundColor = color ?? '#1e3a8a';
    }
}

function animateChange(elementId) {
    const element = document.getElementById(elementId);
    if (!element) return;

    element.classList.remove('score-pop');
    void element.offsetWidth;
    element.classList.add('score-pop');
}

function renderOverlayPenaltyDots(containerId, penalties) {
    const container = document.getElementById(containerId);
    if (!container || !Array.isArray(penalties)) return;

    container.innerHTML = '';

    penalties.forEach(value => {
        const dot = document.createElement('div');
        dot.className = 'w-4 h-4 rounded-full border';

        if (value === 'gol') {
            dot.classList.add('bg-green-500', 'border-green-300');
        } else if (value === 'falla') {
            dot.classList.add('bg-red-500', 'border-red-300');
        } else {
            dot.classList.add('bg-gray-600', 'border-gray-400');
        }

        container.appendChild(dot);
    });
}

function updateStatus(status) {
    const statusText = document.getElementById('status-text');
    if (!statusText) return;

    statusText.className = 'px-5 py-2 text-2xl font-black transition-all duration-300';

    if (status === 'live') {
        statusText.classList.add('bg-red-600', 'text-white');
        statusText.textContent = 'EN VIVO';
        return;
    }

    if (status === 'halftime') {
        statusText.classList.add('bg-yellow-400', 'text-black');
        statusText.textContent = 'DESCANSO';
        return;
    }

    if (status === 'finished') {
        statusText.classList.add('bg-gray-700', 'text-white');
        statusText.textContent = 'FINALIZADO';
        return;
    }

    statusText.classList.add('bg-slate-600', 'text-white');
    statusText.textContent = 'PREVIA';
}

function updateSportsOverlay(data) {
    setText('team-a-name', data.team_a_name);
    setText('team-b-name', data.team_b_name);

    const scoreA = document.getElementById('team-a-score');
    const scoreB = document.getElementById('team-b-score');

    if (scoreA) {
        if (previousScoreA !== null && previousScoreA !== data.team_a_score) {
            animateChange('team-a-score');
        }
        scoreA.textContent = data.team_a_score;
    }

    if (scoreB) {
        if (previousScoreB !== null && previousScoreB !== data.team_b_score) {
            animateChange('team-b-score');
        }
        scoreB.textContent = data.team_b_score;
    }

    previousScoreA = data.team_a_score;
    previousScoreB = data.team_b_score;

    setText('period-text', data.period);
    setText('timer-text', formatTimer(data.timer_seconds));

    updateStatus(data.status);

    const penaltiesRow = document.getElementById('penalties-row');
    if (penaltiesRow) {
        penaltiesRow.style.display = data.penalties_enabled ? 'flex' : 'none';
    }

    renderOverlayPenaltyDots('overlay-team-a-penalty-dots', data.team_a_penalties);
    renderOverlayPenaltyDots('overlay-team-b-penalty-dots', data.team_b_penalties);

    updateLogo('team-a-logo-container', data.team_a_logo);
    updateLogo('team-b-logo-container', data.team_b_logo);

    const jerseyA = document.getElementById('team-a-jersey-fill');
    const jerseyB = document.getElementById('team-b-jersey-fill');

    if (jerseyA && data.team_a_jersey_color) {
        jerseyA.setAttribute('fill', data.team_a_jersey_color);
    }

    if (jerseyB && data.team_b_jersey_color) {
        jerseyB.setAttribute('fill', data.team_b_jersey_color);
    }

    updateBackground('team-a-bg', data.team_a_background, data.team_a_color);
    updateBackground('team-b-bg', data.team_b_background, data.team_b_color);
}

function updateBannerOverlay(data) {
    setText('banner-label', data.banner_label || 'COLEGIO INVITADO');
    setText('banner-title', data.banner_title || 'I.E. MARIANO MELGAR');
}

async function refreshOverlay() {
    try {
        const response = await fetch(dataUrl, {
            headers: { 'Accept': 'application/json' }
        });

        const data = await response.json();

        const isSports = data.broadcast_mode === 'sports';
        const showBanner = data.broadcast_mode === 'banner' && data.banner_enabled;

        setDisplay('sports-overlay', isSports);
        setDisplay('broadcast-banner', showBanner);

        if (isSports) {
            updateSportsOverlay(data);
        }

        if (data.broadcast_mode === 'banner') {
            updateBannerOverlay(data);
        }

    } catch (error) {
        console.error('Error actualizando overlay:', error);
    }
}

if (dataUrl) {
    refreshOverlay();
    setInterval(refreshOverlay, 1000);
}