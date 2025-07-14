<!DOCTYPE html>
<html lang="en">
    {{-- END --}}
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}">
    <title>{{ __('messages.tab_title_home') }}</title>
    <style>
    </style>
</head>
<body class="bg-white">
    <!-- Hero Section with Navigation -->
    <div class="hero-section">
        <div class="hero-overlay"></div>

        <!-- Navigation -->
        <div class="nav-container">
            <div class="flex justify-between items-center max-w-7xl mx-auto">
                <div class="fade-in-bottom">
                    @auth
                    <h1 class="text-white text-2xl md:text-3xl font-light tracking-wider">{{ __('messages.hello') }} {{Auth::user()->name}}</h1>
                    @else
                    <h1 class="text-white text-2xl md:text-3xl font-light tracking-wider">{{ __('messages.welcome') }}</h1>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <span class="mobile-menu-icon text-white text-3xl cursor-pointer lg:hidden" onclick="openMobileMenu()">&#9776;</span>

                <!-- Desktop menu -->
                <nav class="fade-in-bottom desktop-menu">
                    <ul class="flex space-x-6 items-center">
                        <li>
                            <a href="{{ route('dashboard') }}" class="text-white hover:text-gray-200 transition-colors underline-animation">
                                {{ __('messages.nav_home') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('lokacije') }}" target="_self" class="text-white hover:text-gray-200 transition-colors underline-animation">
                                {{ __('messages.nav_locations') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('smjestaji') }}" target="_self" class="text-white hover:text-gray-200 transition-colors underline-animation">
                                {{ __('messages.nav_apartments') }}
                            </a>
                        </li>
                        @auth
                        <li>
                            <a href="{{ route('beaches.index') }}" target="_self" class="text-white hover:text-gray-200 transition-colors underline-animation">
                                Uredi Lokacije
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('apartments.index') }}" target="_self" class="text-white hover:text-gray-200 transition-colors underline-animation">
                                Uredi Apartmane
                            </a>
                        </li>
                        @endauth
                        <li>
                            <a href="{{ route('contact') }}" class="text-white hover:text-gray-200 transition-colors underline-animation">
                                {{ __('messages.nav_contact') }}
                            </a>
                        </li>

                        <!-- Language Dropdown -->
                         @php
                            $locale = app()->getLocale();
                            $flags = [
                                'en' => 'en.png',
                                'hr' => 'cro.png',
                                'de' => 'ger.png',
                                'it' => 'it.png',
                            ];
                            $flagSrc = asset('assets/flags/' . ($flags[$locale] ?? 'hr.png'));
                            $flagAlt = match($locale) {
                                'en' => 'English',
                                'de' => 'Deutsch',
                                'it' => 'Italiano',
                                default => 'Hrvatski',
                            };
                        @endphp
                        <li class="language-dropdown">
                            <div class="language-dropdown-toggle text-white hover:text-gray-200">
                                <span>{{ __('messages.nav_language') }}</span>
                                <img class="flag-icon" src="{{ $flagSrc }}" alt="{{ $flagAlt }}">
                                <i class="fas fa-chevron-down text-xs transition-transform duration-200"></i>
                            </div>
                            <div class="language-dropdown-menu">
                                <a href="{{ route('lang.switch', 'en') }}" class="language-option">
                                    <img class="flag-icon" src="{{ asset('assets/flags/en.png') }}" alt="English">
                                    English
                                </a>
                                <a href="{{ route('lang.switch', 'hr') }}" class="language-option">
                                    <img class="flag-icon" src="{{ asset('assets/flags/cro.png') }}" alt="Hrvatski">
                                    Hrvatski
                                </a>
                                <a href="{{ route('lang.switch', 'de') }}" class="language-option">
                                    <img class="flag-icon" src="{{ asset('assets/flags/ger.png') }}" alt="Deutsch">
                                    Deutsch
                                </a>
                                <a href="{{ route('lang.switch', 'it') }}" class="language-option">
                                    <img class="flag-icon" src="{{ asset('assets/flags/it.png') }}" alt="Italiano">
                                    Italiano
                                </a>
                            </div>
                        </li>

                        @auth
                        <li>
                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-white hover:text-gray-200 transition-colors underline-animation">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                        @endauth
                    </ul>
                </nav>
            </div>
        </div>

        <!-- Hero Content -->
        <div class="hero-content px-4 md:px-8 lg:pl-16">
            <h1 class="text-white text-4xl md:text-5xl lg:text-6xl font-light tracking-wider leading-tight fade-in-bottom max-w-4xl text-left">
                {{ __('messages.home_quote') }}
            </h1>
        </div>
    </div>

    <!-- Mobile Menu Overlay -->
    <div id="mobileMenu" class="mobile-menu-overlay">
        <a href="javascript:void(0)" class="close-mobile-menu" onclick="closeMobileMenu()">&times;</a>
        <div class="mobile-menu-content">
            <a href="{{route('dashboard')}}" class="mobile-menu-link" onclick="closeMobileMenu()">{{ __('messages.nav_home') }}</a>
            <a href="{{route('lokacije')}}" class="mobile-menu-link" onclick="closeMobileMenu()">{{ __('messages.nav_locations') }}</a>
            <a href="{{route('smjestaji')}}" class="mobile-menu-link" onclick="closeMobileMenu()">{{ __('messages.nav_apartments') }}</a>
            @auth
            <a href="{{ route('beaches.index') }}" class="mobile-menu-link" onclick="closeMobileMenu()">Uredi Lokacije</a>
            <a href="{{ route('apartments.index') }}" class="mobile-menu-link" onclick="closeMobileMenu()">Uredi Apartmani</a>
            @endauth
            <a href="{{ route('contact') }}" class="mobile-menu-link" onclick="closeMobileMenu()">{{ __('messages.nav_contact') }}</a>

            <!-- Modern Mobile Language Dropdown -->
            <div class="mobile-language-dropdown">
                <button class="mobile-language-btn" onclick="toggleMobileLanguageDropdown()">
                    <span>{{ __('messages.nav_language') }}</span>
                    <i class="fas fa-chevron-down"></i>
                </button>

                <div class="mobile-language-options" id="mobileLanguageOptions">
                    <a href="{{ route('lang.switch', 'en') }}" class="mobile-language-option" onclick="closeMobileMenu()">
                        <img class="flag-icon" src="{{ asset('assets/flags/en.png') }}" alt="English">
                        <span>English</span>
                    </a>
                    <a href="{{ route('lang.switch', 'hr') }}" class="mobile-language-option" onclick="closeMobileMenu()">
                        <img class="flag-icon" src="{{ asset('assets/flags/cro.png') }}" alt="Hrvatski">
                        <span>Hrvatski</span>
                    </a>
                    <a href="{{ route('lang.switch', 'de') }}" class="mobile-language-option" onclick="closeMobileMenu()">
                        <img class="flag-icon" src="{{ asset('assets/flags/ger.png') }}" alt="Deutsch">
                        <span>Deutsch</span>
                    </a>
                    <a href="{{ route('lang.switch', 'it') }}" class="mobile-language-option" onclick="closeMobileMenu()">
                        <img class="flag-icon" src="{{ asset('assets/flags/it.png') }}" alt="Italiano">
                        <span>Italiano</span>
                    </a>
                </div>
            </div>

            @auth
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();" class="mobile-menu-link mt-8">
                Logout
            </a>
            <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            @endauth
        </div>
    </div>

    <!-- About Us Section -->
    <section class="content-section bg-gray-50 mt-10">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl md:text-4xl font-light text-gray-800 mb-8 text-center fade-in-bottom">
                {{ __('messages.about_us_title') }}
            </h1>
            <div class="prose prose-lg text-gray-700 max-w-none fade-in-bottom">
                {!! __('messages.home_text') !!}
            </div>
        </div>
    </section>

    <!-- Feature Cards Section -->
    <section class="fade-in-bottom content-section bg-white py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <!-- Apartments Card -->
            <a href="{{ route('smjestaji') }}" class="feature-card bg-yellow-400 rounded-xl p-8 text-center flex flex-col items-center justify-center shadow-md hover:shadow-lg fade-in-bottom">
                <div class="bg-white p-4 rounded-full mb-6">
                    <i class="fas fa-home text-4xl text-yellow-500"></i>
                </div>
                <h2 class="text-2xl font-semibold text-white mb-4">{{ __('messages.apartments_link') }}</h2>
                <p class="text-white opacity-90">{{__('messages.links_apartments_quote')}}</p>
            </a>

            <!-- Locations Card -->
            <a href="{{ route('lokacije') }}" class="feature-card bg-blue-500 rounded-xl p-8 text-center flex flex-col items-center justify-center shadow-md hover:shadow-lg fade-in-bottom">
                <div class="bg-white p-4 rounded-full mb-6">
                    <i class="fas fa-umbrella-beach text-4xl text-blue-500"></i>
                </div>
                <h2 class="text-2xl font-semibold text-white mb-4">{{ __('messages.locations_link') }}</h2>
                <p class="text-white opacity-90">{{__('messages.links_beaches_quote')}}</p>
            </a>

            <!-- Contact Card -->
            <a href="{{ route('contact') }}" class="feature-card bg-purple-500 rounded-xl p-8 text-center flex flex-col items-center justify-center shadow-md hover:shadow-lg fade-in-bottom">
                <div class="bg-white p-4 rounded-full mb-6">
                    <i class="fas fa-envelope text-4xl text-purple-500"></i>
                </div>
                <h2 class="text-2xl font-semibold text-white mb-4">{{ __('messages.contact') }}</h2>
                <p class="text-white opacity-90">{{__('messages.links_contact_quote')}}</p>
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="fade-in-bottom bg-gray-900 text-white py-12 px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-2xl md:text-3xl font-light mb-6">{{ __('messages.footer_title') }}</h2>
            <p class="text-gray-300 mb-8">{{ __('messages.footer_text') }}</p>
            {{-- <div class="flex justify-center space-x-6">
                <a href="#" class="text-gray-300 hover:text-white transition"><i class="fab fa-facebook-f text-xl"></i></a>
                <a href="#" class="text-gray-300 hover:text-white transition"><i class="fab fa-instagram text-xl"></i></a>
                <a href="#" class="text-gray-300 hover:text-white transition"><i class="fab fa-twitter text-xl"></i></a>
            </div> --}}
        </div>
    </footer>

    <script src = {{asset ('assets/js/script.js')}}></script>

</body>
</html>
