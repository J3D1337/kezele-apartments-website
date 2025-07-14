<!DOCTYPE html>
<html>
<head>
    <title>Edit Beach Image</title>
</head>
<body>
    <h1>Edit Beach Image</h1>
    <form action="{{ route('hbeaches.update', $hbeach->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="file" name="image" required>
        <button type="submit">Update</button>
    </form>
    <a href="{{ route('hbeaches.index') }}">Back to Beaches</a>
</body>
</html>
