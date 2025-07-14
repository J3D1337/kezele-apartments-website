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
    <link rel="stylesheet" href="{{asset('assets/css/apartments-edit.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/dropdown.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animations.css') }}">
    <title>Edit Page</title>

</head>
<body>

    {{--                NAVBAR                  --}}

    <div class="nav-container">
        <div class="nav-title">
            <h1 class="fade-in-bottom title">UREDI APARTMANE</h1>
            <span class="menu-icon" onclick="openNav()">&#9776;</span>
            <div class="nav-links">
                <div class="fade-in-bottom links">
                    <ul>
                        <li><a href="{{ route('dashboard') }}">{{ __('messages.nav_home') }}</a></li>
                        <li><a href="{{ route('lokacije') }}" target="_self">{{ __('messages.nav_locations') }}</a></li>
                        <li><a href="{{ route('smjestaji') }}" target="_self">{{ __('messages.nav_apartments') }}</a></li>
                        @auth
                        <li><a href="{{ route('beaches.index') }}" target="_self">Uredi Lokacije</a></li>
                        <li><a href="{{ route('apartments.index') }}" target="_self">Uredi Apartmane</a></li>
                        @endauth
                        <li><a href="{{ route('contact') }}">{{ __('messages.nav_contact') }}</a></li>

                        <!-- Language Dropdown -->
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle">{{ __('messages.nav_language') }}</a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ route('lang.switch', 'en') }}">
                                        <img class="flag-icon" src="{{ asset('assets/flags/en.png') }}" alt="English">
                                        English
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('lang.switch', 'hr') }}">
                                        <img class="flag-icon" src="{{ asset('assets/flags/cro.png') }}" alt="Hrvatski">
                                        Hrvatski
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('lang.switch', 'de') }}">
                                        <img class="flag-icon" src="{{ asset('assets/flags/ger.png') }}" alt="Deutsch">
                                        Deutsch
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('lang.switch', 'it') }}">
                                        <img class="flag-icon" src="{{ asset('assets/flags/it.png') }}" alt="Italiano">
                                        Italiano
                                    </a>
                                </li>
                            </ul>
                        </li>

                        @auth
                        <li>
                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    @endauth
                    </ul>
                </div>
            </div>
        </div>

        <div id="myNav" class="overlay">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <div class="overlay-content">
                <a href="{{route('dashboard')}}" target="_self">{{ __('messages.nav_home') }}</a>
                <a href="{{route('lokacije')}}">{{ __('messages.nav_locations') }}</a>
                <a href="{{route('smjestaji')}}" target="_self">{{ __('messages.nav_apartments') }}</a>
                @auth
                <a href="{{ route('beaches.index') }}" target="_self">Uredi Lokacije</a>
                <a href="{{ route('apartments.index') }}" target="_self">Uredi Apartmani</a>
                @endauth
                <a href="{{ route('contact') }}">{{ __('messages.nav_contact') }}</a>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle">{{ __('messages.nav_language') }}</a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('lang.switch', 'en') }}"><img class="flag-icon" src="{{ asset('assets/flags/en.png') }}" alt="English">English</a></li>
                        <li><a href="{{ route('lang.switch', 'hr') }}"><img class="flag-icon" src="{{ asset('assets/flags/cro.png') }}" alt="Hrvatski">Hrvatski</a></li>
                        <li><a href="{{ route('lang.switch', 'de') }}"><img class="flag-icon" src="{{ asset('assets/flags/ger.png') }}" alt="Deutsch">Deutsch</a></li>
                        <li><a href="{{ route('lang.switch', 'it') }}"><img class="flag-icon" src="{{ asset('assets/flags/it.png') }}" alt="Italiano">Italiano</a></li>
                    </ul>
                </li>
                @auth
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
        @endauth
            </div>
        </div>
    </div> {{--             END  NAVBAR                  --}}

    {{--             SUCCESS MESSAGE                --}}

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif
    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li style="color: red;">{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    {{--                FORM                  --}}

    <div class="form-container">
        <form action="{{ route('apartments.update', $apartment->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
                <p class="text" style="color:black">Ime:</p><input type="text" class="form-input" name="name" value="{{ $apartment->name }}" placeholder="Ime apartmana">
                <p class="text" style="color:black">Kapacitet:</p><input type="number" class="form-input" name="capacity" value="{{ $apartment->capacity }}" placeholder="Kapacitet">
                <p class="text" style="color:black">Cijena:</p><input type="number" class="form-input" name="price" value="{{ $apartment->price }}" placeholder="Cijena">
                <p class="text" style="color:black">Dodaj Slike:</p><input type="file" name="images[]" class="form-input" multiple>
                <button type="submit" class="form-button">Edit</button>
        </form>
    </div>


    {{--                ADD INFO                  --}}

    <div class="info-container">
        <h3 class="title" style="color:black">Dodaj Novu Informaciju:</h3>
        <form action="{{ route('apartmentInfos.store') }}" method="POST">
            @csrf
            <input type="hidden" name="apartment_id" value="{{ $apartment->id }}">

            <!-- Croatian -->
            <h3 class="text" style="color:black">Hrvatski:</h3>
            <input type="hidden" name="locale_hr" value="hr">
            <input type="text" name="content_hr" class="form-input" style="width:100%" placeholder="Novi Info">
            <br>

            <!-- English -->
            <h3 class="text" style="color:black">Engleski:</h3>
            <input type="hidden" name="locale_en" value="en">
            <input type="text" name="content_en" class="form-input" style="width:100%" placeholder="New Info">
            <br>

            <!-- German -->
            <h3 class="text" style="color:black">Njemački:</h3>
            <input type="hidden" name="locale_de" value="de">
            <input type="text" name="content_de" class="form-input" style="width:100%" placeholder="New Info">
            <br>

            <!-- Italian -->
            <h3 class="text" style="color:black">Talijanski:</h3>
            <input type="hidden" name="locale_it" value="it">
            <input type="text" name="content_it" class="form-input" style="width:100%" placeholder="New Info">
            <br>

            <button type="submit" class="form-button">Dodaj Info</button>
        </form>
    </div>

    {{--                DISPLAY INFO                  --}}

    <div class="display-info">
        <h3 class="title" style="color:black">Dodatne Informacije:</h3>

        <!-- List of Infos -->
        <ul>
            @foreach ($apartment->apartmentInfos as $info)
                <li>
                    <!-- Edit Form -->
                    <form action="{{ route('apartmentInfos.update', $info->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('PUT')
                        <input type="text" name="content_hr" value="{{ $info->content }}" class="form-input" placeholder="Dodatni Sadržaj">
                        <button type="submit" class="editbutton">Edit</button>
                    </form>
                    <!-- Delete Form -->
                    <form action="{{ route('apartmentInfos.destroy', $info->id) }}" method="POST" style="display:inline;" onsubmit="confirmDeletion(event)">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="deletebutton">Delete</button>
                    </form>
                </li>
            @endforeach
        </ul>
    </div>



    <script src="{{asset('assets/js/script.js')}}"></script>
</body>
</html>
