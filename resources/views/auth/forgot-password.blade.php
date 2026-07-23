<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi - TPA Baitur Ridwan</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:ital,wght@0,300..900;1,300..900&family=Manrope:wght@400;500;700&family=Plus+Jakarta+Sans:ital,wght@0,400;0,700;1,400&family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary: #004B3C;
            --primary-dark: #003227;
            --primary-light: #065F46;
            --accent: #FED65B;
            --accent-hover: #E5C052;
            --bg-color: #F8FAFC;
            --text-dark: #1C1C18;
            --text-gray: #707975;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        /* Main Split Card */
        .login-wrapper {
            display: flex;
            width: 100%;
            max-width: 760px;
            min-height: 460px;
            background: #FFFFFF;
            border-radius: 24px;
            box-shadow: 0 20px 40px -15px rgba(0, 50, 39, 0.08);
            overflow: hidden;
            margin: 24px;
            animation: formFloatUp 0.8s ease-out forwards;
        }

        @keyframes formFloatUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Left Panel - Branding & Islamic Nuance */
        .login-left {
            flex: 1;
            background: var(--primary);
            position: relative;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: #FFFFFF;
            overflow: hidden;
        }

        .left-content {
            position: relative;
            z-index: 2;
        }

        .left-icon {
            font-size: 40px;
            color: var(--accent);
            margin-bottom: 16px;
        }

        .left-title {
            font-family: 'Epilogue', sans-serif;
            font-weight: 800;
            font-size: 28px;
            line-height: 1.2;
            margin: 0 0 12px 0;
        }

        .left-subtitle {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.8);
            margin: 0;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            font-family: 'Manrope', sans-serif;
            font-weight: 600;
            font-size: 14px;
            margin-top: 32px;
            transition: color 0.3s ease;
            width: fit-content;
        }
        .back-link:hover { color: var(--accent); }

        /* Right Panel - Form */
        .login-right {
            flex: 1.2;
            padding: 48px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: #FFFFFF;
        }

        .form-title {
            font-family: 'Epilogue', sans-serif;
            font-weight: 700;
            font-size: 24px;
            color: var(--primary-dark);
            margin: 0 0 12px 0;
        }
        
        .form-desc {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px;
            color: var(--text-gray);
            line-height: 1.6;
            margin: 0 0 20px 0;
        }

        .info-alert {
            background-color: rgba(254, 214, 91, 0.1);
            border-left: 4px solid var(--accent);
            padding: 12px 16px;
            border-radius: 0 8px 8px 0;
            margin-bottom: 20px;
            display: flex;
            gap: 12px;
            align-items: flex-start;
        }
        
        .info-alert .material-symbols-outlined {
            color: #745C00;
            font-size: 18px;
        }
        
        .info-alert p {
            margin: 0;
            font-size: 13px;
            color: #404945;
            line-height: 1.5;
        }

        .input-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-bottom: 20px;
        }

        .input-label {
            font-family: 'Manrope', sans-serif;
            font-weight: 700;
            font-size: 12px;
            color: var(--text-gray);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            color: #9CA3AF;
            font-size: 20px;
        }

        .form-input {
            width: 100%;
            background: #FFFFFF;
            border: 1px solid #E5E7EB;
            border-radius: 12px;
            padding: 12px 16px 12px 48px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px;
            color: var(--text-dark);
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(0, 75, 60, 0.1);
        }

        .btn-login {
            width: 100%;
            background: var(--primary);
            color: #FFFFFF;
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-family: 'Manrope', sans-serif;
            font-weight: 700;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-login:hover {
            background: var(--primary-dark);
            box-shadow: 0 10px 15px -3px rgba(0, 75, 60, 0.2);
            transform: translateY(-2px);
        }

        .back-to-login {
            display: block;
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        .back-to-login:hover {
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .login-wrapper {
                flex-direction: column;
                max-width: 500px;
                min-height: auto;
            }
            .login-left {
                padding: 40px 32px;
                text-align: center;
            }
            .back-link {
                margin: 24px auto 0;
            }
            .login-right {
                padding: 40px 32px;
            }
        }
    </style>
</head>
<body>

    <div class="login-wrapper">
        <!-- Left Panel: Branding & Nuance -->
        <div class="login-left">
            <div class="left-content">
                <span class="material-symbols-outlined left-icon">lock_reset</span>
                <h1 class="left-title">Lupa Kata Sandi?</h1>
                <p class="left-subtitle">Jangan khawatir, kami akan membantu Anda memulihkan akses ke akun Sistem Informasi Akademik Anda.</p>
                
                <a href="{{ url('/') }}" class="back-link">
                    <span class="material-symbols-outlined" style="font-size: 18px;">arrow_back</span>
                    Kembali ke Beranda
                </a>
            </div>
        </div>

        <!-- Right Panel: Form -->
        <div class="login-right">
            <h2 class="form-title">Pemulihan Akun</h2>
            <p class="form-desc">Masukkan alamat email yang terdaftar, dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda.</p>
            
            <div class="info-alert">
                <span class="material-symbols-outlined">info</span>
                <p>Jika Anda kesulitan mengakses email Anda, silakan hubungi <strong>Kepala TPA</strong> atau bagian administrasi untuk bantuan pemulihan akun secara langsung.</p>
            </div>

            @if(session('success'))
                <div style="background-color: #ECFDF5; border-left: 4px solid #10B981; padding: 12px 16px; border-radius: 0 8px 8px 0; margin-bottom: 20px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; color: #047857; line-height: 1.5; font-weight: 500;">
                    {{ session('success') }}
                    
                    @if(session('local_reset_url'))
                        <div style="margin-top: 10px; padding: 10px; background: #FFFFFF; border: 1px dashed #10B981; border-radius: 8px; font-size: 12px; color: #1C1C18;">
                            <strong style="color: #BA1A1A;">[Localhost Fallback]</strong> Jaringan internet Anda memblokir port SMTP luar (587/465).<br>
                            Tautan reset Anda:<br>
                            <a href="{{ session('local_reset_url') }}" style="color: #004B3C; word-break: break-all; font-weight: bold;">
                                {{ session('local_reset_url') }}
                            </a>
                        </div>
                    @endif
                </div>
            @endif
            
            <form action="{{ route('password.email') }}" method="POST">
                @csrf
                <div class="input-group">
                    <label class="input-label" for="email">Alamat Email</label>
                    <div class="input-wrapper">
                        <span class="material-symbols-outlined input-icon">mail</span>
                        <input type="email" id="email" name="email" class="form-input" placeholder="guru@baiturridwan.com" value="{{ old('email') }}" required>
                    </div>
                    @error('email')
                        <div class="error-message" style="color: #ef4444; font-size: 13px; margin-top: 6px; font-weight: 500;">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-login">
                    Kirim Tautan Pemulihan
                </button>
                
                <a href="{{ route('login') }}" class="back-to-login">
                    Kembali ke Halaman Login
                </a>
            </form>
        </div>
    </div>

</body>
</html>
