<!DOCTYPE html>
<html>
<head>
    <title>Add Beach</title>
</head>
<body>
    <h1>Add Beach</h1>
    <form action="{{ route('beaches.store') }}" method="POST">
        @csrf
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <button type="submit">Add</button>
    </form>
    <a href="/beaches">Back to list</a>
</body>
</html>
