<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=1920, initial-scale=1.0">
    <title>Overlay</title>

    @if ($match->broadcast_mode === 'sports')
        @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/overlay.js'])
    @endif

    <style>
        html,
        body {
            margin: 0;
            width: 1920px;
            height: 1080px;
            background: transparent;
            overflow: hidden;
        }
    </style>
</head>

<body>
    @if ($match->broadcast_mode === 'sports')
        <x-scoreboard :match="$match" />
    @endif

    @if ($match->broadcast_mode === 'banner' && $match->banner_enabled)
        <x-broadcast-banner :match="$match" />
    @endif

    <script>
        window.overlayDataUrl = "/overlay/{{ $match->id }}/data";
    </script>

    @if ($match->broadcast_mode === 'banner')
        <script>
            const dataUrl = "/overlay/{{ $match->id }}/data";

            async function refreshBanner() {
                const response = await fetch(dataUrl, {
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                const banner = document.getElementById('broadcast-banner');
                const label = document.getElementById('banner-label');
                const title = document.getElementById('banner-title');
                const pill = document.querySelector('.banner-pill');

                if (!banner) return;

                if (label) label.textContent = data.banner_label || 'COLEGIO INVITADO';
                if (title) title.textContent = data.banner_title || 'I.E. MARIANO MELGAR';

                if (pill) {
                    pill.style.display = data.banner_show_label ? 'block' : 'none';
                }

                banner.classList.toggle(
                    'is-visible',
                    data.broadcast_mode === 'banner' && data.banner_enabled
                );
            }

            refreshBanner();
            setInterval(refreshBanner, 1000);
        </script>
    @endif
</body>

</html>
