<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DBHCHT - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 450px;
            position: relative;
            overflow: hidden;
        }
        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(to right, #4e73df, #224abe);
        }
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .login-header img {
            width: 80px;
            margin-bottom: 20px;
        }
        .login-header h2 {
            color: #333;
            font-size: 24px;
            font-weight: 600;
        }
        .form-group {
            margin-bottom: 20px;
            position: relative;
        }
        .form-control {
            height: 50px;
            padding-left: 45px;
            border: 2px solid #e1e1e1;
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78,115,223,0.1);
        }
        .form-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #b3b3b3;
            transition: all 0.3s ease;
        }
        .form-control:focus + .form-icon {
            color: #4e73df;
        }
        .btn-login {
            height: 50px;
            background: linear-gradient(45deg, #4e73df, #224abe);
            border: none;
            border-radius: 10px;
            color: white;
            font-weight: 500;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(78,115,223,0.3);
        }
        .back-to-home {
            text-align: center;
            margin-top: 20px;
        }
        .back-to-home a {
            color: #3f51b5;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        .back-to-home a:hover {
            opacity: 0.8;
        }
        .alert {
            border-radius: 10px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row ">
            <div class="col-md-6 mx-auto">
                <div class="login-container mx-auto">
                    <div class="login-header">
                        <img src="{{ asset('logo_jepara.png') }}" alt="DBHCHT Logo" class="mb-4">
                        <h2>Selamat Datang</h2>
                        <p class="text-muted">Silakan login untuk melanjutkan</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <p class="mb-0">{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <input type="text" 
                                   class="form-control @error('username') is-invalid @enderror" 
                                   name="username" 
                                   id="username" 
                                   value="{{ old('username') }}"
                                   placeholder="Username"
                                   required 
                                   autofocus>
                            <i class="fas fa-user form-icon"></i>
                            @error('username')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   name="password" 
                                   id="password" 
                                   placeholder="Password"
                                   required>
                            <i class="fas fa-lock form-icon"></i>
                        </div>

                        <button type="submit" class="btn btn-login w-100">
                            Login
                        </button>
                    </form>

                    <div class="back-to-home">
                        <a href="/">
                            <i class="fas fa-arrow-left me-2"></i>
                            Kembali ke Halaman Utama
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
