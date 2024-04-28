<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-green-500 flex justify-center items-center min-h-screen">



    <form class="bg-white p-8 rounded-lg shadow-md" action="{{ route('send.reset.link') }}" method="POST">
        @csrf
        <div class="mb-4 flex justify-center">
        <img src="{{ asset('padlock.png') }}" alt="Logo" width="80">
        </div>
        <h1 class="text-2xl font-bold mb-4 text-center">Forgot Password?</h1>
        <div class="mb-4">
            <label for="email" class="block font-bold mb-2">Email Address:</label>
            <input type="email" name="email" id="email" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" required>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md w-full hover:bg-blue-600">Send Reset Link</button>
    </form>
    <!-- Font Awesome CDN for the icon -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
