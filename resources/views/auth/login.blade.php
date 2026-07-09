<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - Coffee Management System</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Custom Login CSS -->
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
</head>

<body>
    <div class="login-wrapper">
        <div class="login-container">
            <!-- Header Section -->
            <div class="login-header">
                <div class="logo-icon">
                    <i class="fas fa-lock"></i>
                </div>
                <h2>Login</h2>
                <p>Sign in to your account</p>
            </div>

            <!-- Error Alert -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login.store') }}" id="loginForm" novalidate>
                @csrf

                <!-- Username Field -->
                <div class="form-group">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control @error('username') is-invalid @enderror" id="username"
                        name="username" placeholder="Enter your username" value="{{ old('username') }}" required
                        autofocus>
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @else
                        <div class="invalid-feedback" id="usernameError"></div>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            id="password" name="password" placeholder="Enter your password" required>
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @else
                        <div class="invalid-feedback" id="passwordError"></div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-login">
                    Sign In
                </button>
            </form>

            <!-- Footer Text -->
            <p class="form-text">
                &copy; 2026 Coffee Management System. All rights reserved.
            </p>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Login JS -->
    <script src="{{ asset('js/login.js') }}"></script>
</body>

</html>
