<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Vertue Concept - Specialist Interior Mobil Sunter</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Vertue Concept bengkel spesialis interior mobil restomod period correct Sunter Jakarta Utara" name="keywords">
    <meta content="Vertue Concept adalah bengkel spesialis interior mobil di Sunter, Jakarta Utara. Spesialisasi restomod period correct untuk mobil klasik mewah seperti Porsche dan Mazda RX-7." name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- GABUNGAN TEMPLATE CSS LAMA & PERBAIKAN -->
    <style>
        :root {
            --primary: #D4AF37;  /* GOLD */
            --bs-primary: #D4AF37;
            --secondary: #0B2154;
            --light: #F2F2F2;
            --dark: #111111;
            --white: #FFFFFF;
            --light-bg: #F8FAFC;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--white);
            color: var(--dark);
        }

        /* --- WARNA & TYPOGRAPHY --- */
        .text-primary { color: var(--primary) !important; }
        .bg-primary { background-color: var(--primary) !important; }
        .text-dark { color: var(--dark) !important; }
        .bg-dark { background-color: var(--dark) !important; }
        
        h1, h2, h3, h4, h5, h6, .fw-medium {
            font-weight: 700;
            color: var(--dark);
        }

        /* --- NAVBAR SANGAT TIPIS & RAPI --- */
        .navbar {
            padding: 0 !important; /* Menghilangkan padding bawaan */
            background: white !important;
            transition: all 0.3s ease;
            height: 60px; /* Tinggi pasti navbar */
        }
        .navbar.shadow {
            box-shadow: 0 4px 15px rgba(0,0,0,0.05) !important;
        }
        .navbar-brand {
            display: flex;
            align-items: center;
            height: 100%;
        }
        .navbar-brand img { 
            height: 40px; /* Logo lebih kecil agar muat di navbar tipis */
        }
        .navbar-brand span { display: none; }
        
        .navbar-nav .nav-link {
            color: var(--dark);
            font-weight: 600;
            padding: 20px 15px !important; /* Vertikal center */
            font-size: 13px;
            text-transform: uppercase;
            transition: 0.3s;
            letter-spacing: 0.5px;
        }
        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: var(--primary) !important;
        }

        /* --- BUTTONS --- */
        .btn {
            font-weight: 600;
            text-transform: uppercase;
            transition: .3s;
            border-radius: 5px !important; /* KOTAK LANCIP */
        }
        .btn-primary {
            background-color: var(--primary) !important;
            border-color: var(--primary) !important;
            color: #FFFFFF !important;
            padding: 8px 24px;
            font-size: 14px;
        }
        .btn-primary:hover {
            background-color: #B8972E !important; /* Gold lebih gelap */
            border-color: #B8972E !important;
        }

        /* PERBAIKAN TOMBOL DASHBOARD AGAR TIDAK MELAR */
        .nav-btn-container {
            display: flex;
            align-items: center;
            height: 60px; /* Samakan dengan tinggi navbar */
            padding-left: 20px;
        }
        .nav-btn-container .btn {
            align-self: center; /* Memaksa tombol di tengah dan tidak stretch */
        }

        /* --- CAROUSEL --- */
        .carousel-item {
            height: 100vh;
            min-height: 500px;
        }
        .carousel-item img {
            object-fit: cover;
            height: 100%;
            width: 100%;
        }
        .carousel-item::after {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(to right, rgba(17, 17, 17, 0.9) 0%, rgba(17, 17, 17, 0.4) 100%);
            z-index: 1;
        }
        .carousel-caption {
            z-index: 2;
            bottom: 0; top: 0;
            text-align: left;
        }
        .carousel-control-prev-icon, .carousel-control-next-icon {
            background-color: var(--primary) !important;
            width: 3rem;
            height: 3rem;
        }

        /* --- CARD KEUNGGULAN --- */
        .keunggulan-card {
            background: var(--white);
            border-radius: 5px;
            transition: all 0.3s;
            border: 1px solid #E2E8F0;
            box-shadow: 0 4px 6px rgba(0,0,0,0.02);
            height: 100%;
        }
        .keunggulan-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary);
            box-shadow: 0 15px 30px rgba(212,175,55,0.1);
        }
        .keunggulan-card i {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(212,175,55,0.1);
            font-size: 24px;
            border-radius: 5px;
        }

        /* --- ABOUT & BADGE --- */
        .about-img-wrapper {
            position: relative;
            overflow: hidden;
        }
        .about-img-wrapper img {
            width: 100%;
            object-fit: cover;
            min-height: 450px;
        }
        .experience-badge {
            background: rgba(212,175,55,0.95);
            backdrop-filter: blur(5px);
        }

        /* --- SERVICE TABS --- */
        .service .nav-pills .nav-link {
            border-radius: 5px !important;
            transition: all 0.3s ease;
            background: var(--light-bg);
            margin-bottom: 10px;
            border: 1px solid transparent;
            color: var(--dark);
            padding: 15px 20px !important;
            font-weight: 600;
        }
        .service .nav-pills .nav-link i {
            color: var(--primary);
            transition: 0.3s;
        }
        .service .nav-pills .nav-link.active {
            background: var(--primary) !important;
            color: white !important;
        }
        .service .nav-pills .nav-link.active i,
        .service .nav-pills .nav-link.active h5 {
            color: white !important;
        }

        /* --- FORMS --- */
        .form-control, .form-select {
            border-radius: 5px !important;
            border: 1px solid #E2E8F0;
            padding: 12px 18px;
            background-color: var(--light-bg);
            box-shadow: none !important;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            background-color: white;
        }

        /* --- ICONS --- */
        .fa-map-marker-alt, .fa-clock, .fa-phone-alt, .fa-check,
        .fa-certificate, .fa-users-cog, .fa-tools, .fa-car-side,
        .fa-car, .fa-cog, .fa-spray-can, .fa-couch, .fa-arrow-right {
            color: var(--primary) !important;
        }
        .btn-social i, .btn-outline-light i {
            color: white !important;
        }
        
        /* PAS DI KLIK - ICON JADI PUTIH */
        a:active i, .btn:active i, button:active i {
            transform: scale(0.9);
            transition: all 0.1s ease;
        }

        /* --- FOOTER & NEWSLETTER PERBAIKAN --- */
        .footer {
            background: linear-gradient(rgba(17, 17, 17, 0.95), rgba(17, 17, 17, 0.95)), url('img/carousel-bg-1.jpg') center center no-repeat;
            background-size: cover;
        }
        .footer .btn-link {
            transition: all 0.3s;
            color: rgba(255,255,255,0.7);
            text-transform: capitalize;
        }
        .footer .btn-link::before {
            position: relative;
            content: "\f105";
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            margin-right: 10px;
        }
        .footer .btn-link:hover {
            transform: translateX(5px);
            color: var(--primary) !important;
            letter-spacing: 0.5px;
        }

        /* Back to top */
        .back-to-top {
            position: fixed;
            display: none;
            right: 30px;
            bottom: 30px;
            z-index: 99;
            border-radius: 5;
        }

        @media (max-width: 991px) {
            .navbar { height: auto; padding: 10px 0 !important; }
            .nav-btn-container { height: auto; padding: 15px 0 5px 0; justify-content: flex-start; }
            .carousel-item { min-height: 450px; height: auto; padding: 100px 0; }
        }
    </style>
</head>

<body>
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top shadow-sm">
        <div class="container">
            <a href="{{ route('index') }}" class="navbar-brand">
                <img src="{{ asset('img/logo-vertue.png') }}" alt="Vertue Concept Logo" onerror="this.style.display='none'">
            </a>
            <button type="button" class="navbar-toggler rounded-0" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto">
                    <a href="#beranda" class="nav-item nav-link active">Beranda</a>
                    <a href="#about" class="nav-item nav-link">Tentang</a>
                    <a href="#service" class="nav-item nav-link">Layanan</a>
                    <a href="#booking" class="nav-item nav-link">Booking</a>
                    <a href="#contact" class="nav-item nav-link">Kontak</a>
                </div>
                <div class="nav-btn-container">
                    <a href="{{ route('login') }}" class="btn btn-primary rounded-0">LOGIN STAFF</a>
                </div>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Carousel Start -->
    <div id="beranda" class="container-fluid p-0 mb-5">
        <div id="header-carousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="w-100" src="img/carousel-bg-1.jpg" alt="Interior Mobil Mewah">
                    <div class="carousel-caption d-flex align-items-center">
                        <div class="container">
                            <div class="row align-items-center justify-content-center justify-content-lg-start">
                                <div class="col-12 col-lg-8 text-center text-lg-start">
                                    <h6 class="text-primary text-uppercase mb-3 fw-bold animated slideInDown" style="letter-spacing: 2px;">Specialist Interior Mobil</h6>
                                    <h1 class="display-3 text-white mb-4 pb-2 animated slideInDown fw-bold">Restomod Period Correct untuk Mobil Klasik Anda</h1>
                                    <a href="#about" class="btn btn-primary py-3 px-5 animated slideInUp">Pelajari Lebih Lanjut <i class="fa fa-arrow-right ms-2 text-white"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="w-100" src="img/carousel-bg-2.jpg" alt="Interior Kulit Premium">
                    <div class="carousel-caption d-flex align-items-center">
                        <div class="container">
                            <div class="row align-items-center justify-content-center justify-content-lg-start">
                                <div class="col-12 col-lg-8 text-center text-lg-start">
                                    <h6 class="text-primary text-uppercase mb-3 fw-bold animated slideInDown" style="letter-spacing: 2px;">Material Premium Impor</h6>
                                    <h1 class="display-3 text-white mb-4 pb-2 animated slideInDown fw-bold">Kulit Wollsdorf Nappa Austria & Alcantara</h1>
                                    <a href="#service" class="btn btn-primary py-3 px-5 animated slideInUp">Lihat Layanan <i class="fa fa-arrow-right ms-2 text-white"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev w-auto ps-4" type="button" data-bs-target="#header-carousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Sebelumnya</span>
            </button>
            <button class="carousel-control-next w-auto pe-4" type="button" data-bs-target="#header-carousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Selanjutnya</span>
            </button>
        </div>
    </div>
    <!-- Carousel End -->

    <!-- Keunggulan Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="keunggulan-card p-4 d-flex flex-column">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fa fa-certificate text-primary flex-shrink-0"></i>
                            <h5 class="mb-0 ms-3">Restomod Period Correct</h5>
                        </div>
                        <p class="mb-0 text-muted">Mengembalikan nuansa interior mobil lawas seperti saat pertama diluncurkan, dengan tetap mempertahankan gaya modifikasi era produksinya.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="keunggulan-card p-4 d-flex flex-column">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fa fa-users-cog text-primary flex-shrink-0"></i>
                            <h5 class="mb-0 ms-3">Konsultan Interior</h5>
                        </div>
                        <p class="mb-0 text-muted">Edy, pemilik Vertue Concept, menjadikan bengkel ini sebagai konsultan interior yang mengutamakan fungsi dan keaslian desain.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="keunggulan-card p-4 d-flex flex-column">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fa fa-tools text-primary flex-shrink-0"></i>
                            <h5 class="mb-0 ms-3">Material Premium</h5>
                        </div>
                        <p class="mb-0 text-muted">Kulit Wollsdorf Nappa Austria, Autoleder, Italy Leather. Kami memberikan garansi minimal 2 tahun untuk pengerjaan kulit asli.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Keunggulan End -->

    <!-- About Start -->
    <div id="about" class="container-xxl py-5">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                    <div class="about-img-wrapper">
                        <img class="img-fluid" src="img/about.jpg" alt="Vertue Concept Bengkel Interior Sunter">
                        <div class="experience-badge position-absolute bottom-0 start-0 m-4 py-3 px-4 text-center">
                            <h1 class="display-5 text-white mb-0 fw-bold">22 <span class="fs-5 fw-normal">Tahun</span></h1>
                            <p class="text-white mb-0 mt-1">Pengalaman Profesional</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h1 class="mb-4 wow fadeInUp" data-wow-delay="0.2s">Vertue Concept <br><span class="text-primary">Specialist Interior Mobil</span> Sejak 2004</h1>
                    <p class="mb-4 text-muted wow fadeInUp" data-wow-delay="0.3s" style="line-height: 1.8;">Berlokasi di Sunter, Jakarta Utara, Vertue Concept adalah bengkel spesialis interior mobil yang sudah berdiri sejak tahun 2004. Kami fokus pada restorasi dan modifikasi interior (restomod) dengan tema "period-correct".</p>
                    
                    <div class="row g-4 mb-4">
                        <div class="col-12 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="d-flex align-items-start">
                                <div class="bg-primary text-white d-flex flex-shrink-0 align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                    <span class="fw-bold">01</span>
                                </div>
                                <div class="ps-3">
                                    <h6 class="mb-1">Filosofi "Solusi"</h6>
                                    <p class="text-muted mb-0">Konsultan interior yang mengutamakan fungsi jangka panjang dan keaslian desain.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 wow fadeInUp" data-wow-delay="0.3s">
                            <div class="d-flex align-items-start">
                                <div class="bg-primary text-white d-flex flex-shrink-0 align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                    <span class="fw-bold">02</span>
                                </div>
                                <div class="ps-3">
                                    <h6 class="mb-1">Material Premium Impor</h6>
                                    <p class="text-muted mb-0">Kulit Wollsdorf Nappa Austria, Autoleder, Italy Leather, dan Alcantara.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="#service" class="btn btn-primary py-3 px-5 wow fadeInUp" data-wow-delay="0.6s">Jelajahi Layanan</a>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

    <!-- Fact Start -->
    <div class="container-fluid bg-dark my-5 py-5" style="background: linear-gradient(135deg, #111 0%, #222 100%) !important;">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6 col-lg-3 text-center wow fadeInUp" data-wow-delay="0.1s">
                    <div class="p-4 border border-secondary border-opacity-25 h-100">
                        <i class="fa fa-certificate fa-2x text-primary mb-3"></i>
                        <h2 class="text-white mb-2" data-toggle="counter-up">2004</h2>
                        <p class="text-white text-opacity-75 mb-0">Tahun Berdiri</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 text-center wow fadeInUp" data-wow-delay="0.3s">
                    <div class="p-4 border border-secondary border-opacity-25 h-100">
                        <i class="fa fa-users-cog fa-2x text-primary mb-3"></i>
                        <h2 class="text-white mb-2" data-toggle="counter-up">10</h2>
                        <p class="text-white text-opacity-75 mb-0">Teknisi Ahli</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 text-center wow fadeInUp" data-wow-delay="0.5s">
                    <div class="p-4 border border-secondary border-opacity-25 h-100">
                        <i class="fa fa-check fa-2x text-primary mb-3"></i>
                        <h2 class="text-white mb-2" data-toggle="counter-up">933</h2>
                        <p class="text-white text-opacity-75 mb-0">Klien Puas</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 text-center wow fadeInUp" data-wow-delay="0.7s">
                    <div class="p-4 border border-secondary border-opacity-25 h-100">
                        <i class="fa fa-car-side fa-2x text-primary mb-3"></i>
                        <h2 class="text-white mb-2" data-toggle="counter-up">1000</h2>
                        <p class="text-white text-opacity-75 mb-0">Proyek Terselesaikan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fact End -->

    <!-- Service Start -->
    <div id="service" class="container-xxl service py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h1 class="mb-5">Layanan Unggulan Vertue Concept</h1>
            </div>
            <div class="row g-4 wow fadeInUp" data-wow-delay="0.3s">
                <div class="col-lg-4">
                    <div class="nav w-100 nav-pills me-4">
                        <button class="nav-link w-100 d-flex align-items-center text-start active" data-bs-toggle="pill" data-bs-target="#tab-pane-1" type="button">
                            <i class="fa fa-car-side fa-2x me-3"></i>
                            <h5 class="m-0 ms-2">Restomod Period Correct</h5>
                        </button>
                        <button class="nav-link w-100 d-flex align-items-center text-start" data-bs-toggle="pill" data-bs-target="#tab-pane-2" type="button">
                            <i class="fa fa-car fa-2x me-3"></i>
                            <h5 class="m-0 ms-2">Perbaikan & Pelapisan</h5>
                        </button>
                        <button class="nav-link w-100 d-flex align-items-center text-start" data-bs-toggle="pill" data-bs-target="#tab-pane-3" type="button">
                            <i class="fa fa-spray-can fa-2x me-3"></i>
                            <h5 class="m-0 ms-2">Vertue Clean (Fogging)</h5>
                        </button>
                        <button class="nav-link w-100 d-flex align-items-center text-start mb-0" data-bs-toggle="pill" data-bs-target="#tab-pane-4" type="button">
                            <i class="fa fa-couch fa-2x me-3"></i>
                            <h5 class="m-0 ms-2">Custom Total Interior</h5>
                        </button>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="tab-content w-100">
                        <div class="tab-pane fade show active" id="tab-pane-1">
                            <div class="row g-4 align-items-center">
                                <div class="col-md-6">
                                    <img class="img-fluid w-100" src="img/service-1.jpg" style="object-fit: cover; min-height: 300px;" alt="Restomod Period Correct">
                                </div>
                                <div class="col-md-6">
                                    <h3 class="mb-3">Restomod Period Correct</h3>
                                    <p class="mb-4 text-muted">Spesialisasi utama Vertue Concept. Kami mengembalikan nuansa interior mobil lawas seperti saat pertama kali diluncurkan.</p>
                                    <a href="#booking" class="btn btn-primary py-2 px-4">Booking Sekarang <i class="fa fa-arrow-right ms-2 text-white"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab-pane-2">
                            <div class="row g-4 align-items-center">
                                <div class="col-md-6">
                                    <img class="img-fluid w-100" src="img/service-2.jpg" style="object-fit: cover; min-height: 300px;" alt="Pelapisan Jok Mobil">
                                </div>
                                <div class="col-md-6">
                                    <h3 class="mb-3">Perbaikan & Pelapisan Jok</h3>
                                    <p class="mb-4 text-muted">Meliputi jok (kulit/semi kulit), setir, dasbor, door trim, plafon, karpet. Perbaikan tepat sasaran tanpa harus mengganti seluruh bagian.</p>
                                    <a href="#booking" class="btn btn-primary py-2 px-4">Booking Sekarang <i class="fa fa-arrow-right ms-2 text-white"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab-pane-3">
                            <div class="row g-4 align-items-center">
                                <div class="col-md-6">
                                    <img class="img-fluid w-100" src="img/service-3.jpg" style="object-fit: cover; min-height: 300px;" alt="Vertue Clean Fogging Kabin">
                                </div>
                                <div class="col-md-6">
                                    <h3 class="mb-3">Vertue Clean - Fogging Kabin</h3>
                                    <p class="mb-4 text-muted">Sistem fogging kabin untuk membunuh bakteri, jamur, dan virus menggunakan cairan berstandar FDA. Menjadikan kabin lebih sehat.</p>
                                    <a href="#booking" class="btn btn-primary py-2 px-4">Booking Sekarang <i class="fa fa-arrow-right ms-2 text-white"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab-pane-4">
                            <div class="row g-4 align-items-center">
                                <div class="col-md-6">
                                    <img class="img-fluid w-100" src="img/service-4.jpg" style="object-fit: cover; min-height: 300px;" alt="Custom Interior Total">
                                </div>
                                <div class="col-md-6">
                                    <h3 class="mb-3">Custom Total Interior</h3>
                                    <p class="mb-4 text-muted">Mengerjakan interior private jet, helikopter, yacht, hingga kafe komersial dengan bahan standar khusus.</p>
                                    <a href="#booking" class="btn btn-primary py-2 px-4">Booking Sekarang <i class="fa fa-arrow-right ms-2 text-white"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Service End -->

    <!-- Booking Start -->
    <div id="booking" class="container-fluid bg-dark my-5 wow fadeInUp" data-wow-delay="0.1s" style="background: linear-gradient(rgba(17,17,17,0.8), rgba(17,17,17,0.8)), url('img/carousel-bg-2.jpg') center center no-repeat; background-size: cover;">
        <div class="container">
            <div class="row gx-5 align-items-center">
                <div class="col-lg-6 py-5">
                    <div class="py-5">
                        <h6 class="text-primary text-uppercase fw-bold mb-2" style="letter-spacing: 1px;">Reservasi</h6>
                        <h1 class="text-white mb-4">Booking Service Interior Mobil Sekarang</h1>
                        <p class="text-white text-opacity-75 mb-0" style="line-height: 1.8;">Konsultasikan kebutuhan interior mobil klasik atau modern Anda dengan tim ahli kami. Dapatkan hasil restomod period correct dengan material premium impor dan garansi terbaik.</p>
                    </div>
                </div>
                <div class="col-lg-6 py-5">
                    <div class="bg-white p-4 p-sm-5 wow zoomIn" data-wow-delay="0.3s">
                        <h3 class="text-dark mb-4 text-center">Formulir Booking</h3>
                        <form>
                            <div class="row g-3">
                                <div class="col-12 col-sm-6">
                                    <input type="text" class="form-control" placeholder="Nama Lengkap" required>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <input type="email" class="form-control" placeholder="Alamat Email" required>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <select class="form-select">
                                        <option selected disabled>Pilih Layanan</option>
                                        <option value="1">Restomod Period Correct</option>
                                        <option value="2">Perbaikan & Pelapisan Jok</option>
                                        <option value="3">Vertue Clean (Fogging)</option>
                                        <option value="4">Custom Total Interior</option>
                                    </select>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <input type="date" class="form-control" placeholder="Tanggal Service">
                                </div>
                                <div class="col-12">
                                    <textarea class="form-control" rows="4" placeholder="Permintaan Khusus (Tipe Mobil, Keluhan, Detail Kebutuhan...)"></textarea>
                                </div>
                                <div class="col-12 mt-4">
                                    <button class="btn btn-primary w-100 py-3 fs-5" type="submit">Kirim Pesan Booking</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Booking End -->

    <!-- Footer Start -->
    <div id="contact" class="container-fluid text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-4 col-md-6">
                    <h4 class="text-white mb-4">Hubungi Kami</h4>
                    <p class="mb-3"><i class="fa fa-map-marker-alt text-primary me-3"></i>Jl. Danau Sunter Utara Blok J12 No.6, Sunter Agung</p>
                    <p class="mb-3"><i class="fa fa-phone-alt text-primary me-3"></i>0889 9999 9977</p>
                    <p class="mb-3"><i class="fa fa-envelope text-primary me-3"></i>vertueconcept@gmail.com</p>
                    <div class="d-flex pt-3">
                        <a class="btn btn-outline-light btn-social me-2" href="https://instagram.com/vertueconcept" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a class="btn btn-outline-light btn-social me-2" href="https://facebook.com/vertueconcept" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social" href="https://www.youtube.com/results?search_query=vertue+concept" target="_blank"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-4">Jam Operasional</h4>
                    <h6 class="text-light mb-1">Senin - Sabtu:</h6>
                    <p class="mb-4 text-white text-opacity-50">09.00 - 17.00 WIB</p>
                    <h6 class="text-light mb-1">Minggu & Hari Besar:</h6>
                    <p class="mb-0 text-white text-opacity-50">Libur / Tutup</p>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h4 class="text-white mb-4">Tautan</h4>
                    <a class="btn btn-link d-block text-start px-0 text-decoration-none" href="#about">Tentang Kami</a>
                    <a class="btn btn-link d-block text-start px-0 text-decoration-none" href="#service">Layanan</a>
                    <a class="btn btn-link d-block text-start px-0 text-decoration-none" href="#booking">Booking</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-4">Newsletter</h4>
                    <p class="text-white text-opacity-75">Dapatkan info promo dan event terbaru dari Vertue Concept.</p>
                    
                    <!-- PERBAIKAN INPUT NEWSLETTER: Menggunakan input-group bawaan bootstrap -->
                    <div class="input-group mt-3" style="max-width: 600px; max-height: 300px;">
                        <input type="text" class="form-control border-0 py-3 px-3" placeholder="Alamat Email" id="newsletterEmail">
                        <button type="button" class="btn btn-primary px-4 fw-bold" id="btnNewsletter">DAFTAR</button>
                    </div>

                </div>
            </div>
        </div>
        <div class="container border-top border-secondary border-opacity-25 pt-4 pb-4">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0 text-white text-opacity-50">
                    &copy; <a class="text-primary text-decoration-none fw-bold" href="#">Vertue Concept</a>. All Right Reserved.
                </div>
                <div class="col-md-6 text-center text-md-end text-white text-opacity-50">
                    Designed By VERTUE TEAM
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top shadow-lg"><i class="bi bi-arrow-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>

    <script>
        // Init Wow JS
        if(typeof WOW !== 'undefined') {
            new WOW().init();
        }

        // --- FIX CAROUSEL: Paksa inisialisasi via Javascript ---
        document.addEventListener("DOMContentLoaded", function() {
            var myCarouselElement = document.querySelector('#header-carousel');
            if(myCarouselElement) {
                var carousel = new bootstrap.Carousel(myCarouselElement, {
                    interval: 3000,
                    ride: 'carousel',
                    wrap: true
                });
                carousel.cycle(); // Memaksa carousel untuk berputar
            }
        });
        
        // Sticky Navbar Fix
        window.addEventListener('scroll', function() {
            if(window.scrollY > 50) {
                document.querySelector('.navbar').classList.add('shadow');
            } else {
                document.querySelector('.navbar').classList.remove('shadow');
            }
        });

        // Scroll ke atas
        $(window).scroll(function () {
            if ($(this).scrollTop() > 300) {
                $('.back-to-top').fadeIn('slow');
            } else {
                $('.back-to-top').fadeOut('slow');
            }
        });
        $('.back-to-top').click(function () {
            $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
            return false;
        });
        
        // Active menu switcher
        const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
        const sections = document.querySelectorAll('div[id]');

        function changeActiveMenu() {
            let current = '';
            const scrollPos = window.scrollY + 200;
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                const sectionId = section.getAttribute('id');
                if(scrollPos >= sectionTop && scrollPos < sectionTop + sectionHeight && sectionId) {
                    current = sectionId;
                }
            });
            navLinks.forEach(link => {
                link.classList.remove('active');
                if(link.getAttribute('href') === `#${current}`) {
                    link.classList.add('active');
                }
            });
            if(window.scrollY < 100) {
                navLinks.forEach(link => {
                    link.classList.remove('active');
                    if(link.getAttribute('href') === '#beranda' || link.getAttribute('href') === 'index.php') {
                        link.classList.add('active');
                    }
                });
            }
        }
        window.addEventListener('scroll', changeActiveMenu);
        window.addEventListener('load', changeActiveMenu);
        
        // Form Alerts
        document.querySelector('#booking form')?.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('✅ Booking service telah berhasil terkirim. Tim Vertue akan segera menghubungi Anda!');
            this.reset();
        });
        
        document.getElementById('btnNewsletter')?.addEventListener('click', function() {
            let email = document.getElementById('newsletterEmail').value;
            if(email === '') {
                alert('⚠️ Silakan masukkan alamat email terlebih dahulu!');
            } else {
                alert('✅ Email Anda berhasil didaftarkan ke Newsletter kami!');
                document.getElementById('newsletterEmail').value = '';
            }
        });
    </script>
</body>
</html>