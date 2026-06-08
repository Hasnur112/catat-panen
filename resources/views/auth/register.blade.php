<x-guest-layout>
    <style>
        /* CSS Fix untuk memaksa input tetap putih saat terkena Autofill Browser */
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0px 1000px #ffffff inset !important;
            -webkit-text-fill-color: #1f2937 !important;
            transition: background-color 5000s ease-in-out 0s;
        }
    </style>

    <div class="w-full sm:max-w-md mt-6 px-8 py-8 bg-white/10 backdrop-blur-md border border-white/20 shadow-xl rounded-2xl">
        
        <div class="mb-6">
            <a href="/" class="text-white/70 hover:text-white text-sm flex items-center">
                &larr; Back
            </a>
        </div>

        <h2 class="text-white text-2xl font-bold text-center mb-6">
            Daftar Akun Baru
        </h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-4">
                <x-text-input id="name" class="block w-full bg-white border-none text-gray-900 rounded-lg p-3" 
                              type="text" name="name" placeholder="Nama Lengkap" :value="old('name')" required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-text-input id="email" class="block w-full bg-white border-none text-gray-900 rounded-lg p-3" 
                              type="email" name="email" placeholder="Email" :value="old('email')" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-text-input id="password" class="block w-full bg-white border-none text-gray-900 rounded-lg p-3"
                              type="password" name="password" placeholder="Password" required />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mb-6">
                <x-text-input id="password_confirmation" class="block w-full bg-white border-none text-gray-900 rounded-lg p-3"
                              type="password" name="password_confirmation" placeholder="Konfirmasi Password" required />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <x-primary-button class="w-full justify-center bg-white text-green-800 hover:bg-gray-100 font-bold py-3 rounded-lg mb-4">
                Daftar Sekarang
            </x-primary-button>

            <div class="text-center">
                <a class="text-sm text-white/70 hover:text-white underline" href="{{ route('login') }}">
                    Sudah punya akun? Masuk
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>