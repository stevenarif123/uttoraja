<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>Jadwal Perkuliahan | Sentra Layanan Universitas Terbuka Tana Toraja</title>
  <meta name="description" content="Jadwal perkuliahan lengkap Universitas Terbuka tahun akademik 2024/2025 - termasuk registrasi, tutorial, ujian, dan wisuda" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <link
    rel="shortcut icon"
    type="image/x-icon"
    href="serve-image.php?img=assets/img/favicon.png" />
  <!-- Place favicon.ico in the root directory -->

  <link
    href="https://fonts.googleapis.com/css2?family=Inter+Tight:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet" />

  <!-- CSS here -->
  <link rel="stylesheet" href="assets/css/01-bootstrap.min.css" />
  <link rel="stylesheet" href="assets/css/02-all.min.css" />
  <link rel="stylesheet" href="assets/css/03-jquery.magnific-popup.css" />
  <link rel="stylesheet" href="assets/css/04-nice-select.css" />
  <link rel="stylesheet" href="assets/css/05-odometer.css" />
  <link rel="stylesheet" href="assets/css/06-swiper.min.css" />
  <link rel="stylesheet" href="assets/css/07-animate.min.css" />
  <link rel="stylesheet" href="assets/css/08-custom-animate.css" />
  <link rel="stylesheet" href="assets/css/09-slick.css" />
  <link rel="stylesheet" href="assets/css/10-icomoon.css" />
  <link rel="stylesheet" href="assets/vendor/custom-animate/custom-animate.css" />
  <link rel="stylesheet" href="assets/vendor/jarallax/jarallax.css" />
  <link rel="stylesheet" href="assets/vendor/odometer/odometer.min.css" />
  <link rel="stylesheet" href="assets/fonts/gilroy/stylesheet.css" />

  <link rel="stylesheet" href="assets/css/style.css" />
  <link rel="stylesheet" href="assets/css/responsive.css" />
  <link rel="stylesheet" href="assets/css/customstyles.css" />

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  
  <style>
    .jadwal-header {
      background: linear-gradient(135deg, #0062cc, #0097e6);
      padding: 30px;
      border-radius: 15px;
      margin-bottom: 25px;
      color: #fff;
      position: relative;
      overflow: hidden;
      box-shadow: 0 10px 25px rgba(0, 98, 204, 0.2);
    }
    
    .jadwal-header h2 {
      font-size: 28px;
      margin-bottom: 10px;
      color: #fff;
    }
    
    .jadwal-header p {
      font-size: 16px;
      color: rgba(255, 255, 255, 0.9);
      margin-bottom: 0;
    }
    
    .jadwal-filter {
      background-color: #fff;
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 25px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    
    .jadwal-filter .form-select {
      border-radius: 30px;
      padding: 10px 20px;
      border: 2px solid #eee;
      font-size: 15px;
    }
    
    .jadwal-filter .form-select:focus {
      border-color: #0062cc;
      box-shadow: 0 0 0 0.25rem rgba(0, 98, 204, 0.15);
    }
    
    .jadwal-table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
      margin-bottom: 2rem;
      background: #fff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .jadwal-table thead th {
      background: #0062cc;
      color: #fff;
      font-weight: 600;
      padding: 15px;
      text-align: center;
      border: none;
      position: sticky;
      top: 0;
      z-index: 10;
    }
    
    .jadwal-table tbody td {
      padding: 12px 15px;
      border-bottom: 1px solid #eee;
      transition: all 0.3s ease;
      font-size: 14px;
    }
    
    .jadwal-table tbody tr:hover td {
      background-color: #f0f7ff;
    }
    
    .jadwal-table tbody tr:last-child td {
      border-bottom: none;
    }
    
    .jadwal-table td:first-child,
    .jadwal-table td:last-child {
      font-weight: 500;
    }
    
    .jadwal-table td:nth-child(2) {
      text-align: center;
      font-weight: 500;
    }
    
    .category-pill {
      display: inline-block;
      padding: 5px 10px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 500;
      margin-bottom: 5px;
    }
    
    .category-pendaftaran {
      background-color: #e3f2fd;
      color: #0062cc;
    }
    
    .category-akademik {
      background-color: #e8f5e9;
      color: #00b894;
    }
    
    .category-ujian {
      background-color: #fff3e0;
      color: #f39c12;
    }
    
    .category-wisuda {
      background-color: #f3e5f5;
      color: #9c27b0;
    }
    
    .jadwal-section {
      margin-bottom: 30px;
    }
    
    .jadwal-section-title {
      font-size: 20px;
      padding-bottom: 10px;
      border-bottom: 2px solid #0062cc;
      margin-bottom: 20px;
    }
    
    .jadwal-back {
      position: relative;
      display: inline-block;
      padding: 10px 20px;
      background-color: #f8f9fa;
      color: #505050;
      border-radius: 30px;
      font-weight: 500;
      margin-top: 15px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
      transition: all 0.3s ease;
    }
    
    .jadwal-back:hover {
      background-color: #e9ecef;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    }
    
    .jadwal-back i {
      margin-right: 8px;
    }
    
    .highlight-row {
      background-color: #f0f7ff !important;
      border-left: 3px solid #0062cc;
    }
    
    .table-responsive {
      max-height: 600px;
      overflow-y: auto;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
      border-radius: 10px;
    }
    
    .empty-message {
      text-align: center;
      padding: 40px 20px;
      color: #6c757d;
      font-size: 16px;
      background-color: #f8f9fa;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
      margin: 20px 0;
    }
    
    .empty-message i {
      font-size: 48px;
      display: block;
      margin-bottom: 15px;
      color: #0062cc;
      opacity: 0.5;
    }
    
    .jadwal-content-section {
      padding: 50px 0 40px;
    }
    
    .jadwal-notes {
      margin-top: 25px !important;
    }
    
    @media (max-width: 767px) {
      .jadwal-header {
        padding: 20px;
      }
      
      .jadwal-header h2 {
        font-size: 24px;
      }
      
      .jadwal-table {
        border-radius: 0;
      }
      
      .jadwal-table thead {
        display: none;
      }
      
      .jadwal-table tbody td {
        display: block;
        text-align: right;
        padding: 10px 15px;
      }
      
      .jadwal-table tbody td:before {
        content: attr(data-label);
        float: left;
        font-weight: bold;
        color: #505050;
      }
      
      .jadwal-table tbody tr {
        display: block;
        border-bottom: 2px solid #e3f2fd;
        margin-bottom: 15px;
      }
      
      .jadwal-table td:first-child,
      .jadwal-table td:last-child {
        text-align: right;
      }
      
      .jadwal-table td:nth-child(2) {
        text-align: right;
      }
      
      .jadwal-filter .form-select {
        margin-bottom: 10px;
      }
      
      .jadwal-content-section {
        padding: 40px 0 30px;
      }
    }
  </style>
</head>

<body class="body-gray-bg">
  <!--Start Preloader -->
  <div id="preloader" class="alt">
    <div id="loading-center">
      <div class="loader">
        <div class="loader-outter"></div>
        <div class="loader-inner"></div>
      </div>
    </div>
  </div>
  <!--End Preloader-->

  <div class="page-wrapper">
    <!--Start Main Header One -->
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
                  <a href="./">
                    <img src="serve-image.php?img=assets/img/resource/logo.png" alt="Logo" />
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
                          <li><a href="./">Home</a></li>
                          <li class="menu-item-has-children">
                            <a href="#">Akademik</a>
                            <ul class="sub-menu">
                              <li><a href="./informasi">Informasi Akademik</a></li>
                              <li><a href="./kalender">Kalender Akademik</a></li>
                              <li><a href="./jurusan.php">Program Studi</a></li>
                              <li><a href="./biaya.php">Biaya Kuliah</a></li>
                            </ul>
                          </li>
                          <li class="menu-item-has-children">
                            <a href="#">Program</a>
                            <ul class="sub-menu">
                              <li><a href="./rpl.php">Rekognisi Pembelajaran Lampau (RPL)</a></li>
                              <li><a href="./reguler.php">Program Reguler</a></li>
                              <li><a href="./pasca.php">Program Pascasarjana</a></li>
                            </ul>
                          </li>
                          <li class="menu-item-has-children">
                            <a href="#">Layanan</a>
                            <ul class="sub-menu">
                              <li><a href="./administrasi/">Administrasi Akademik</a></li>
                              <li><a href="./kegiatan">Kegiatan Akademik</a></li>
                              <li><a href="./modul/">Pengambilan Modul</a></li>
                              <li><a href="./legalisir/">Legalisir Ijazah</a></li>
                              <li><a href="./suratketerangan/">Surat Keterangan</a></li>
                            </ul>
                          </li>
                          <li class="menu-item-has-children">
                            <a href="#">Tentang</a>
                            <ul class="sub-menu">
                              <li><a href="./tentang/">Universitas Terbuka</a></li>
                              <li><a href="./tentang/salut/">SALUT</a></li>
                              <li><a href="./tentang/saluttator">SALUT Tana Toraja</a></li>
                              <li><a href="./tentang/kepalasalut">Pesan Kepala SALUT</a></li>
                            </ul>
                          </li>
                          <li><a href="./galeri/">Galeri</a></li>
                          <li><a href="./kontak">Kontak</a></li>
                        </ul>
                      </div>
                    </nav>
                  </div>
                </div>
              </div>

              <div class="main-header-one__bottom-right">
                <div class="header-btn-box-one">
                  <a class="thm-btn" href="./pendaftaran/">
                    <span class="txt">Daftar Sekarang <i class="bi bi-arrow-right-short"></i></span>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!--Start Mobile Menu  -->
      <div class="mobile-menu">
        <nav class="menu-box">
          <div class="close-btn">
            <i class="fas fa-times"></i>
          </div>
          <div class="nav-logo">
            <a href="./">
              <img
                src="serve-image.php?img=assets/img/resource/mobile-menu-logo.png"
                alt="Logo" />
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
    <!--End Main Header One -->

    <!--Start Page Header-->
    <section class="page-header">
      <div class="shape1 rotate-me">
        <img src="assets/img/shape/page-header-shape1.png" alt="" />
      </div>
      <div class="shape2 float-bob-x">
        <img src="assets/img/shape/page-header-shape2.png" alt="" />
      </div>
      <div class="container">
        <div class="page-header__inner">
          <h2>Jadwal Perkuliahan</h2>
          <ul class="thm-breadcrumb">
            <li>
              <a href="./"><span class="fa fa-home"></span> Home</a>
            </li>
            <li><i class="icon-right-arrow-angle"></i></li>
            <li class="color-base">Jadwal Perkuliahan</li>
          </ul>
        </div>
      </div>
    </section>
    <!--End Page Header-->

    <!-- Start Jadwal Content Section -->
    <section class="jadwal-content-section py-5">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-10">
            <!-- Jadwal Header -->
            <div class="jadwal-header wow fadeInUp" data-wow-delay="0.1s">
              <h2>Jadwal Akademik Universitas Terbuka 📅</h2>
              <p>Jadwal lengkap kegiatan akademik Universitas Terbuka untuk tahun akademik 2024/2025. Jadwal ini mencakup pendaftaran mahasiswa baru, registrasi mata kuliah, tutorial, ujian, dan kegiatan akademik lainnya.</p>
              <a href="./informasi.php" class="jadwal-back">
                <i class="bi bi-arrow-left"></i> Kembali ke Informasi Akademik
              </a>
            </div>

            <!-- Filter Section -->
            <div class="jadwal-filter wow fadeInUp" data-wow-delay="0.2s">
              <div class="row align-items-end">
                <div class="col-lg-4 col-md-6 mb-3 mb-lg-0">
                  <label for="semesterFilter" class="form-label">Semester</label>
                  <select class="form-select" id="semesterFilter">
                    <option value="all">Semua Semester</option>
                    <option value="2024/2025 GANJIL">2024/2025 Ganjil</option>
                    <option value="2024/2025 GENAP">2024/2025 Genap</option>
                  </select>
                </div>
                <div class="col-lg-4 col-md-6 mb-3 mb-lg-0">
                  <label for="categoryFilter" class="form-label">Kategori Kegiatan</label>
                  <select class="form-select" id="categoryFilter">
                    <option value="all">Semua Kategori</option>
                    <option value="pendaftaran">Pendaftaran</option>
                    <option value="akademik">Proses Akademik</option>
                    <option value="ujian">Ujian</option>
                    <option value="wisuda">Wisuda</option>
                  </select>
                </div>
                <div class="col-lg-4 col-md-12">
                  <label for="searchInput" class="form-label">Pencarian</label>
                  <input type="text" class="form-control" id="searchInput" placeholder="Cari kegiatan...">
                </div>
              </div>
            </div>

            <!-- Jadwal Table -->
            <div class="table-responsive wow fadeInUp" data-wow-delay="0.3s">
              <table class="jadwal-table" id="jadwalTable">
                <thead>
                  <tr>
                    <th width="25%">2024/2025 GANJIL</th>
                    <th width="50%">KEGIATAN</th>
                    <th width="25%">2024/2025 GENAP</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Pendaftaran Mahasiswa Baru -->
                  <tr data-category="pendaftaran">
                    <td data-label="2024/2025 GANJIL"></td>
                    <td data-label="KEGIATAN">
                      <span class="category-pill category-pendaftaran">Pendaftaran</span>
                      <strong>Pendaftaran Mahasiswa Baru</strong>
                    </td>
                    <td data-label="2024/2025 GENAP"></td>
                  </tr>
                  <tr data-category="pendaftaran">
                    <td data-label="2024/2025 GANJIL">6 Mei – 26 Agustus 2024</td>
                    <td data-label="KEGIATAN">– Jalur Umum (Non RPL/Non Alih Kredit)</td>
                    <td data-label="2024/2025 GENAP">17 Oktober 2024 – 12 Februari 2025</td>
                  </tr>
                  <tr data-category="pendaftaran">
                    <td data-label="2024/2025 GANJIL">6 Mei – 19 Agustus 2024</td>
                    <td data-label="KEGIATAN">– Jalur Rekognisi Pembelajaran Lampau (RPL)/Alih Kredit</td>
                    <td data-label="2024/2025 GENAP">18 November 2024 – 22 Januari 2025</td>
                  </tr>
                  
                  <!-- Pembayaran LIP Admisi -->
                  <tr data-category="pendaftaran">
                    <td data-label="2024/2025 GANJIL"></td>
                    <td data-label="KEGIATAN">
                      <span class="category-pill category-pendaftaran">Pendaftaran</span>
                      <strong>Pembayaran LIP Admisi Mahasiswa Baru</strong>
                    </td>
                    <td data-label="2024/2025 GENAP"></td>
                  </tr>
                  <tr data-category="pendaftaran">
                    <td data-label="2024/2025 GANJIL">6 Mei – 27 Agustus 2024</td>
                    <td data-label="KEGIATAN">– Jalur Umum (Non RPL/Non Alih Kredit)</td>
                    <td data-label="2024/2025 GENAP">17 Oktober 2024 – 19 Februari 2025</td>
                  </tr>
                  <tr data-category="pendaftaran">
                    <td data-label="2024/2025 GANJIL">6 Mei – 20 Agustus 2024</td>
                    <td data-label="KEGIATAN">– Jalur Rekognisi Pembelajaran Lampau (RPL)/Alih Kredit</td>
                    <td data-label="2024/2025 GENAP">18 November 2024 – 30 Januari 2025</td>
                  </tr>
                  
                  <!-- Unggah Berkas -->
                  <tr data-category="pendaftaran">
                    <td data-label="2024/2025 GANJIL"></td>
                    <td data-label="KEGIATAN">
                      <span class="category-pill category-pendaftaran">Pendaftaran</span>
                      <strong>Unggah Berkas Mahasiswa Baru</strong>
                    </td>
                    <td data-label="2024/2025 GENAP"></td>
                  </tr>
                  <tr data-category="pendaftaran">
                    <td data-label="2024/2025 GANJIL">6 Mei – 29 Agustus 2024</td>
                    <td data-label="KEGIATAN">– Jalur Umum (Non RPL/Non Alih Kredit)</td>
                    <td data-label="2024/2025 GENAP">17 Oktober 2024 – 26 Februari 2025</td>
                  </tr>
                  <tr data-category="pendaftaran">
                    <td data-label="2024/2025 GANJIL">6 Mei – 21 Agustus 2024</td>
                    <td data-label="KEGIATAN">– Jalur Rekognisi Pembelajaran Lampau (RPL)/Alih Kredit</td>
                    <td data-label="2024/2025 GENAP">18 November 2024 – 26 Februari 2025</td>
                  </tr>
                  
                  <!-- Registrasi Mata Kuliah -->
                  <tr data-category="pendaftaran">
                    <td data-label="2024/2025 GANJIL">6 Mei – 5 September 2024</td>
                    <td data-label="KEGIATAN">
                      <span class="category-pill category-pendaftaran">Pendaftaran</span>
                      <strong>Registrasi Mata Kuliah</strong>
                    </td>
                    <td data-label="2024/2025 GENAP">17 Oktober 2024 – 26 Februari 2025</td>
                  </tr>
                  
                  <!-- Pembayaran Uang Kuliah -->
                  <tr data-category="pendaftaran">
                    <td data-label="2024/2025 GANJIL"></td>
                    <td data-label="KEGIATAN">
                      <span class="category-pill category-pendaftaran">Pendaftaran</span>
                      <strong>Pembayaran Uang Kuliah</strong>
                    </td>
                    <td data-label="2024/2025 GENAP"></td>
                  </tr>
                  <tr data-category="pendaftaran">
                    <td data-label="2024/2025 GANJIL">6 Mei – 11 September 2024</td>
                    <td data-label="KEGIATAN">– Jalur Umum (Non RPL/Non Alih Kredit)</td>
                    <td data-label="2024/2025 GENAP">17 Oktober 2024 – 5 Maret 2025</td>
                  </tr>
                  <tr data-category="pendaftaran">
                    <td data-label="2024/2025 GANJIL">6 Mei – 11 September 2024</td>
                    <td data-label="KEGIATAN">– Jalur RPL/Alih Kredit dan On Going</td>
                    <td data-label="2024/2025 GENAP">18 November 2024 – 5 Maret 2025</td>
                  </tr>
                  
                  <!-- Registrasi TTM -->
                  <tr data-category="pendaftaran">
                    <td data-label="2024/2025 GANJIL">6 Mei – 18 September 2024</td>
                    <td data-label="KEGIATAN">
                      <span class="category-pill category-pendaftaran">Pendaftaran</span>
                      <strong>Registrasi TTM Atas Permintaan Mahasiswa</strong>
                    </td>
                    <td data-label="2024/2025 GENAP">17 Oktober 2024 – 12 Maret 2025</td>
                  </tr>
                  
                  <!-- Pembayaran TTM -->
                  <tr data-category="pendaftaran">
                    <td data-label="2024/2025 GANJIL">6 Mei – 20 September 2024</td>
                    <td data-label="KEGIATAN">
                      <span class="category-pill category-pendaftaran">Pendaftaran</span>
                      <strong>Pembayaran TTM Atas Permintaan Mahasiswa</strong>
                    </td>
                    <td data-label="2024/2025 GENAP">17 Oktober 2024 – 15 Maret 2025</td>
                  </tr>
                  
                  <!-- Dies Natalis -->
                  <tr data-category="akademik">
                    <td data-label="2024/2025 GANJIL">4 September 2024</td>
                    <td data-label="KEGIATAN">
                      <span class="category-pill category-akademik">Akademik</span>
                      <strong>Dies Natalis Universitas Terbuka</strong>
                    </td>
                    <td data-label="2024/2025 GENAP">4 September 2025</td>
                  </tr>
                  
                  <!-- Aktivasi Tutorial Online -->
                  <tr data-category="akademik">
                    <td data-label="2024/2025 GANJIL">7 Mei – 23 September 2024</td>
                    <td data-label="KEGIATAN">
                      <span class="category-pill category-akademik">Akademik</span>
                      <strong>Aktivasi dan Pengisian Form Kesediaan Mengikuti Tutorial Online</strong>
                    </td>
                    <td data-label="2024/2025 GENAP">18 Oktober 2024 – 24 Maret 2025</td>
                  </tr>
                  
                  <!-- Layanan Pendukung Kesuksesan Mahasiswa Baru -->
                  <tr data-category="akademik">
                    <td data-label="2024/2025 GANJIL"></td>
                    <td data-label="KEGIATAN">
                      <span class="category-pill category-akademik">Akademik</span>
                      <strong>Layanan Pendukung Kesuksesan Belajar Jarak Jauh Mahasiswa Baru</strong>
                    </td>
                    <td data-label="2024/2025 GENAP"></td>
                  </tr>
                  <tr data-category="akademik">
                    <td data-label="2024/2025 GANJIL">23 Juni – 22 September 2024</td>
                    <td data-label="KEGIATAN">– Orientasi Studi Mahasiswa Baru (OSMB) – Pelatihan Keterampilan Belajar Jarak Jauh (PKBJJ)</td>
                    <td data-label="2024/2025 GENAP">21 Desember 2024 – 23 Maret 2025</td>
                  </tr>
                  
                  <!-- Layanan Pendukung Kesuksesan Belajar -->
                  <tr data-category="akademik">
                    <td data-label="2024/2025 GANJIL"></td>
                    <td data-label="KEGIATAN">
                      <span class="category-pill category-akademik">Akademik</span>
                      <strong>Layanan Pendukung Kesuksesan Belajar Jarak Jauh</strong>
                    </td>
                    <td data-label="2024/2025 GENAP"></td>
                  </tr>
                  <tr data-category="akademik">
                    <td data-label="2024/2025 GANJIL">23 Juni – 27 Oktober 2024</td>
                    <td data-label="KEGIATAN">– Workshop Tugas – Klinik Ujian</td>
                    <td data-label="2024/2025 GENAP">21 Desember 2024 – 27 April 2025</td>
                  </tr>
                  
                  <!-- Pengumuman Lulusan -->
                  <tr data-category="akademik">
                    <td data-label="2024/2025 GANJIL"></td>
                    <td data-label="KEGIATAN">
                      <span class="category-pill category-akademik">Akademik</span>
                      <strong>Pengumuman Lulusan</strong>
                    </td>
                    <td data-label="2024/2025 GENAP"></td>
                  </tr>
                  <tr data-category="akademik">
                    <td data-label="2024/2025 GANJIL">24 September 2024</td>
                    <td data-label="KEGIATAN">– Tahap I</td>
                    <td data-label="2024/2025 GENAP">2 April 2025</td>
                  </tr>
                  <tr data-category="akademik">
                    <td data-label="2024/2025 GANJIL">15 Oktober 2024</td>
                    <td data-label="KEGIATAN">– Tahap II</td>
                    <td data-label="2024/2025 GENAP">30 April 2025</td>
                  </tr>
                  
                  <!-- TTM -->
                  <tr data-category="akademik">
                    <td data-label="2024/2025 GANJIL">5 Oktober – 8 Desember 2024</td>
                    <td data-label="KEGIATAN">
                      <span class="category-pill category-akademik">Akademik</span>
                      <strong>Tutorial Tatap Muka (TTM)</strong>
                    </td>
                    <td data-label="2024/2025 GENAP">5 April – 8 Juni 2025</td>
                  </tr>
                  
                  <!-- Tuton -->
                  <tr data-category="akademik">
                    <td data-label="2024/2025 GANJIL">14 Oktober – 8 Desember 2024</td>
                    <td data-label="KEGIATAN">
                      <span class="category-pill category-akademik">Akademik</span>
                      <strong>Tutorial Online (Tuton)</strong>
                    </td>
                    <td data-label="2024/2025 GENAP">14 April – 8 Juni 2025</td>
                  </tr>
                  
                  <!-- Tugas Mata Kuliah -->
                  <tr data-category="akademik">
                    <td data-label="2024/2025 GANJIL"></td>
                    <td data-label="KEGIATAN">
                      <span class="category-pill category-akademik">Akademik</span>
                      <strong>Tugas Mata Kuliah</strong>
                    </td>
                    <td data-label="2024/2025 GENAP"></td>
                  </tr>
                  <tr data-category="akademik">
                    <td data-label="2024/2025 GANJIL">28 Oktober – 3 November 2024</td>
                    <td data-label="KEGIATAN">– Tugas Mata Kuliah 1</td>
                    <td data-label="2024/2025 GENAP">28 April – 4 Mei 2025</td>
                  </tr>
                  <tr data-category="akademik">
                    <td data-label="2024/2025 GANJIL">11 – 17 November 2024</td>
                    <td data-label="KEGIATAN">– Tugas Mata Kuliah 2</td>
                    <td data-label="2024/2025 GENAP">12 – 18 Mei 2025</td>
                  </tr>
                  <tr data-category="akademik">
                    <td data-label="2024/2025 GANJIL">25 November – 1 Desember 2024</td>
                    <td data-label="KEGIATAN">– Tugas Mata Kuliah 3</td>
                    <td data-label="2024/2025 GENAP">26 Mei – 1 Juni 2025</td>
                  </tr>
                  
                  <!-- Karya Ilmiah -->
                  <tr data-category="akademik">
                    <td data-label="2024/2025 GANJIL">14 Oktober – 22 Desember 2024</td>
                    <td data-label="KEGIATAN">
                      <span class="category-pill category-akademik">Akademik</span>
                      <strong>Bimbingan dan Unggah Karya Ilmiah</strong>
                    </td>
                    <td data-label="2024/2025 GENAP">7 April – 23 Juni 2025</td>
                  </tr>
                  
                  <!-- Wisuda -->
                  <tr data-category="wisuda">
                    <td data-label="2024/2025 GANJIL">11 – 12 November 2024 (Wisuda Periode I Wilayah I)<br>18 – 19 November 2024 (Wisuda Periode I Wilayah II)</td>
                    <td data-label="KEGIATAN">
                      <span class="category-pill category-wisuda">Wisuda</span>
                      <strong>Wisuda</strong>
                    </td>
                    <td data-label="2024/2025 GENAP">14 – 15 Juli 2025 (Wisuda Periode II Wilayah I)<br>28 – 29 Juli 2025 (Wisuda Periode II Wilayah II)</td>
                  </tr>
                  
                  <!-- KTPU -->
                  <tr data-category="ujian">
                    <td data-label="2024/2025 GANJIL">11 November 2024 – 25 Januari 2025</td>
                    <td data-label="KEGIATAN">
                      <span class="category-pill category-ujian">Ujian</span>
                      <strong>Pencetakan KTPU melalui Laman <a href="https://myut.ut.ac.id" target="_blank">https://myut.ut.ac.id</a></strong>
                    </td>
                    <td data-label="2024/2025 GENAP">12 Mei – 26 Juli 2025</td>
                  </tr>
                  
                  <!-- Praktikum -->
                  <tr data-category="ujian">
                    <td data-label="2024/2025 GANJIL">22 Desember 2024</td>
                    <td data-label="KEGIATAN">
                      <span class="category-pill category-ujian">Ujian</span>
                      <strong>Batas Akhir Mengunggah Laporan Praktik/Praktikum ke Laman <a href="https://praktik.ut.ac.id" target="_blank">https://praktik.ut.ac.id</a></strong>
                    </td>
                    <td data-label="2024/2025 GENAP">23 Juni 2025</td>
                  </tr>
                  
                  <!-- UAS Tatap Muka -->
                  <tr data-category="ujian">
                    <td data-label="2024/2025 GANJIL">14 dan 15 Desember 2024</td>
                    <td data-label="KEGIATAN">
                      <span class="category-pill category-ujian">Ujian</span>
                      <strong>Ujian Akhir Semester (Tatap Muka)</strong>
                    </td>
                    <td data-label="2024/2025 GENAP">14 dan 15 Juni 2025</td>
                  </tr>
                  
                  <!-- UAS Online -->
                  <tr data-category="ujian">
                    <td data-label="2024/2025 GANJIL">10 Desember 2024 – 26 Januari 2025</td>
                    <td data-label="KEGIATAN">
                      <span class="category-pill category-ujian">Ujian</span>
                      <strong>Ujian Akhir Semester (Ujian Online)</strong>
                    </td>
                    <td data-label="2024/2025 GENAP">10 Juni – 27 Juli 2025</td>
                  </tr>
                  
                  <!-- Pengumuman Nilai -->
                  <tr data-category="ujian">
                    <td data-label="2024/2025 GANJIL">5 Februari 2025</td>
                    <td data-label="KEGIATAN">
                      <span class="category-pill category-ujian">Ujian</span>
                      <strong>Pengumuman Nilai Akhir Mata Kuliah</strong>
                    </td>
                    <td data-label="2024/2025 GENAP">6 Agustus 2025</td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Empty Message -->
            <div class="empty-message wow fadeInUp d-none" data-wow-delay="0.3s" id="emptyMessage">
              <i class="bi bi-calendar-x"></i>
              <h4>Tidak ada jadwal yang ditemukan</h4>
              <p>Silakan ubah filter pencarian Anda atau ketik kata kunci yang berbeda.</p>
            </div>

            <!-- Additional Info -->
            <div class="jadwal-notes mt-4 wow fadeInUp" data-wow-delay="0.4s">
              <div class="alert alert-info">
                <h5 class="alert-heading"><i class="bi bi-info-circle-fill me-2"></i> Informasi Penting</h5>
                <p>Jadwal di atas dapat berubah sewaktu-waktu. Untuk informasi terbaru, silakan periksa pengumuman resmi dari Universitas Terbuka atau hubungi SALUT Tana Toraja.</p>
                <hr>
                <p class="mb-0">Untuk konsultasi terkait jadwal perkuliahan, silakan hubungi kami melalui WhatsApp di <a href="https://wa.me/6282293924242" class="alert-link">+62 822-9392-4242</a> atau kunjungi kantor SALUT Tana Toraja.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End Jadwal Content Section -->

    <!--Start Footer Three-->
    <footer class="footer-three">
      <!-- Start Footer Main -->
      <div class="footer-main footer-main__three">
        <div class="footer-three__shape1">
          <img src="assets/img/shape/footer-three__shape1.png" alt="shapes" />
        </div>
        <div class="footer-three__shape2">
          <img src="assets/img/shape/footer-three__shape2.png" alt="shapes" />
        </div>
        <div class="container">
          <div class="footer-main__inner footer-main-two__inner footer-main-three__inner">
            <div class="row">
              <!--Start Single Footer Widget-->
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
              <!--End Single Footer Widget-->

              <!--Start Single Footer Widget-->
              <div class="col-xl-2 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".2s">
                <div class="single-footer-widget single-footer-widget-style2 ml55">
                  <div class="title">
                    <h3>Link Cepat</h3>
                  </div>
                  <div class="single-footer-widget-box single-footer-widget__links single-footer-widget__links-style2">
                    <ul class="clearfix">
                      <li>
                        <p><a href="./tentang/">Tentang UT</a></p>
                      </li>
                      <li>
                        <p><a href="./layanan/informasi">Informasi Akademik</a></p>
                      </li>
                      <li>
                        <p><a href="./administrasi/">Administrasi</a></p>
                      </li>
                      <li>
                        <p><a href="./tentang/kepalasalut">Sapaan dari Kepala SALUT</a></p>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <!--End Single Footer Widget-->

              <!--Start Single Footer Widget-->
              <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".3s">
                <div class="single-footer-widget single-footer-widget-style2 ml50">
                  <div class="title">
                    <h3>Layanan Kami</h3>
                  </div>
                  <div class="single-footer-widget-box single-footer-widget__links single-footer-widget__links-style2">
                    <ul class="clearfix">
                      <li>
                        <p>
                          <a href="./informasi">Informasi Akademik</a>
                        </p>
                      </li>
                      <li>
                        <p>
                          <a href="./administrasi">Administrasi Akademik</a>
                        </p>
                      </li>
                      <li>
                        <p>
                          <a href="./kegiatan">Kegiatan</a>
                        </p>
                      </li>
                      <li>
                        <p>
                          <a href="./modul/">Pengambilan Modul</a>
                        </p>
                      </li>
                      <li>
                        <p>
                          <a href="./suratketerangan">Surat Keterangan</a>
                        </p>
                      </li>
                      <li>
                        <p>
                          <a href="./legalisir">Legalisir Ijazah</a>
                        </p>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <!--End Single Footer Widget-->
            </div>
          </div>
        </div>
        
        <!--Start Footer Bottom -->
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
        <!--End Footer Bottom -->
      </div>
    </footer>
    <!--End Footer Three-->
  </div>

  <!-- Scroll-top -->
  <button class="scroll-top scroll-to-target" data-target="html">
    <i class="icon-down-arrow"></i>
  </button>
  <!-- Scroll-top-end-->

  <!--Start Search Popup -->
  <div class="search-popup">
    <div class="search-popup__overlay search-toggler">
      <div class="search-close-btn">
        <i class="icon-plus"></i>
      </div>
    </div>
    <div class="search-popup__content">
      <form action="#">
        <label for="search" class="sr-only">search here</label>
        <input type="search" id="search" placeholder="Search Here..." />
        <button type="submit" aria-label="search submit" class="btn-one">
          <i class="icon-search-interface-symbol"></i>
        </button>
      </form>
    </div>
  </div>
  <!--End Search Popup -->

  <!-- JS here -->
  <script src="assets/js/jquery-3.6.0.min.js"></script>
  <script src="assets/js/01-ajax-form.js"></script>
  <script src="assets/js/03-jquery.appear.js"></script>
  <script src="assets/js/04-swiper.min.js"></script>
  <script src="assets/js/05-jquery.odometer.min.js"></script>
  <script src="assets/js/06-jquery.magnific-popup.min.js"></script>
  <script src="assets/js/07-jquery.nice-select.min.js"></script>
  <script src="assets/js/08-slick.min.js"></script>
  <script src="assets/js/09-wow.min.js"></script>
  <script src="assets/js/10-jquery.circleType.js"></script>
  <script src="assets/js/11-jquery.lettering.min.js"></script>
  <script src="assets/js/12-TweenMax.min.js"></script>
  <script src="assets/js/popper.min.js"></script>
  <script src="assets/vendor/jarallax/jarallax.min.js"></script>
  <script src="assets/vendor/marquee/marquee.min.js"></script>
  <script src="assets/vendor/odometer/odometer.min.js"></script>
  <script src="assets/vendor/progress-bar/knob.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/main.js"></script>
  
  <script>
    // Filter functionality
    $(document).ready(function() {
      // Filter table function
      function filterTable() {
        let semester = $('#semesterFilter').val();
        let category = $('#categoryFilter').val();
        let searchTerm = $('#searchInput').val().toLowerCase();
        let visibleRows = 0;
        
        $('#jadwalTable tbody tr').each(function() {
          let row = $(this);
          let rowCategory = row.data('category') || '';
          let ganjilText = row.find('td:eq(0)').text().toLowerCase();
          let kegiatanText = row.find('td:eq(1)').text().toLowerCase();
          let genapText = row.find('td:eq(2)').text().toLowerCase();
          
          // Check for semester match
          let semesterMatch = true;
          if (semester !== 'all') {
            if (semester === '2024/2025 GANJIL' && !ganjilText) {
              semesterMatch = false;
            } else if (semester === '2024/2025 GENAP' && !genapText) {
              semesterMatch = false;
            }
          }
          
          // Check for category match
          let categoryMatch = category === 'all' || rowCategory === category;
          
          // Check for search term
          let searchMatch = searchTerm === '' || 
                           ganjilText.includes(searchTerm) || 
                           kegiatanText.includes(searchTerm) || 
                           genapText.includes(searchTerm);
          
          // Show/hide row based on filters
          if (semesterMatch && categoryMatch && searchMatch) {
            row.removeClass('d-none');
            visibleRows++;
          } else {
            row.addClass('d-none');
          }
        });
        
        // Show/hide empty message
        if (visibleRows === 0) {
          $('#emptyMessage').removeClass('d-none');
        } else {
          $('#emptyMessage').addClass('d-none');
        }
      }
      
      // Apply filters on change
      $('#semesterFilter, #categoryFilter').on('change', filterTable);
      $('#searchInput').on('keyup', filterTable);
      
      // Highlight rows on hover
      $('#jadwalTable tbody tr').hover(
        function() {
          $(this).addClass('highlight-row');
        },
        function() {
          $(this).removeClass('highlight-row');
        }
      );
    });
  </script>
</body>

</html>
