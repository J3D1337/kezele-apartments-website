<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('assets/css/beachindex.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dropdown.css') }}">
    <title>Beaches</title>
    <script>
        // Function to confirm deletion
        function confirmDeletion(event) {
            const userConfirmed = confirm("Are you sure you want to delete?");
            if (!userConfirmed) {
                event.preventDefault(); // Prevent form submission
            }
        }
    </script>
</head>
<body>
    <!-- Navbar -->
    <div class="container">
        <div class="navbar">
            <div class="titlebox">
                <h1 class="title">UREDI LOKACIJE</h1>
            </div>

            <!-- Menu icon for mobile view -->
            <span class="menu-icon" onclick="openNav()">&#9776;</span>

            <div class="linksbox">
                <div class="fade-in-bottom links">
                    <ul>
                        <li><a href="{{ route('dashboard') }}">{{ __('messages.nav_home') }}</a></li>
                        <li><a href="{{ route('lokacije') }}" target="_self">{{ __('messages.nav_locations') }}</a></li>
                        <li><a href="{{ route('smjestaji') }}" target="_self">{{ __('messages.nav_apartments') }}</a></li>
                        @auth
                        <li><a href="{{ route('beaches.index') }}" target="_self">Uredi Lokacije</a></li>
                        <li><a href="{{ route('apartments.index') }}" target="_self">Uredi Apartmane</a></li>
                        @endauth
                        <li><a href="#contact">{{ __('messages.nav_contact') }}</a></li>

                        <!-- Language Dropdown -->
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle">{{ __('messages.nav_language') }}</a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ route('lang.switch', 'en') }}">English</a></li>
                                <li><a href="{{ route('lang.switch', 'hr') }}">Hrvatski</a></li>
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
        </div>

        <!-- Fullscreen Overlay Menu -->
        <div id="myNav" class="overlay">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <div class="overlay-content">
                <a href="{{route('dashboard')}}" target="_self">{{ __('messages.nav_home') }}</a>
                <a href="{{route('lokacije')}}">{{ __('messages.nav_locations') }}</a>
                <a href="{{route('smjestaji')}}" target="_self">{{ __('messages.nav_apartments') }}</a>
                @auth
                <a href="{{ route('beaches.index') }}" target="_self">Uredi Lokacije</a>
                <a href="{{ route('apartments.index') }}" target="_self">Uredi Apartmane</a>
                @endauth
                <a href="#contact">{{ __('messages.nav_contact') }}</a>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle">{{ __('messages.nav_language') }}</a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('lang.switch', 'en') }}">English</a></li>
                        <li><a href="{{ route('lang.switch', 'hr') }}">Hrvatski</a></li>
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
    </div>

    <!-- Success and Error Messages -->
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

    <!-- Form for Adding Beaches and Images -->
    <div class="container2">
        <form action="{{ route('beaches.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Add New Beach -->
            <div class="addbeach">
                <h3 class="title" style="color:black">Dodaj novu plažu</h3>
                <input type="text" name="name" class="form-input" placeholder="Ime Plaže">
            </div>
            {{-- <div class="selectexist">
                <h3 class="title" style="color:black">Izaberi postojeću plažu</h3>
                <select name="beach_id">
                    <option value=""></option>
                    @foreach ($beaches as $beach)
                        <option value="{{ $beach->id }}">{{ $beach->name }}</option>
                    @endforeach
                </select>
            </div> --}}
            <!-- Upload Images -->
            <div class="addimage">
                <h3 class="title" style="color:black">Dodaj slike</h3>
                <input type="file" name="images[]" multiple>
                <button type="submit" class="form-button">Priloži</button>
            </div>
        </form>
    </div>

    <!-- Display Beaches and Images -->
    <div class="container3">
        @foreach ($beaches as $beach)
            <div class="imagedisplay">
                <h3 class="title" style="color:black">{{ $beach->name }}</h3>
                @foreach ($beach->beachImages as $image)
                    @if ($loop->first)
                        <img src="{{ asset('storage/' . $image->image) }}" alt="Image" width="400" height="200">
                    @endif
                @endforeach
                <div class="buttons">
                    <button class="editbutton" onclick="window.location='{{ route('beaches.edit', $beach->id) }}'">Uredi</button>
                    <form action="{{ route('beaches.destroy', $beach->id) }}" method="POST" style="display:inline;" onsubmit="confirmDeletion(event)">
                        @csrf
                        @method('DELETE')
                        <button class="deletebutton" type="submit">Izbriši</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <script src="{{ asset('assets/js/script.js') }}"></script>
</body>
</html>
