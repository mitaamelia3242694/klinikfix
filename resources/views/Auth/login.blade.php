<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Klinik Pratama Lanal Banyuwangi</title>
    <link rel="stylesheet" href="css/login.css" />
    <style>
    .darken-img {
        filter: brightness(0.3);
        /* Semakin kecil nilainya, semakin gelap (0 - 1) */
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="left">
            <img src="login.jpeg" alt="Doctor writing" class="darken-img" />
        </div>
        <div class="right">
            <div class="login-box">
                <img src="/logo.png" alt="Logo" class="logo">
                <h2>Klinik Pratama Lanal Banyuwangi</h2>
                <h3>Login</h3>
                <p>Enter your email and password to Login</p>
                @if ($errors->any())
                <div class="error-message">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li style="color: red">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required />
                    <input type="password" name="password" placeholder="Current password" required />
                    <button type="submit">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>