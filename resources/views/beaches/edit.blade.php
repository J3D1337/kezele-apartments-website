<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Page</title>
    <link rel="stylesheet" href="{{ asset('assets/css/edit.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dropdown.css') }}">
</head>
<body>

    <!-- Navbar Section -->
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
    <!-- Form Section -->
    <div class="container2">
        <div class="beachnamebox">
            <form action="{{ route('beaches.update', $beach->id) }}" method="POST" class="custom-form">
                @csrf
                @method('PUT')
                <label for="name" class="form-label" style="color:black">Ime plaže:</label>
                <input type="text" id="name" name="name" class="form-input" value="{{ $beach->name }}" required>
                <button type="submit" class="form-button">Edit</button>
            </form>
        </div>

        <div class="imagebox">
            <form action="{{ route('beaches.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
            <label for="image" class="form-label" style="color:black">Dodaj Sliku:</label>
            <input type="hidden" name="beach_id" value="{{ $beach->id }}">
            <input type="file" id="image" name="images[]" class="form-input" multiple>
            <button type="submit" class="form-button">Prenesi</button>
            </form>
        </div>
    </div>

    <!-- Image Display Section -->
    <div class="container3">
        <h1 class="title" style=color:black>Prikaz Slika:</h1>
        @foreach ($beach->beachImages as $image)
            <div class="imagedisplay">
                <img src="{{ asset('storage/' . $image->image) }}" alt="Image" width="400" height="200" class="image-preview" onclick="openFullscreenModal('{{ asset('storage/' . $image->image) }}')">
                <form action="{{ route('beaches.image.delete', $image->id) }}" method="POST" style="display:inline;" onsubmit="confirmDeletion(event)">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Izbriši</button>
                </form>
            </div>
        @endforeach

        <form action="{{ route('beaches.destroy', $beach->id) }}" method="POST" onsubmit="confirmDeletion(event)">
            @csrf
            @method('DELETE')
            <button type="submit" class="deletebutton">IZBRIŠI PLAŽU</button>
        </form>

        <button onclick="window.location.href='{{ route('apartments.index') }}'" class="backbutton">Nazad na pregled plaža</button>

         <!-- Pagination Links -->

    </div>





    <!-- Fullscreen Modal -->
    <div id="fullscreenModal" class="fullscreen-modal">
        <span class="close-modal" onclick="closeFullscreenModal()">&times;</span>
        <img id="modalImage" class="modal-content">
    </div>

    <script src="{{asset('assets/js/script.js')}}"></script>
    <script src="{{asset('assets/js/gallery.js')}}"></script>
</body>
</html>
