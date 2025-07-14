<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('assets/css/apartments-index.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dropdown.css') }}">
    <title>Apartments</title>

    <script>
        // Function to confirm deletion
        function confirmDeletion(event) {
            const userConfirmed = confirm("Are you sure you want to delete?");
            if (!userConfirmed) {
                event.preventDefault(); // Prevent form submission
            }
        }
    </script>


<script>
    document.getElementById('add-info-btn').addEventListener('click', function () {
        const infoFields = document.getElementById('info-fields');
        const newField = document.createElement('input');
        newField.type = 'text';
        newField.name = 'infos[]';
        newField.classList.add('form-input');
        newField.placeholder = `Info ${infoFields.children.length + 1}`;
        infoFields.appendChild(newField);
    });
</script>

</head>
<body>

     <!-- Navbar -->
     <div class="container">
        <div class="navbar">
            <div class="titlebox">
                <h1 class="title">UREDI APARTMANE</h1>
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


    <div class="container2">
        <form action="{{ route('apartments.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="addapartment">
                <h3 class="title" style="color:black">Dodaj Novi Apartman</h3>
                <input type="text" name="name" class="form-input" placeholder="New Apartment Name" required>
                <input type="number" name="price" class="form-input" placeholder="Price" step="0.01" required>
                <input type="number" name="capacity" class="form-input" placeholder="Capacity" required>
            </div>

            <div class="addimage">
                <h3 class="title" style="color:black">Dodaj Sliku</h3>
                <input type="file" name="images[]" class="form-input" multiple>
                <button type="submit" class="form-button">Dodaj</button>
            </div>

        </form>
    </div>

    <!-- Display Apartments -->
    <div class="container3">
        <h3 class="title" style="color:black">Prikaz Svih Jedinica</h3>
        @foreach ($apartments as $apartment)
            <div class="apartment-display">
                <p class="text">{{ $apartment->name }} - Cijena: {{ $apartment->price }}/€ - Capacity: {{ $apartment->capacity }}</p>

                <!-- Images Section -->
                <div class="images">
                    @if ($apartment->apartmentImages->isEmpty())
                        <!-- Placeholder Image -->
                        <img src="{{ asset('assets/images/no-image.png') }}" alt="No Image Available" width="600" height="300">
                    @else
                        @php
                            $firstImage = $apartment->apartmentImages->first();
                        @endphp
                        <img src="{{ asset('storage/' . $firstImage->image) }}" alt="Apartment Image" width="600" height="300">
                    @endif
                </div>

                <!-- Buttons Section -->
                <div class="buttons">
                    <!-- Edit Button -->
                    <a href="{{ route('apartments.edit', $apartment->id) }}" class="editbutton">Uredi</a>

                    <!-- Delete Form -->
                    <form action="{{ route('apartments.destroy', $apartment->id) }}" method="POST" style="display:inline;" onsubmit="confirmDeletion(event)">
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
