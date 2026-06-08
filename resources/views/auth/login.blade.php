<x-guest-layout>
    <div class="w-full sm:max-w-md mt-6 px-8 py-8 bg-white/10 backdrop-blur-md border border-white/20 shadow-xl rounded-2xl">
        
        <div class="mb-6">
            <a href="/" class="text-white/70 hover:text-white text-sm flex items-center">
                &larr; Back
            </a>
        </div>

        <h2 class="text-white text-2xl font-bold text-center mb-6">
            Catat Hasil Panen <br> <span class="text-green-300">Lebih Cerdas</span>
        </h2>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <x-text-input id="email" class="block w-full bg-white border-none text-gray-900 placeholder-gray-500 rounded-lg p-3" 
                              type="email" name="email" placeholder="Email" :value="old('email')" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-text-input id="password" class="block w-full bg-white border-none text-gray-900 placeholder-gray-500 rounded-lg p-3"
                              type="password" name="password" placeholder="Password" required />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="block mb-6">
                <label class="inline-flex items-center text-white/80 text-sm">
                    <input type="checkbox" name="remember" class="rounded bg-white border-none text-green-600 focus:ring-0">
                    <span class="ms-2">Remember me</span>
                </label>
            </div>

            <x-primary-button class="w-full justify-center bg-white text-green-800 hover:bg-gray-100 font-bold py-3 rounded-lg mb-4">
                🔑 Masuk ke Akun Anda
            </x-primary-button>

            <a href="{{ route('register') }}" class="block w-full text-center text-white border border-white/30 hover:bg-white/10 py-3 rounded-lg mb-4">
                Belum punya akun? Daftar Gratis
            </a>

            @if (Route::has('password.request'))
                <div class="text-center">
                    <a class="text-sm text-white/70 hover:text-white underline" href="{{ route('password.request') }}">
                        Lupa kata sandi?
                    </a>
                </div>
            @endif
        </form>
    </div>
</x-guest-layout>