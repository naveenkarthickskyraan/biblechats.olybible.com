<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Support System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #ec4899;
            --primary-light: #f472b6;
            --secondary: #9333ea;
            --accent: #f9a8d4;
            --light: #fdf2f8;
            --light-gray: #fce7f3;
            --border-radius: 16px;
            --box-shadow: 0 10px 30px rgba(236, 72, 153, 0.12);
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: linear-gradient(135deg, #fdf2f8 0%, #f3e8ff 100%);
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .login-container {
            max-width: 600px;
            width: 100%;
        }
        
        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            overflow: hidden;
            transition: var(--transition);
            background: white;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        }
        
        .graphic-side {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        
        .graphic-side::before {
            content: "";
            position: absolute;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            top: -100px;
            right: -100px;
        }
        
        .graphic-side::after {
            content: "";
            position: absolute;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            bottom: -75px;
            left: -75px;
        }
        
        .graphic-content {
            position: relative;
            z-index: 2;
        }
        
        .graphic-side h2 {
            font-weight: 700;
            margin-bottom: 20px;
            font-size: 28px;
        }
        
        .graphic-side p {
            opacity: 0.9;
            margin-bottom: 30px;
            font-size: 16px;
            line-height: 1.6;
        }
        
        .features {
            list-style: none;
            padding: 0;
            margin-bottom: 40px;
        }
        
        .features li {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }
        
        .features i {
            background: rgba(255, 255, 255, 0.2);
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 14px;
        }
        
        .stats {
            display: flex;
            gap: 20px;
        }
        
        .stat-item {
            text-align: center;
            flex: 1;
        }
        
        .stat-value {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .stat-label {
            font-size: 14px;
            opacity: 0.8;
        }
        
        .form-side {
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .logo {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .logo h1 {
            color: var(--primary);
            font-weight: 700;
            font-size: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .logo-icon {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }
        
        .form-control {
            border-radius: 10px;
            padding: 14px 16px;
            border: 1px solid var(--light-gray);
            transition: var(--transition);
            font-size: 15px;
        }
        
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
        }
        
        .input-group-text {
            background: white;
            border: 1px solid var(--light-gray);
            border-right: none;
            padding: 14px 16px;
        }
        
        .form-control:focus + .input-group-text {
            border-color: var(--primary);
        }
        
        .btn-login {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            border: none;
            padding: 14px 20px;
            border-radius: 10px;
            font-weight: 600;
            transition: var(--transition);
            font-size: 16px;
            color: white;
            width: 100%;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 7px 15px rgba(67, 97, 238, 0.3);
        }
        
        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        
        .divider {
            display: flex;
            align-items: center;
            margin: 25px 0;
        }
        
        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid var(--light-gray);
        }
        
        .divider span {
            padding: 0 15px;
            color: var(--gray);
            font-size: 14px;
        }
        
        .social-login {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
        }
        
        .social-btn {
            flex: 1;
            padding: 12px;
            border: 1px solid var(--light-gray);
            border-radius: 10px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            font-size: 14px;
        }
        
        .social-btn:hover {
            border-color: var(--primary);
            transform: translateY(-2px);
        }
        
        .alert {
            border-radius: 10px;
            border: none;
            padding: 14px 16px;
        }
        
        .forgot-link {
            color: var(--primary);
            text-decoration: none;
            transition: var(--transition);
        }
        
        .forgot-link:hover {
            color: var(--secondary);
        }
        
        @media (max-width: 992px) {
            .graphic-side {
                display: none;
            }
            
            .form-side {
                padding: 40px 30px;
            }
        }
        
        .floating-label {
            position: relative;
            margin-bottom: 24px;
        }
        
        .floating-label label {
            position: absolute;
            top: 16px;
            left: 16px;
            color: var(--gray);
            transition: var(--transition);
            pointer-events: none;
            background: white;
            padding: 0 5px;
        }
        
        .floating-label .form-control:focus ~ label,
        .floating-label .form-control:not(:placeholder-shown) ~ label {
            top: -10px;
            left: 12px;
            font-size: 13px;
            color: var(--primary);
        }
        
        .password-toggle {
            cursor: pointer;
            background: none;
            border: none;
            color: var(--gray);
        }
        
        .alert-danger {
            background: #fce7f3 !important;
            border: 1px solid #f9a8d4 !important;
            color: #9d174d !important;
        }
        
    </style>
    
</head>
<body>
    <div class="login-container">
        <div class="card">
            <div class="row g-0">
                <!-- Right Side with Login Form -->
                <div class="col-lg-12 form-side">
                    <div class="logo">
                        <h1><span class="logo-icon"><i class="fas fa-headset"></i></span> Bible Talk to Support</h1>
                    </div>
                    
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="fas fa-exclamation-circle me-2"></i>{{ $error }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endforeach
                        @endif
                        
                        <div class="floating-label">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder=" ">
                            <label for="email"><i class="fas fa-envelope me-2"></i>Email Address</label>
                            @error('email')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="floating-label">
                            <div class="input-group">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder=" ">
                                <label for="password"><i class="fas fa-lock me-2"></i>Password</label>
                                <button type="button" class="input-group-text password-toggle" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    Remember me
                                </label>
                            </div>
                            
                            <!--@if (Route::has('password.request'))-->
                            <!--    <a href="{{ route('password.request') }}" class="forgot-link">-->
                            <!--        Forgot password?-->
                            <!--    </a>-->
                            <!--@endif-->
                        </div>
                        
                        <button type="submit" class="btn btn-login mb-4">
                            <i class="fas fa-sign-in-alt me-2"></i>Sign In to Dashboard
                        </button>
                        
                        <!--<div class="divider">-->
                        <!--    <span>Or continue with</span>-->
                        <!--</div>-->
                        
                        <!--<div class="social-login">-->
                        <!--    <button type="button" class="social-btn">-->
                        <!--        <i class="fab fa-google text-danger me-2"></i> Google-->
                        <!--    </button>-->
                        <!--    <button type="button" class="social-btn">-->
                        <!--        <i class="fab fa-microsoft text-primary me-2"></i> Microsoft-->
                        <!--    </button>-->
                        <!--    <button type="button" class="social-btn">-->
                        <!--        <i class="fab fa-slack text-warning me-2"></i> Slack-->
                        <!--    </button>-->
                        <!--</div>-->
                        
                        <div class="text-center mt-4">
                            <p class="mb-0">Need access? <a href="#" class="forgot-link">Contact your administrator</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
        
        // Add animation to form elements on focus
        const formControls = document.querySelectorAll('.form-control');
        formControls.forEach(control => {
            control.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            
            control.addEventListener('blur', function() {
                if (this.value === '') {
                    this.parentElement.classList.remove('focused');
                }
            });
        });
    </script>
</body>
</html>