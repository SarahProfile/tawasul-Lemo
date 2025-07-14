<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Tawasul Limousine</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sequel+Sans:wght@400;600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Sequel Sans', Arial, sans-serif;
            background: linear-gradient(135deg, #000000 0%, #333333 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .register-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            width: 100%;
            max-width: 450px;
            padding: 40px;
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo img {
            width: 150px;
            height: auto;
        }

        .register-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .register-header h1 {
            font-size: 2rem;
            font-weight: 300;
            color: #000000;
            margin-bottom: 10px;
        }

        .register-header p {
            color: #6D6D6D;
            font-size: 0.9rem;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            color: #333;
            font-weight: 500;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .form-group input {
            width: 100%;
            padding: 15px;
            border: 2px solid #E5E5E5;
            border-radius: 10px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
            font-family: 'Sequel Sans', Arial, sans-serif;
        }

        .form-group input:focus {
            outline: none;
            border-color: #000000;
        }

        .form-group input::placeholder {
            color: #B6B6B6;
        }

        .password-requirements {
            font-size: 0.8rem;
            color: #6D6D6D;
            margin-top: 5px;
            line-height: 1.4;
        }

        .register-btn {
            width: 100%;
            background: #000000;
            color: white;
            padding: 15px;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Sequel Sans', Arial, sans-serif;
            margin-bottom: 20px;
        }

        .register-btn:hover {
            background: #333333;
            transform: translateY(-2px);
        }

        .divider {
            text-align: center;
            margin: 25px 0;
            position: relative;
            color: #B6B6B6;
            font-size: 0.9rem;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #E5E5E5;
            z-index: 1;
        }

        .divider span {
            background: white;
            padding: 0 20px;
            position: relative;
            z-index: 2;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
        }

        .login-link p {
            color: #6D6D6D;
            font-size: 0.9rem;
        }

        .login-link a {
            color: #000000;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .login-link a:hover {
            color: #333333;
        }

        .error-message {
            background: #ffebee;
            color: #c62828;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            border-left: 4px solid #c62828;
        }

        .error-list {
            list-style: none;
        }

        .error-list li {
            margin-bottom: 5px;
        }

        .back-to-home {
            text-align: center;
            margin-top: 30px;
        }

        .back-to-home a {
            color: #6D6D6D;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .back-to-home a:hover {
            color: #000000;
        }

        @media (max-width: 480px) {
            .register-container {
                padding: 30px 20px;
                margin: 10px;
            }

            .register-header h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="logo">
            <img src="https://lh3.googleusercontent.com/d/1mDZyI13k_gSVuBae6JT-P_nN3FBgBxQM" alt="Tawasul Limousine">
        </div>

        <div class="register-header">
            <h1>Create Account</h1>
            <p>Join Tawasul Limousine for luxury travel</p>
        </div>

        @if ($errors->any())
            <div class="error-message">
                <ul class="error-list">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Enter your full name" required>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Create a password" required>
                <div class="password-requirements">
                    Password must be at least 8 characters long
                </div>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm your password" required>
            </div>

            <button type="submit" class="register-btn">Create Account</button>
        </form>

        <div class="divider">
            <span>or</span>
        </div>

        <div class="login-link">
            <p>Already have an account? <a href="{{ route('login') }}">Sign In</a></p>
        </div>

        <div class="back-to-home">
            <a href="{{ route('home') }}">← Back to Home</a>
        </div>
    </div>
</body>
</html>