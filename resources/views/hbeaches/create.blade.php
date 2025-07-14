<!DOCTYPE html>
<html>
<head>
    <title>Upload Beach Image</title>
</head>
<body>
    <h1>Upload Beach Image</h1>
    <form action="{{ route('hbeaches.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="beach_id">Select Beach:</label>
        <select name="beach_id" id="beach_id" required>
            @foreach ($beaches as $beach)
                <option value="{{ $beach->id }}">{{ $beach->name }}</option>
            @endforeach
        </select>

        <label for="images">Upload Images:</label>
        <input type="file" name="images[]" multiple required>
        <button type="submit">Upload Images</button>
    </form>
    <a href="{{ route('hbeaches.index') }}">Back to Beach</a>
</body>
</html>
