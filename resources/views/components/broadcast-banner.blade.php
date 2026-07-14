<div id="broadcast-banner"
    class="broadcast-banner {{ $match->broadcast_mode === 'banner' && $match->banner_enabled ? 'is-visible' : '' }}">

    <div class="banner-shell">
        <div class="banner-yellow-bar"></div>

        <div class="banner-pill" style="display: {{ $match->banner_show_label ? 'block' : 'none' }};">
            <span id="banner-label">{{ $match->banner_label ?: 'COLEGIO INVITADO' }}</span>
        </div>

        <div class="banner-content">
            <div id="banner-title" class="banner-title">
                {{ $match->banner_title ?: 'I.E. MARIANO MELGAR' }}
            </div>
        </div>
    </div>
</div>

<style>
    .broadcast-banner {
        position: fixed;
        left: 70px;
        bottom: 135px;
        z-index: 999999;
        font-family: Montserrat, Arial, sans-serif;
        opacity: 0;
        transform: translateX(-90px) scale(.96);
        transition: opacity .45s ease, transform .45s cubic-bezier(.2, .9, .2, 1);
        pointer-events: none;
    }

    .broadcast-banner.is-visible {
        opacity: 1;
        transform: translateX(0) scale(1);
    }

    .banner-shell {
        position: relative;
        width: 980px;
        min-height: 126px;
        background: linear-gradient(105deg, #005A90 0%, #0768a5 50%, #003f6b 100%);
        border-radius: 0 46px 46px 0;
        box-shadow: 0 30px 60px rgba(0, 0, 0, .40);
        overflow: visible;
        border: 1px solid rgba(255, 255, 255, .18);
    }

    .banner-yellow-bar {
        position: absolute;
        left: 0;
        top: 0;
        width: 20px;
        height: 100%;
        background: linear-gradient(180deg, #facc15, #ffe45c);
    }

    .banner-content {
        position: relative;
        padding: 34px 48px 22px 58px;
    }

    .banner-top {
        display: flex;
        align-items: center;
        gap: 22px;
        margin-bottom: 22px;
    }

    .banner-pill {
        background: #facc15;
        color: #005A90;
        padding: 9px 28px;
        border-radius: 999px;
        font-size: 25px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: .04em;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, .45), 0 8px 16px rgba(0, 0, 0, .18);
        position: absolute;
        left: 0px;
        top: -60px;
        z-index: 5;
    }

    .banner-separator {
        width: 2px;
        height: 32px;
        background: rgba(255, 255, 255, .35);
    }

    .banner-brand {
        position: absolute;
        top: 18px;
        right: 42px;

        color: rgba(255, 255, 255, .75);
        font-size: 13px;
        font-weight: 900;
        letter-spacing: .25em;
        text-transform: uppercase;
    }

    .banner-title {
        margin-top: 18px;

        color: #fff;

        font-size: 58px;
        font-weight: 900;

        line-height: 1.02;

        letter-spacing: .02em;

        max-width: 860px;

        white-space: normal;

        word-break: break-word;

        text-transform: uppercase;

        text-shadow: 0 5px 14px rgba(0, 0, 0, .35);
    }
</style>
