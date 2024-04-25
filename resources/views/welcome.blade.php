<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <style>
        /* Custom styles */
        body {
            font-family: 'Figtree', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-image: url('{{ asset("admin.jpg") }}');
            background-size: cover;
            background-position: center;
        }

        .logo-container {
            text-align: center; /* Center the logo */
            margin-top: 30vh; /* Adjust as needed */
        }

        .logo-container img {
            width: 200px; /* Make logo bigger */
        }

        .content {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-register-container {
            text-align: center;
            margin-bottom: 2rem; /* Adjust as needed */
        }

        .login-register-container a {
            display: inline-block;
            padding: 12px 24px;
            margin: 10px;
            background: linear-gradient(to right, #badfe5, #fbd918); /* Gradient background */
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }

        .login-register-container a:hover {
            background: linear-gradient(to right, #fbd918, #badfe5); /* Gradient hover effect */
        }

        .footer {
            text-align: center;
            padding: 1rem;
            background: linear-gradient(to right, #badfe5, #fbd918); /* Gradient background */
            color: white;
        }
    </style>
</head>
<body class="antialiased">
    <div class="logo-container">
        <img src="{{ asset('Logo.png') }}" alt="Logo" class="w-16 h-auto">
    </div>

    <div class="content">
        <div class="login-register-container">
            @if (Route::has('login'))
                <div>
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </div>

    <div class="footer">
        &copy; 2024 PetCare. All rights reserved.
    </div>
</body>
</html>
