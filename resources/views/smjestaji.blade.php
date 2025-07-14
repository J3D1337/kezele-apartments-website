<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    // Set the locale at the top of your view
    if (session()->has('locale')) {
        App::setLocale(session('locale'));
    }
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/smjestaji.css') }}">
    <title>{{ __('messages.tab_title_apartments') }}</title>

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
                    <h1 class="text-white text-2xl md:text-3xl font-light tracking-wider">{{ __('messages.apartments') }}</h1>
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
                {{ __('messages.apartments_quote') }}
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

    <!-- Main Content -->
    <div class="bg-white py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Text Section -->
            <div class="text-center mb-16 fade-in">
                <h1 class="fade-in-bottom text-3xl md:text-4xl font-light text-gray-800 mb-6">
                    {{ __('messages.apartments_title') }}
                </h1>
                <div class="fade-in-bottom prose prose-lg text-gray-600 max-w-none">
                    {!! __('messages.apartments_about') !!}
                </div>
            </div>

            <!-- Apartment Selector -->
            <div class="fade-in-bottom max-w-md mx-auto mb-16 fade-in">
                <form>
                    <div class="custom-select">
                        <select name="apartment" id="apartment" class="w-full" onchange="location = this.value;">
                            <option value="#" disabled selected>{{ __('messages.apartment_select') }}</option>
                            @foreach ($allApartments as $apartmentOption)
                                <option value="{{ route('smjestaji', ['apartment' => $apartmentOption->id]) }}" {{ $apartment->id == $apartmentOption->id ? 'selected' : '' }}>
                                    {{ $apartmentOption->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>

            <!-- Gallery Section -->
            <div class="fade-in-bottom gallery-wrapper mb-16 fade-in rounded-xl overflow-hidden shadow-lg">
                @foreach ($apartment->apartmentImages as $index => $image)
                <div class="gallery-slide absolute inset-0 w-full h-full {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}">
                    <img src="{{ asset('storage/' . $image->image) }}"
                         alt="Apartment image {{ $index + 1 }}"
                         class="w-full h-full object-cover cursor-zoom-in"
                         onclick="openModal({{ $index }})">
                </div>
                @endforeach

                <!-- Navigation arrows INSIDE the gallery container -->
                <div class="nav-arrow prev-arrow" onclick="prevSlide()">
                    <i class="fas fa-chevron-left"></i>
                </div>
                <div class="nav-arrow next-arrow" onclick="nextSlide()">
                    <i class="fas fa-chevron-right"></i>
                </div>

                <!-- Slide indicator -->
                <div class="absolute bottom-4 left-0 right-0 flex justify-center space-x-2">
                    @foreach ($apartment->apartmentImages as $index => $image)
                    <span class="h-2 w-2 rounded-full bg-white opacity-50 cursor-pointer {{ $index === 0 ? '!opacity-100' : '' }}"
                          onclick="goToSlide({{ $index }})"></span>
                    @endforeach
                </div>
            </div>

            <!-- Thumbnail Gallery -->
            <div class="fade-in-bottom grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 mb-16">
                @foreach ($apartment->apartmentImages as $index => $image)
                <div class="thumbnail rounded-lg overflow-hidden cursor-pointer {{ $index === 0 ? 'active' : '' }}"
                     onclick="goToSlide({{ $index }})"
                     data-index="{{ $index }}">
                    <img src="{{ asset('storage/' . $image->image) }}"
                        alt="Apartment thumbnail {{ $index + 1 }}"
                        class="w-full h-32 object-cover cursor-zoom-in"
                        onclick="event.stopPropagation(); openModal({{ $index }})">
                </div>
                @endforeach
            </div>

            <!-- Info Section -->
            <div class="fade-in-bottom info-container fade-in-bottom">
                <h3 class="text-2xl font-light text-gray-800 mb-6">{{ $apartment->name }}</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <p class="text-gray-600">{{ __('messages.capactiy') }}</p>
                            <p class="text-lg font-medium">{{ $apartment->capacity }} {{ __('messages.persons') }}</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-euro-sign"></i>
                        </div>
                        <div>
                            <p class="text-gray-600">{{ __('messages.price') }}</p>
                            <p class="text-lg font-medium">{{ $apartment->price }}€/{{ __('messages.day') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Other Info Section -->
            <div class="fade-in-bottom other-info fade-in-bottom">
                <h3 class="text-2xl font-light text-gray-800 mb-6">{{ __('messages.other_info') }}</h3>
                <ul>
                    @php
                    $locale = App::getLocale();
                    @endphp
                    @forelse ($apartment->apartmentInfos->where('locale', $locale) as $info)
                        <li>{{ $info->content }}</li>
                    @empty
                        <li>{{ __('messages.no_additional_info') }}</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="fade-in-bottom bg-gray-900 text-white py-12 px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-2xl md:text-3xl font-light mb-6">{{ __('messages.footer_title') }}</h2>
            <p class="text-gray-300 mb-8">{{ __('messages.footer_text') }}</p>

            {{-- <div class="flex justify-center space-x-6">
                <a href="#" class="text-gray-300 hover:text-white transition">
                    <i class="fab fa-facebook-f text-xl"></i>
                </a>
                <a href="#" class="text-gray-300 hover:text-white transition">
                    <i class="fab fa-instagram text-xl"></i>
                </a>
                <a href="#" class="text-gray-300 hover:text-white transition">
                    <i class="fab fa-twitter text-xl"></i>
                </a>
            </div> --}}
        </div>
    </footer>

    <!-- Modal for fullscreen images -->
    <div id="imageModal" class="modal">
        <span class="close-modal" onclick="closeModal()">&times;</span>
        <div class="nav-arrow prev-arrow" onclick="modalPrevSlide()">
            <i class="fas fa-chevron-left"></i>
        </div>
        <div class="nav-arrow next-arrow" onclick="modalNextSlide()">
            <i class="fas fa-chevron-right"></i>
        </div>
        <div class="slide-counter" id="slideCounter"></div>
        <div class="loader" id="modalLoader" style="display: none;"></div>
        <img class="modal-content" id="fullImage" onload="hideLoader()">
    </div>

    <script src="{{ asset('assets/js/app-gallery.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>

</body>
</html>
