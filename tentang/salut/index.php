<!DOCTYPE html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>SALUT - Sentra Layanan Universitas Terbuka | UT Tana Toraja</title>
    <meta name="description" content="Informasi lengkap tentang Sentra Layanan Universitas Terbuka (SALUT), pusat layanan UT yang tersebar di seluruh Indonesia" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link
      rel="shortcut icon"
      type="image/x-icon"
      href="../../assets/img/favicon.png"
    />
    <!-- Place favicon.ico in the root directory -->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

    <!-- CSS here -->
    <link rel="stylesheet" href="../../assets/css/01-bootstrap.min.css" />
    <link rel="stylesheet" href="../../assets/css/02-all.min.css" />
    <link rel="stylesheet" href="../../assets/css/03-jquery.magnific-popup.css" />
    <link rel="stylesheet" href="../../assets/css/05-odometer.css" />
    <link rel="stylesheet" href="../../assets/css/06-swiper.min.css" />
    <link rel="stylesheet" href="../../assets/css/07-animate.min.css" />
    <link rel="stylesheet" href="../../assets/css/08-custom-animate.css" />
    <link rel="stylesheet" href="../../assets/css/09-slick.css" />
    <link rel="stylesheet" href="../../assets/css/10-icomoon.css" />
    <link rel="stylesheet" href="../../assets/vendor/custom-animate/custom-animate.css"/>
    <link rel="stylesheet" href="../../assets/vendor/jarallax/jarallax.css" />
    <link rel="stylesheet" href="../../assets/vendor/odometer/odometer.min.css" />
    <link rel="stylesheet" href="../../assets/fonts/gilroy/stylesheet.css" />
    
    <!-- Add Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />

    <link rel="stylesheet" href="../../assets/css/style.css" />
    <link rel="stylesheet" href="../../assets/css/color1.css" />
    <link rel="stylesheet" href="../../assets/css/responsive.css" />
    
    <!-- Custom styles for SALUT page -->
    <style>
        .salut-hero {
            position: relative;
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
                        url('../../assets/img/background/salut-bg.jpg');
            background-size: cover;
            background-position: center;
            padding: 120px 0;
            color: #fff;
            margin-bottom: 60px;
            border-radius: 15px;
            overflow: hidden;
        }
        
        .hero-pattern {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 80px;
            background: url('../../assets/img/shape/wave-pattern.png') repeat-x;
            background-size: contain;
            opacity: 0.2;
        }
        
        .salut-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            padding: 30px;
            margin-bottom: 30px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            height: 100%;
        }
        
        .salut-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.1);
        }
        
        .card-pattern {
            position: absolute;
            top: 0;
            right: 0;
            width: 150px;
            height: 150px;
            background: var(--thm-primary);
            opacity: 0.05;
            border-radius: 70% 30% 30% 70% / 60% 40% 60% 40%;
            z-index: 0;
        }
        
        .salut-icon {
            width: 80px;
            height: 80px;
            background: rgba(var(--primary-rgb), 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
        }
        
        .salut-icon i {
            font-size: 36px;
            color: var(--thm-primary);
        }
        
        .salut-title {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 15px;
            text-align: center;
        }
        
        .salut-text {
            color: #6c757d;
            text-align: center;
            margin-bottom: 25px;
        }
        
        .number-block {
            padding: 70px 0;
            background: linear-gradient(135deg, var(--thm-primary) 0%, var(--thm-secondary) 100%);
            color: #fff;
            border-radius: 15px;
            margin-bottom: 60px;
        }
        
        .counter-item {
            text-align: center;
        }
        
        .counter-icon {
            width: 70px;
            height: 70px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
        
        .counter-icon i {
            font-size: 30px;
            color: #fff;
        }
        
        .counter-number {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .counter-title {
            font-size: 18px;
            opacity: 0.9;
        }
        
        .mission-card {
            padding: 30px;
            border-radius: 15px;
            position: relative;
            overflow: hidden;
            height: 100%;
        }
        
        .mission-card.vision {
            background: linear-gradient(45deg, #0062cc, #0097ff);
            color: #fff;
        }
        
        .mission-card.mission {
            background: linear-gradient(45deg, #198754, #20c997);
            color: #fff;
        }
        
        .mission-card h3 {
            font-size: 28px;
            margin-bottom: 20px;
            position: relative;
        }
        
        .mission-card h3:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -10px;
            width: 60px;
            height: 3px;
            background: #fff;
            border-radius: 3px;
        }
        
        .mission-card ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .mission-card ul li {
            position: relative;
            padding-left: 30px;
            margin-bottom: 15px;
        }
        
        .mission-card ul li:before {
            content: '\f00c';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            position: absolute;
            left: 0;
            top: 2px;
        }
        
        .mission-card .shape {
            position: absolute;
            width: 150px;
            height: 150px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
        }
        
        .mission-card .shape-1 {
            top: -75px;
            right: -75px;
        }
        
        .mission-card .shape-2 {
            bottom: -75px;
            left: -75px;
        }
        
        .location-card {
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            margin-bottom: 30px;
            height: 100%;
        }
        
        .location-image {
            height: 200px;
            overflow: hidden;
        }
        
        .location-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .location-card:hover .location-image img {
            transform: scale(1.1);
        }
        
        .location-content {
            padding: 20px;
        }
        
        .location-content h4 {
            font-size: 18px;
            margin-bottom: 10px;
            color: var(--thm-black);
        }
        
        .location-content p {
            color: #6c757d;
            font-size: 14px;
            margin-bottom: 20px;
        }
        
        .location-contact {
            display: flex;
            align-items: center;
            color: #6c757d;
            margin-bottom: 10px;
            font-size: 14px;
        }
        
        .location-contact i {
            color: var(--thm-primary);
            margin-right: 10px;
            flex-shrink: 0;
        }
        
        .location-footer {
            border-top: 1px solid #eee;
            padding-top: 15px;
            display: flex;
            justify-content: space-between;
        }
        
        .location-footer a {
            display: inline-flex;
            align-items: center;
            color: var(--thm-primary);
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .location-footer a i {
            margin-left: 5px;
            transition: transform 0.3s ease;
        }
        
        .location-footer a:hover {
            color: var(--thm-secondary);
        }
        
        .location-footer a:hover i {
            transform: translateX(3px);
        }
        
        .map-container {
            height: 500px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }
        
        .salut-cta {
            background: linear-gradient(135deg, var(--thm-primary) 0%, var(--thm-secondary) 100%);
            padding: 50px 0;
            border-radius: 15px;
            position: relative;
            color: #fff;
            overflow: hidden;
            margin-top: 60px;
        }
        
        .salut-cta .shape {
            position: absolute;
            width: 200px;
            height: 200px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
        }
        
        .salut-cta .shape-1 {
            top: -100px;
            right: -100px;
        }
        
        .salut-cta .shape-2 {
            bottom: -100px;
            left: -100px;
        }
        
        .salut-cta h2 {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 20px;
        }
        
        .salut-cta p {
            font-size: 18px;
            opacity: 0.9;
            margin-bottom: 30px;
        }
        
        .btn-cta {
            background: #fff;
            color: var(--thm-primary);
            border: none;
            border-radius: 10px;
            padding: 15px 30px;
            font-size: 16px;
            font-weight: 700;
            transition: all 0.3s ease;
        }
        
        .btn-cta:hover {
            background: var(--thm-black);
            color: #fff;
            transform: translateY(-3px);
        }
        
        /* Animation classes */
        .floating {
            animation: floating 3s infinite ease-in-out;
        }
        
        @keyframes floating {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }
        
        @media (max-width: 767px) {
            .salut-hero {
                padding: 80px 0;
            }
            
            .counter-number {
                font-size: 36px;
            }
            
            .mission-card {
                margin-bottom: 30px;
            }
            
            .salut-cta h2 {
                font-size: 28px;
            }
        }
    </style>
  </head>

  <body class="body-gray-bg">
    <!-- preloader -->
    <div id="preloader">
      <div id="loading-center">
        <div class="loader">
          <div class="loader-outter"></div>
          <div class="loader-inner"></div>
        </div>
      </div>
    </div>
    <!-- preloader-end -->

    <div class="page-wrapper">
      <!-- Start Main Header One -->
      <header class="main-header main-header-one">
        <div class="main-header-one__top">
          <div class="container">
            <div class="main-header-one__top-inner">
              <div class="main-header-one__top-left">
                <div class="header-contact-info-one">
                  <ul>
                    <li>
                      <div class="icon">
                        <span class="icon-phone-call"></span>
                      </div>
                      <p><a href="tel:6281355619225">+6281355619225</a></p>
                    </li>
                    <li>
                      <div class="icon">
                        <span class="icon-email"></span>
                      </div>
                      <p>
                        <a href="mailto:info@uttoraja.com">info@uttoraja.com</a>
                      </p>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="main-header-one__top-right">
                <div class="header-social-link-one">
                  <ul class="clearfix">
                    <li>
                      <a href="https://www.facebook.com/uttoraja">
                        <i class="icon-facebook"></i>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <i class="icon-twitter"></i>
                      </a>
                    </li>
                    <li>
                      <a href="https://www.instagram.com/uttoraja/">
                        <i class="icon-instagram-symbol"></i>
                      </a>
                    </li>
                    <li>
                      <a href="https://www.youtube.com/@SALUTTanaToraja">
                        <i class="icon-vimeo"></i>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="main-header-one__bottom">
          <div id="sticky-header" class="menu-area">
            <div class="container">
              <div class="main-header-one__bottom-inner">
                <div class="main-header-one__bottom-left">
                  <div class="logo-box-one">
                    <a href="../../">
                      <img src="../../assets/img/resource/logo.png" alt="Logo" />
                    </a>
                  </div>
                </div>
                <div class="main-header-one__bottom-middle">
                  <div class="menu-area__inner">
                    <div class="mobile-nav-toggler">
                      <i class="fas fa-bars"></i>
                    </div>
                    <div class="menu-wrap">
                      <nav class="menu-nav">
                        <div class="navbar-wrap main-menu">
                          <ul class="navigation">
                            <li><a href="../../">Home</a></li>
                            <li class="menu-item-has-children">
                              <a href="#">Akademik</a>
                              <ul class="sub-menu">
                                <li><a href="../../informasi">Informasi Akademik</a></li>
                                <li><a href="../../kalender">Kalender Akademik</a></li>
                                <li><a href="../../jurusan.php">Program Studi</a></li>
                                <li><a href="../../biaya.php">Biaya Kuliah</a></li>
                              </ul>
                            </li>
                            <li class="menu-item-has-children">
                              <a href="#">Program</a>
                              <ul class="sub-menu">
                                <li><a href="../../rpl.php">Rekognisi Pembelajaran Lampau (RPL)</a></li>
                                <li><a href="../../reguler.php">Program Reguler</a></li>
                                <li><a href="../../pasca.php">Program Pascasarjana</a></li>
                              </ul>
                            </li>
                            <li class="menu-item-has-children">
                              <a href="#">Layanan</a>
                              <ul class="sub-menu">
                                <li><a href="../../administrasi/">Administrasi Akademik</a></li>
                                <li><a href="../../kegiatan">Kegiatan Akademik</a></li>
                                <li><a href="../../modul/">Pengambilan Modul</a></li>
                                <li><a href="../../legalisir/">Legalisir Ijazah</a></li>
                                <li><a href="../../suratketerangan/">Surat Keterangan</a></li>
                              </ul>
                            </li>
                            <li class="menu-item-has-children active">
                              <a href="#">Tentang</a>
                              <ul class="sub-menu">
                                <li><a href="../../tentang/">Universitas Terbuka</a></li>
                                <li class="active"><a href="../../tentang/salut/">SALUT</a></li>
                                <li><a href="../../tentang/saluttator">SALUT Tana Toraja</a></li>
                                <li><a href="../../tentang/kepalasalut">Pesan Kepala SALUT</a></li>
                              </ul>
                            </li>
                            <li><a href="../../galeri/">Galeri</a></li>
                            <li><a href="../../kontak">Kontak</a></li>
                          </ul>
                        </div>
                      </nav>
                    </div>
                  </div>
                </div>

                <div class="main-header-one__bottom-right">
                <div class="header-btn-box-one">
                  <a class="thm-btn" href="../../pendaftaran/">
                    <span class="txt">Daftar Sekarang <i class="bi bi-arrow-right-short"></i></span>
                  </a>
                </div>
              </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Start Mobile Menu -->
        <div class="mobile-menu">
          <nav class="menu-box">
            <div class="close-btn">
              <i class="fas fa-times"></i>
            </div>
            <div class="nav-logo">
              <a href="../../">
                <img src="../../assets/img/resource/mobile-menu-logo.png" alt="Logo" />
              </a>
            </div>
            <div class="menu-outer">
              <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
            </div>
            <div class="contact-info">
              <div class="icon-box"><span class="icon-phone-call"></span></div>
              <p><a href="tel:6281355619225">+6281355619225</a></p>
            </div>
            <div class="social-links">
              <ul class="clearfix list-wrap">
                <li>
                  <a href="https://www.facebook.com/uttoraja"><i class="fab fa-facebook-f"></i></a>
                </li>
                <li>
                  <a href="#"><i class="fab fa-twitter"></i></a>
                </li>
                <li>
                  <a href="https://www.instagram.com/uttoraja/"><i class="fab fa-instagram"></i></a>
                </li>
                <li>
                  <a href="https://www.youtube.com/@SALUTTanaToraja"><i class="fab fa-youtube"></i></a>
                </li>
              </ul>
            </div>
          </nav>
        </div>
        <div class="menu-backdrop"></div>
        <!-- End Mobile Menu -->
      </header>
      <!-- End Main Header One -->

      <!-- Start Page Header -->
      <section class="page-header">
        <div class="shape1 rotate-me">
          <img src="../../assets/img/shape/page-header-shape1.png" alt="" />
        </div>
        <div class="shape2 float-bob-x">
          <img src="../../assets/img/shape/page-header-shape2.png" alt="" />
        </div>
        <div class="container">
          <div class="page-header__inner">
            <h2>SENTRA LAYANAN UNIVERSITAS TERBUKA</h2>
            <ul class="thm-breadcrumb">
              <li>
                <a href="../../"><span class="fa fa-home"></span> Home</a>
              </li>
              <li><i class="icon-right-arrow-angle"></i></li>
              <li>Tentang</li>
              <li><i class="icon-right-arrow-angle"></i></li>
              <li class="color-base">SALUT</li>
            </ul>
          </div>
        </div>
      </section>
      <!-- End Page Header -->

      <!-- Hero Section -->
      <section class="pb-5">
        <div class="container">
          <div class="salut-hero wow fadeIn" data-wow-delay="0.1s">
            <div class="hero-pattern"></div>
            <div class="container text-center">
              <div class="row justify-content-center">
                <div class="col-lg-8">
                  <h1 class="display-5 fw-bold mb-4">Sentra Layanan Universitas Terbuka</h1>
                  <p class="lead fs-5 mb-4">Mitra Terdepan dalam Memberikan Layanan Pendidikan Tinggi Jarak Jauh di Seluruh Indonesia</p>
                  <a href="#about-salut" class="thm-btn">
                    <span class="txt">Pelajari Lebih Lanjut</span>
                    <i class="bi bi-arrow-down ms-2"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- About SALUT Section -->
      <section id="about-salut" class="py-5">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.1s">
              <div class="pe-lg-4">
                <div class="section-title mb-4">
                  <span class="subtitle">Tentang SALUT</span>
                  <h2>Apa itu SALUT?</h2>
                </div>
                <p>Sentra Layanan Universitas Terbuka (SALUT) adalah unit layanan Universitas Terbuka yang didirikan untuk memberikan akses yang lebih mudah bagi masyarakat dalam mendapatkan layanan pendidikan tinggi jarak jauh yang berkualitas.</p>
                <p>SALUT hadir di berbagai lokasi strategis di seluruh Indonesia untuk memastikan bahwa layanan UT dapat dijangkau oleh semua lapisan masyarakat, terutama di daerah yang jauh dari kantor UPBJJ-UT (Unit Program Belajar Jarak Jauh-Universitas Terbuka).</p>
                <p>Sebagai perpanjangan tangan dari Universitas Terbuka, SALUT berperan penting dalam memberikan informasi, layanan administrasi, dan dukungan akademik bagi para mahasiswa dan calon mahasiswa UT.</p>
                <div class="d-flex mt-4">
                  <div class="me-3 mt-1">
                    <i class="bi bi-check-circle-fill text-primary fs-4"></i>
                  </div>
                  <div>
                    <h5 class="mb-2">Layanan Terpadu</h5>
                    <p>Menyediakan berbagai layanan administrasi dan informasi akademik dalam satu lokasi</p>
                  </div>
                </div>
                <div class="d-flex mt-3">
                  <div class="me-3 mt-1">
                    <i class="bi bi-check-circle-fill text-primary fs-4"></i>
                  </div>
                  <div>
                    <h5 class="mb-2">Jangkauan Luas</h5>
                    <p>Tersebar di berbagai daerah untuk memudahkan akses masyarakat terhadap pendidikan tinggi</p>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-lg-6 mt-4 mt-lg-0 wow fadeInRight" data-wow-delay="0.2s">
              <div class="row g-4">
                <!-- Card 1 -->
                <div class="col-md-6">
                  <div class="salut-card">
                    <div class="card-pattern"></div>
                    <div class="salut-icon floating">
                      <i class="bi bi-info-circle-fill"></i>
                    </div>
                    <h3 class="salut-title">Informasi</h3>
                    <p class="salut-text">Menyediakan informasi lengkap tentang program studi, biaya, dan prosedur pendaftaran di Universitas Terbuka</p>
                  </div>
                </div>
                
                <!-- Card 2 -->
                <div class="col-md-6">
                  <div class="salut-card">
                    <div class="card-pattern"></div>
                    <div class="salut-icon floating">
                      <i class="bi bi-person-badge-fill"></i>
                    </div>
                    <h3 class="salut-title">Registrasi</h3>
                    <p class="salut-text">Membantu proses pendaftaran dan registrasi ulang bagi calon mahasiswa dan mahasiswa aktif</p>
                  </div>
                </div>
                
                <!-- Card 3 -->
                <div class="col-md-6">
                  <div class="salut-card">
                    <div class="card-pattern"></div>
                    <div class="salut-icon floating">
                      <i class="bi bi-book-fill"></i>
                    </div>
                    <h3 class="salut-title">Bahan Ajar</h3>
                    <p class="salut-text">Mendistribusikan modul dan bahan ajar kepada mahasiswa UT di wilayah sekitarnya</p>
                  </div>
                </div>
                
                <!-- Card 4 -->
                <div class="col-md-6">
                  <div class="salut-card">
                    <div class="card-pattern"></div>
                    <div class="salut-icon floating">
                      <i class="bi bi-laptop"></i>
                    </div>
                    <h3 class="salut-title">Tutorial</h3>
                    <p class="salut-text">Menyelenggarakan tutorial tatap muka dan fasilitas untuk tutorial online</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Statistics Section -->
      <section class="py-5">
        <div class="container">
          <div class="number-block wow fadeInUp" data-wow-delay="0.1s">
            <div class="row">
              <!-- Counter 1 -->
              <div class="col-6 col-md-3">
                <div class="counter-item">
                  <div class="counter-icon">
                    <i class="bi bi-geo-alt-fill"></i>
                  </div>
                  <div class="counter-number" data-count="87">0</div>
                  <div class="counter-title">Unit SALUT</div>
                </div>
              </div>
              
              <!-- Counter 2 -->
              <div class="col-6 col-md-3">
                <div class="counter-item">
                  <div class="counter-icon">
                    <i class="bi bi-people-fill"></i>
                  </div>
                  <div class="counter-number" data-count="150000">0</div>
                  <div class="counter-title">Mahasiswa Terlayani</div>
                </div>
              </div>
              
              <!-- Counter 3 -->
              <div class="col-6 col-md-3">
                <div class="counter-item">
                  <div class="counter-icon">
                    <i class="bi bi-globe2"></i>
                  </div>
                  <div class="counter-number" data-count="34">0</div>
                  <div class="counter-title">Provinsi</div>
                </div>
              </div>
              
              <!-- Counter 4 -->
              <div class="col-6 col-md-3">
                <div class="counter-item">
                  <div class="counter-icon">
                    <i class="bi bi-building-fill"></i>
                  </div>
                  <div class="counter-number" data-count="12">0</div>
                  <div class="counter-title">Tahun Pengalaman</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Vision & Mission Section -->
      <section class="py-5">
        <div class="container">
          <div class="section-title text-center mb-5">
            <span class="subtitle">Visi & Misi</span>
            <h2>SALUT Universitas Terbuka</h2>
            <p class="mx-auto" style="max-width: 700px;">Komitmen kami dalam memberikan layanan pendidikan jarak jauh yang berkualitas</p>
          </div>
          
          <div class="row">
            <!-- Vision Card -->
            <div class="col-lg-6 mb-4 mb-lg-0 wow fadeInLeft" data-wow-delay="0.1s">
              <div class="mission-card vision">
                <div class="shape shape-1"></div>
                <div class="shape shape-2"></div>
                <h3>Visi</h3>
                <p>Menjadi pusat layanan terdepan dalam penyediaan akses pendidikan tinggi berkualitas melalui sistem pendidikan jarak jauh di seluruh Indonesia.</p>
                <ul class="mt-4">
                  <li>Terjangkau oleh seluruh lapisan masyarakat</li>
                  <li>Penyedia informasi dan layanan yang komprehensif</li>
                  <li>Pusat distribusi bahan ajar yang efektif</li>
                  <li>Penunjang kegiatan akademik yang berkualitas</li>
                </ul>
              </div>
            </div>
            
            <!-- Mission Card -->
            <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.2s">
              <div class="mission-card mission">
                <div class="shape shape-1"></div>
                <div class="shape shape-2"></div>
                <h3>Misi</h3>
                <ul>
                  <li>Memberikan akses pendidikan tinggi yang lebih luas kepada masyarakat melalui pendidikan jarak jauh</li>
                  <li>Menyediakan informasi yang akurat tentang program pendidikan di Universitas Terbuka</li>
                  <li>Memfasilitasi proses administrasi akademik yang efisien dan tepat waktu</li>
                  <li>Mendistribusikan bahan ajar dan sumber belajar kepada mahasiswa</li>
                  <li>Menyelenggarakan tutorial tatap muka dan mendukung tutorial online</li>
                  <li>Membangun jaringan kerjasama dengan berbagai instansi untuk perluasan jangkauan layanan</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Services Section -->
      <section class="py-5 bg-light">
        <div class="container">
          <div class="section-title text-center mb-5">
            <span class="subtitle">Layanan</span>
            <h2>Layanan yang Disediakan</h2>
            <p class="mx-auto" style="max-width: 700px;">SALUT menyediakan berbagai layanan untuk mendukung proses pendidikan jarak jauh Universitas Terbuka</p>
          </div>
          
          <div class="row g-4">
            <!-- Service 1 -->
            <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.1s">
              <div class="salut-card">
                <div class="card-pattern"></div>
                <div class="salut-icon">
                  <i class="bi bi-info-square-fill"></i>
                </div>
                <h3 class="salut-title">Informasi Akademik</h3>
                <p class="salut-text">Menyediakan informasi lengkap tentang program studi, kurikulum, jadwal akademik, dan persyaratan untuk menyelesaikan studi di Universitas Terbuka.</p>
                <div class="text-center">
                  <a href="../../informasi.php" class="btn btn-outline-primary">Selengkapnya</a>
                </div>
              </div>
            </div>
            
            <!-- Service 2 -->
            <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.2s">
              <div class="salut-card">
                <div class="card-pattern"></div>
                <div class="salut-icon">
                  <i class="bi bi-person-plus-fill"></i>
                </div>
                <h3 class="salut-title">Pendaftaran</h3>
                <p class="salut-text">Membantu proses pendaftaran mahasiswa baru dan registrasi ulang bagi mahasiswa aktif, termasuk pembayaran biaya kuliah melalui mitra bank.</p>
                <div class="text-center">
                  <a href="../../pendaftaran/" class="btn btn-outline-primary">Selengkapnya</a>
                </div>
              </div>
            </div>
            
            <!-- Service 3 -->
            <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.3s">
              <div class="salut-card">
                <div class="card-pattern"></div>
                <div class="salut-icon">
                  <i class="bi bi-book-half"></i>
                </div>
                <h3 class="salut-title">Distribusi Modul</h3>
                <p class="salut-text">Menerima dan mendistribusikan modul cetak kepada mahasiswa serta memberikan akses dan informasi tentang modul digital.</p>
                <div class="text-center">
                  <a href="../../modul/" class="btn btn-outline-primary">Selengkapnya</a>
                </div>
              </div>
            </div>
            
            <!-- Service 4 -->
            <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.4s">
              <div class="salut-card">
                <div class="card-pattern"></div>
                <div class="salut-icon">
                  <i class="bi bi-person-video3"></i>
                </div>
                <h3 class="salut-title">Tutorial</h3>
                <p class="salut-text">Menyelenggarakan tutorial tatap muka untuk mata kuliah tertentu dan menyediakan fasilitas untuk akses tutorial online.</p>
                <div class="text-center">
                  <a href="../../kegiatan.php" class="btn btn-outline-primary">Selengkapnya</a>
                </div>
              </div>
            </div>
            
            <!-- Service 5 -->
            <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.5s">
              <div class="salut-card">
                <div class="card-pattern"></div>
                <div class="salut-icon">
                  <i class="bi bi-pencil-square"></i>
                </div>
                <h3 class="salut-title">Ujian</h3>
                <p class="salut-text">Menjadi tempat pelaksanaan ujian akhir semester (UAS) dan ujian online untuk mahasiswa di wilayahnya.</p>
                <div class="text-center">
                  <a href="../../kegiatan.php" class="btn btn-outline-primary">Selengkapnya</a>
                </div>
              </div>
            </div>
            
            <!-- Service 6 -->
            <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.6s">
              <div class="salut-card">
                <div class="card-pattern"></div>
                <div class="salut-icon">
                  <i class="bi bi-award-fill"></i>
                </div>
                <h3 class="salut-title">Legalisir Dokumen</h3>
                <p class="salut-text">Melayani legalisir ijazah, transkrip nilai, dan dokumen akademik lainnya bagi alumni Universitas Terbuka.</p>
                <div class="text-center">
                  <a href="../../legalisir/" class="btn btn-outline-primary">Selengkapnya</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- CTA Section -->
      <section class="py-5">
        <div class="container">
          <div class="salut-cta text-center wow fadeInUp" data-wow-delay="0.1s">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="row justify-content-center position-relative z-index-1">
              <div class="col-lg-8">
                <h2>Mulai Perjalanan Pendidikan Anda</h2>
                <p>Bergabunglah dengan Universitas Terbuka dan raih gelar akademik sesuai dengan jadwal dan kecepatan belajar Anda</p>
                <a href="../../pendaftaran/" class="btn-cta">Daftar Sekarang <i class="bi bi-arrow-right ms-2"></i></a>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Footer Three -->
      <footer class="footer-three">
        <div class="footer-main footer-main__three">
          <div class="footer-three__shape1">
            <img src="../../assets/img/shape/footer-three__shape1.png" alt="shapes" />
          </div>
          <div class="footer-three__shape2">
            <img src="../../assets/img/shape/footer-three__shape2.png" alt="shapes" />
          </div>
          <div class="container">
            <div class="footer-main__inner footer-main-two__inner footer-main-three__inner">
              <div class="row">
                <!-- Single Footer Widget -->
                <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".1s">
                  <div class="single-footer-widget single-footer-widget-style2">
                    <div class="title">
                      <h3>Bantuan &amp; Dukungan</h3>
                    </div>
                    <div class="single-footer-widget-box single-footer-widget__about single-footer-widget__about--2">
                      <div class="text">
                        <p>
                          Butuh bantuan dan dukungan dalam perkuliahan di UT?
                        </p>
                      </div>
                      <ul class="clearfix">
                        <li>
                          <div class="icon">
                            <span class="icon-pin"></span>
                          </div>
                          <p>Jl. Buntu Pantan No. 22, Makale, Tana Toraja</p>
                        </li>
                        <li>
                          <div class="icon">
                            <span class="icon-mail-inbox-app"></span>
                          </div>
                          <p>
                            <a href="mailto:saluttanatoraja@gmail.com">saluttanatoraja@gmail.com</a>
                          </p>
                        </li>
                        <li>
                          <div class="icon">
                            <span class="icon-phone-call"></span>
                          </div>
                          <p>
                            <a href="tel:6281355619225">+62 813-5561-9225</a>
                          </p>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <!-- End Single Footer Widget -->

                <!-- Single Footer Widget -->
                <div class="col-xl-2 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".2s">
                  <div class="single-footer-widget single-footer-widget-style2 ml55">
                    <div class="title">
                      <h3>Link Cepat</h3>
                    </div>
                    <div class="single-footer-widget-box single-footer-widget__links single-footer-widget__links-style2">
                      <ul class="clearfix">
                        <li>
                          <p><a href="../../tentang/">Tentang UT</a></p>
                        </li>
                        <li>
                          <p><a href="../../informasi.php">Informasi Akademik</a></p>
                        </li>
                        <li>
                          <p><a href="../../administrasi/">Administrasi</a></p>
                        </li>
                        <li>
                          <p><a href="../../tentang/kepalasalut.php">Sapaan dari Kepala SALUT</a></p>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <!-- End Single Footer Widget -->

                <!-- Single Footer Widget -->
                <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".3s">
                  <div class="single-footer-widget single-footer-widget-style2 ml50">
                    <div class="title">
                      <h3>Layanan Kami</h3>
                    </div>
                    <div class="single-footer-widget-box single-footer-widget__links single-footer-widget__links-style2">
                      <ul class="clearfix">
                        <li>
                          <p>
                            <a href="../../informasi.php">Informasi Akademik</a>
                          </p>
                        </li>
                        <li>
                          <p>
                            <a href="../../administrasi/">Administrasi Akademik</a>
                          </p>
                        </li>
                        <li>
                          <p>
                            <a href="../../kegiatan.php">Kegiatan</                          </p>
                        </li>
                        <li>
                          <p>
                            <a href="../../modul/">Pengambilan Modul</a>
                          </p>
                        </li>
                        <li>
                          <p>
                            <a href="../../suratketerangan/">Surat Keterangan</a>
                          </p>
                        </li>
                        <li>
                          <p>
                            <a href="../../legalisir/">Legalisir Ijazah</a>
                          </p>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <!-- End Single Footer Widget -->

                <!-- Single Footer Widget -->
                <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".4s">
                  <div class="single-footer-widget single-footer-widget-style2">
                    <div class="title">
                      <h3>SALUT Universitas Terbuka</h3>
                    </div>
                    <div class="single-footer-widget-box single-footer-widget__newsletter">
                      <p>Berlangganan newsletter kami untuk mendapatkan informasi terbaru tentang SALUT dan Universitas Terbuka.</p>
                      <form class="footer__newsletter-form">
                        <div class="footer__newsletter-input">
                          <input type="email" placeholder="Email Anda" name="email">
                          <button type="submit">Berlangganan</button>
                        </div>
                      </form>
                      <div class="footer__newsletter-bottom">
                        <div class="footer__newsletter-bottom-left">
                          <h4>Ikuti Kami:</h4>
                        </div>
                        <div class="footer__newsletter-bottom-right">
                          <div class="footer-social-link-two">
                            <a href="https://www.facebook.com/uttoraja"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="https://www.instagram.com/uttoraja/"><i class="fab fa-instagram"></i></a>
                            <a href="https://www.youtube.com/@SALUTTanaToraja"><i class="fab fa-youtube"></i></a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- End Single Footer Widget -->
              </div>
            </div>
          </div>
          
          <!-- Start Footer Bottom -->
          <div class="footer-bottom footer-bottom-two footer-bottom-three">
            <div class="container">
              <div class="footer-bottom__inner footer-bottom__two-inner footer-bottom__three-inner">
                <div class="copyright-text text-center">
                  <p>
                    Copyright © 2024 Sentra Layanan Universitas Terbuka (SALUT) Tana Toraja by
                    <a href="https://themeforest.net/user/thememx">Thememx.</a>
                    All Rights Reserved
                  </p>
                </div>
              </div>
            </div>
          </div>
          <!-- End Footer Bottom -->
        </div>
      </footer>
      <!-- End Footer Three -->
    </div>

    <!-- JS here -->
    <script src="../../assets/js/jquery-3.6.0.min.js"></script>
    <script src="../../assets/js/01-ajax-form.js"></script>
    <script src="../../assets/js/03-jquery.appear.js"></script>
    <script src="../../assets/js/04-swiper.min.js"></script>
    <script src="../../assets/js/05-jquery.odometer.min.js"></script>
    <script src="../../assets/js/06-jquery.magnific-popup.min.js"></script>
    <script src="../../assets/js/08-slick.min.js"></script>
    <script src="../../assets/js/09-wow.min.js"></script>
    <script src="../../assets/js/10-jquery.circleType.js"></script>
    <script src="../../assets/js/11-jquery.lettering.min.js"></script>
    <script src="../../assets/js/12-TweenMax.min.js"></script>
    <script src="../../assets/vendor/jarallax/jarallax.min.js"></script>
    <script src="../../assets/vendor/marquee/marquee.min.js"></script>
    <script src="../../assets/vendor/odometer/odometer.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/main.js"></script>
    
    <script>
      // Initialize WOW animations
      new WOW().init();
      
      $(document).ready(function() {
        // Smooth scroll for anchor links
        $('a[href^="#"]').on('click', function(event) {
          var target = $(this.getAttribute('href'));
          if(target.length) {
            event.preventDefault();
            $('html, body').stop().animate({
              scrollTop: target.offset().top - 80
            }, 800);
          }
        });
        
        // Counter animation
        $('.counter-number').each(function() {
          var $this = $(this);
          var countTo = $this.attr('data-count');
          
          $({ Counter: 0 }).animate({
            Counter: countTo
          }, {
            duration: 2000,
            easing: 'swing',
            step: function() {
              $this.text(Math.floor(this.Counter).toLocaleString());
            },
            complete: function() {
              $this.text(parseInt(countTo).toLocaleString());
            }
          });
        });
        
        // Add floating animation to elements
        $('.salut-icon').addClass('floating');
        
        // Image galleries with magnific popup
        $('.location-image').magnificPopup({
          delegate: 'a',
          type: 'image',
          gallery: {
            enabled: true
          }
        });
      });
    </script>
  </body>
</html>
