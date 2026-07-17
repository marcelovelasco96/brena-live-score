<x-guest-layout>
    <div class="min-h-screen bg-[#070A12] text-white flex items-center justify-center px-4 py-10">

        <div
            class="w-full max-w-6xl grid grid-cols-1 lg:grid-cols-[1.15fr_0.85fr]
                    overflow-hidden rounded-[2rem] border border-white/10
                    bg-[#0f1724] shadow-2xl shadow-black/30">

            {{-- Panel institucional --}}
            <section
                class="relative hidden lg:flex min-h-[680px] flex-col justify-between
                       overflow-hidden px-10 py-10
                       bg-gradient-to-br from-[#111b30] via-[#0f1724] to-[#080d18]">

                <div
                    class="absolute -top-28 -right-20 w-80 h-80
                           rounded-full bg-blue-600/20 blur-3xl">
                </div>

                <div
                    class="absolute -bottom-32 left-10 w-72 h-72
                           rounded-full bg-purple-600/10 blur-3xl">
                </div>

                <div class="relative">
                    <div>
                        <img src="{{ config('branding.logo_dark') }}" alt="{{ config('branding.organization') }}"
                            class="h-[88px] w-auto max-w-[360px] object-contain object-left">
                    </div>
                </div>

                <div class="relative max-w-xl">

                    <p class="mt-6 text-xs font-black uppercase tracking-[0.35em]"
                        style="color: {{ config('branding.accent') }};">
                        Plataforma oficial
                    </p>

                    <h1 class="mt-4 text-4xl xl:text-5xl font-black tracking-tight leading-tight">
                        Centro de Transmisiones
                    </h1>

                    <p class="mt-5 text-lg leading-relaxed text-gray-400">
                        Administra eventos deportivos, configura overlays y controla la producción gráfica en tiempo
                        real desde una sola plataforma.
                    </p>
                </div>

                <div class="relative grid grid-cols-3 gap-3">
                    <div class="rounded-2xl bg-white/5 border border-white/10 p-4">
                        <p class="text-2xl font-black text-blue-300">01</p>
                        <p class="mt-1 text-xs text-gray-500">Crear evento</p>
                    </div>

                    <div class="rounded-2xl bg-white/5 border border-white/10 p-4">
                        <p class="text-2xl font-black text-green-300">02</p>
                        <p class="mt-1 text-xs text-gray-500">Configurar overlay</p>
                    </div>

                    <div class="rounded-2xl bg-white/5 border border-white/10 p-4">
                        <p class="text-2xl font-black text-red-300">03</p>
                        <p class="mt-1 text-xs text-gray-500">Transmitir en vivo</p>
                    </div>
                </div>
            </section>

            {{-- Formulario --}}
            <section class="flex items-center px-5 py-8 sm:px-8 lg:px-10 xl:px-12">
                <div class="w-full max-w-md mx-auto">

                    {{-- Marca móvil --}}
                    <div class="lg:hidden mb-8">
                        <img src="{{ config('branding.logo_dark') }}" alt="{{ config('branding.organization') }}"
                            class="h-[72px] w-auto max-w-[300px] object-contain object-left">
                    </div>

                    <p class="text-xs font-black uppercase tracking-[0.3em]"
                        style="color: {{ config('branding.accent') }};">
                        Acceso al sistema
                    </p>

                    <h2 class="mt-3 text-3xl sm:text-4xl font-black tracking-tight">
                        Iniciar sesión
                    </h2>

                    <p class="mt-3 text-gray-500">
                        Ingresa tus credenciales para acceder al centro de transmisiones.
                    </p>

                    <x-auth-session-status
                        class="mt-6 rounded-2xl bg-green-500/10 border border-green-400/20
                               px-4 py-3 text-green-300"
                        :status="session('status')" />

                    @if ($errors->any())
                        <div
                            class="mt-6 rounded-2xl bg-red-500/10 border border-red-400/20
                                   px-4 py-3 text-sm text-red-200">

                            Credenciales incorrectas. Verifica tu correo y contraseña.
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-5">
                        @csrf

                        <div>
                            <label for="email"
                                class="block mb-2 text-xs font-black uppercase
                                       tracking-[0.18em] text-gray-400">
                                Correo electrónico
                            </label>

                            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                autofocus autocomplete="username" placeholder="correo@munibrena.gob.pe"
                                style="
                                    background-color:#070c16;
                                    color:#ffffff;
                                    border-color:rgba(255,255,255,.12);
                                "
                                class="w-full min-h-[54px] rounded-xl border px-4
                                       shadow-inner shadow-black/20
                                       placeholder:text-gray-600
                                       hover:border-white/20 transition
                                       focus:border-blue-500 focus:ring-2
                                       focus:ring-blue-500/20">

                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <div class="flex items-center justify-between gap-4 mb-2">
                                <label for="password"
                                    class="text-xs font-black uppercase
                                           tracking-[0.18em] text-gray-400">
                                    Contraseña
                                </label>

                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}"
                                        class="text-xs font-bold text-blue-400 hover:text-blue-300 transition">
                                        ¿Olvidaste tu contraseña?
                                    </a>
                                @endif
                            </div>

                            <input id="password" type="password" name="password" required
                                autocomplete="current-password" placeholder="••••••••"
                                style="
                                    background-color:#070c16;
                                    color:#ffffff;
                                    border-color:rgba(255,255,255,.12);
                                "
                                class="w-full min-h-[54px] rounded-xl border px-4
                                       shadow-inner shadow-black/20
                                       placeholder:text-gray-600
                                       hover:border-white/20 transition
                                       focus:border-blue-500 focus:ring-2
                                       focus:ring-blue-500/20">

                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <label for="remember_me" class="flex items-center gap-3 cursor-pointer select-none">

                            <input id="remember_me" type="checkbox" name="remember"
                                class="rounded border-white/20 bg-[#070c16]
                                       text-blue-600 shadow-sm
                                       focus:ring-blue-500 focus:ring-offset-0">

                            <span class="text-sm text-gray-400">
                                Mantener sesión iniciada
                            </span>
                        </label>

                        <button type="submit" style="background-color: {{ config('branding.primary') }};"
                            class="w-full min-h-[54px] rounded-xl hover:brightness-110
                                   inline-flex items-center justify-center gap-3
                                   font-black shadow-xl shadow-blue-950/30
                                   transition active:scale-[0.99]">

                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4M10 17l5-5-5-5M15 12H3" />
                            </svg>

                            Ingresar
                        </button>
                    </form>

                    <div class="mt-8 pt-6 border-t border-white/10">
                        <p class="text-center text-[11px] text-gray-600">
                            Uso exclusivo para personal autorizado de la
                            {{ config('branding.organization') }}.
                        </p>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-guest-layout>
