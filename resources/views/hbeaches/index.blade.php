<!DOCTYPE html>
<html>
<head>
    <title>Beaches</title>
    <style>
@font-face {
    font-family: 'OpenSans-Regular';
    src: url('/assets/fonts/Open_Sans/OpenSans-VariableFont_wdth\,wght.ttf') format('truetype');
    font-weight: normal;
    font-style: normal;
  }

  * {
    box-sizing: border-box;
  }
  html, body {
    height: 100%;
    width: 100%;
    margin: 0;
    background-color: rgb(236, 236, 236);
  }
        /* Modal Styles */
        #imageModal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.9);
        }

        #imageModal img {
            margin: auto;
            position: absolute;
            display: block;
            width: 100%;
            height: 100%;
            left:26%;
            top:20%;
            max-width: 900px;
            max-height: 500px;
        }

        #imageModal .close {
            position: absolute;
            top: 10px;
            right: 25px;
            color: white;
            font-size: 35px;
            font-weight: bold;
            cursor: pointer;
        }

        /* Fade-in animation */
        #imageModal img {
            animation-name: zoom;
            animation-duration: 0.6s;
        }

        @keyframes zoom {
            from {
                transform: scale(0);
            }
            to {
                transform: scale(1);
            }
        }


        /* LAYOUT */

        .titlebox{
            width: 100%;
            height: 10%;
            position:absolute;
            background-color:red;
        }


        /* TEXT */

        .title{
            font-family: 'OpenSans-Regular';
            font-size: 30px;
            color: white;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="titlebox">
    <h1 class="title">HAVIŠĆE</h1>
    </div>
    <a href="{{ route('hbeaches.create') }}">Upload New Image</a>
    <ul>
        @foreach ($hbeaches as $hbeach)
            <li>
                <!-- When clicked, open the modal with the clicked image -->
                <img src="{{ asset('storage/' . $hbeach->image) }}" alt="Hbeach Image" width="100" onclick="openModal('{{ asset('storage/' . $hbeach->image) }}')">
                <a href="{{ route('hbeaches.edit', $hbeach->id) }}">Edit</a>
                <form action="{{ route('hbeaches.destroy', $hbeach->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>

    <!-- Modal for Full-Screen Image -->
    <div id="imageModal">
        <span class="close" onclick="closeModal()">&times;</span>
        <img id="modalImage" src="">
    </div>

    <script>
        // Open the modal with the clicked image
        function openModal(imageSrc) {
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');

            modal.style.display = 'block';
            modalImage.src = imageSrc;
        }

        // Close the modal
        function closeModal() {
            const modal = document.getElementById('imageModal');
            modal.style.display = 'none';
        }
    </script>
</body>
</html>
