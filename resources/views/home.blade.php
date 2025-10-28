<x-app-layout>
    <br>
    <div class="text-center">
        <h1 class="text-gray-400">Welcome to Martijns game manager!</h1>

        <p class="text-gray-400">
            This website was designed for the soul purpose to create, manage, and compare games and their prices and discounts respectively.
        </p>

        @if (auth()->check())
            <div class="text-center">
                <p class="text-gray-400"> You are logged in</p>
            </div>
        @endif
    </div>

    <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">
            @if (!auth()->check())
            <div class="text-center">
                <button
                    type="button"
                    class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                    onclick="window.location='{{ route('login') }}'">
                    Log in
                </button>

                @if (Route::has('register'))
                    <button
                        type="button"
                        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                        onclick="window.location='{{ route('register') }}'">
                        Register
                    </button>
            </div>
                @endif
            @endif
    </header>


</x-app-layout>


