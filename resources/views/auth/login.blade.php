<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Portal Sistem - Vertue Concept</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"> 

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Memastikan konten login berada persis di tengah layar */
        body {
            background-color: #F2F2F2;
            color: #0B2154;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            overflow: hidden; 
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* --- EFEK GLOWING ORB --- */
        .glow-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            z-index: -1;
            animation: float 10s infinite ease-in-out alternate;
        }
        .orb-1 { width: 400px; height: 400px; background: rgba(212, 175, 55, 0.08); top: -10%; left: -10%; }
        .orb-2 { width: 300px; height: 300px; background: rgba(212, 175, 55, 0.05); bottom: -5%; right: 5%; animation-delay: -5s; }
        @keyframes float { 0% { transform: translate(0, 0); } 100% { transform: translate(30px, 50px); } }

        /* --- LAYOUT UTAMA --- */
        .login-wrapper { width: 100%; max-width: 1000px; padding: 20px; z-index: 10; }
        
        .brand-panel { 
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.05) 0%, rgba(212, 175, 55, 0.15) 100%); 
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 15px;
            padding: 3rem;
            box-shadow: 0 15px 35px rgba(0,0,0,0.05);
            background-color: white; /* Fallback */
            backdrop-filter: blur(10px);
        }

        /* --- FORMS & INPUTS --- */
        .form-label { border-radius: 15px; font-size: 0.85rem; font-weight: 600; letter-spacing: 0.5px; color: #6b7280; text-transform: uppercase; }
        
        .input-group-custom { position: relative; margin-bottom: 1.5rem; }
        .input-group-custom i.bi-person, .input-group-custom i.bi-key { 
            position: absolute; left: 18px; top: 50%; transform: translateY(-50%); color: #D4AF37; z-index: 5; font-size: 1.2rem;
        }
        .input-group-custom .form-futuristic { 
            padding-left: 50px !important; width: 100%; border-radius: 12px; height: 50px; border: 1px solid #e5e7eb;
            transition: all 0.3s;
        } 
        .input-group-custom .form-futuristic:focus {
            border-color: #D4AF37; box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.2); outline: none;
        }
        
        .toggle-password { 
            position: absolute; right: 18px; left: auto !important; top: 50%; 
            transform: translateY(-50%); color: #a1a1aa !important; 
            cursor: pointer; z-index: 5; transition: color 0.3s; font-size: 1.2rem;
        }
        .toggle-password:hover { color: #D4AF37 !important; }

        /* --- TOMBOL --- */
        .custom-btn-login {
            background-color: #0B2154;
            color: #FFFFFF;
            padding: 12px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            border: none;
            box-shadow: 0 4px 15px rgba(11, 33, 84, 0.2);
            transition: all 0.3s ease;
        }
        .custom-btn-login:hover {
            background-color: #071536;
            color: #D4AF37;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(11, 33, 84, 0.3);
        }

        /* --- ALERT ERROR --- */
        .alert-danger {
            background: #fee2e2;
            color: #dc2626;
            border: none;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 13px;
            margin-bottom: 20px;
            border-left: 4px solid #dc2626;
        }
    </style>
</head>

<body>

    <div class="glow-orb orb-1"></div>
    <div class="glow-orb orb-2"></div>

    <div class="login-wrapper">
        <div class="row g-0 p-0 justify-content-center"> 
            
            <div class="col-12 col-lg-10 brand-panel">
                <div class="row align-items-center">
                    
                    <div class="col-md-6 pe-md-5 mb-5 mb-md-0 border-md-end" style="border-color: rgba(11,33,84,0.1) !important;">
                        <div class="logo-wrapper mb-4" style="background: white; padding: 10px 25px; border-radius: 30px; display: inline-block; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                            <img src="{{ asset('img/logo-vertue.png') }}" alt="Vertue Concept" style="height: 40px;" onerror="this.src='https://via.placeholder.com/150x50/ffffff/D4AF37?text=VERTUE'">
                        </div>
                        <h2 class="fw-bold mb-3" style="line-height: 1.2;">Sistem Manajemen <br><span style="color: #D4AF37;">Produksi & Penjualan</span></h2>
                        <p style="color: #0B2154; font-size: 0.95rem; line-height: 1.6;">
                            Portal internal khusus staf dan teknisi Vertue Concept. Kelola pesanan, Bill of Material (BOM), dan inventori secara real-time.
                        </p>
                    </div>

                    <div class="col-md-6 ps-md-5">
                        <div class="mb-4 text-center text-md-start">
                            <h3 class="fw-bold mb-1">Selamat Datang Kembali</h3>
                            <p style="color: #0B2154;">Silakan masukkan kredensial Anda untuk melanjutkan.</p>
                        </div>

                        @if(session('error'))
                            <div class="alert-danger">{{ session('error') }}</div>
                        @endif

                        <form method="POST" action="{{ route('login.post') }}" id="loginForm">
                            @csrf 
                            
                            <div class="mb-4">
                                <label class="form-label">Nama Petugas</label>
                                <div class="input-group-custom">
                                    <i class="bi bi-person"></i>
                                    <input type="text" name="username" class="form-control form-futuristic" placeholder="Masukkan Nama Petugas..." value="{{ old('username') }}" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label d-flex justify-content-between">
                                    <span>Kata Sandi</span>
                                    <a href="#" class="text-decoration-none" style="text-transform: none; font-weight: 600; color: #D4AF37;">Lupa Sandi?</a>
                                </label>
                                <div class="input-group-custom">
                                    <i class="bi bi-key"></i>
                                    <input type="password" name="password" class="form-control form-futuristic" id="password" placeholder="••••••••" required>
                                    <i class="bi bi-eye-slash toggle-password" id="togglePassword"></i>
                                </div>
                            </div>

                            <button type="submit" class="btn custom-btn-login mt-2 w-100">
                                Masuk Sistem <i class="bi bi-box-arrow-in-right ms-2"></i>
                            </button>
                        </form>
                        
                        <div class="mt-4 text-center">
                            <small class="text-muted">Demo: Nama = Edy | Password = 123</small>
                            <br>
                            <small class="text-muted">Atau: , Bambang Supriyadi, Rizky Fadillah, Siti Nurjanah</small>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        if(togglePassword) {
            togglePassword.addEventListener('click', function () {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                this.classList.toggle('bi-eye');
                this.classList.toggle('bi-eye-slash');
            });
        }
    </script>
</body>
</html>