<!DOCTYPE html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Modul Pembelajaran | Universitas Terbuka Tana Toraja</title>
    <meta name="description" content="Sistem pengecekan dan pengambilan modul pembelajaran Universitas Terbuka di SALUT Tana Toraja. Dapatkan informasi tentang ketersediaan bahan ajar cetak dan digital." />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link
      rel="shortcut icon"
      type="image/x-icon"
      href="../assets/img/favicon.png"
    />
    <!-- Place favicon.ico in the root directory -->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- CSS here -->
    <link rel="stylesheet" href="../assets/css/01-bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/css/02-all.min.css" />
    <link rel="stylesheet" href="../assets/css/03-jquery.magnific-popup.css" />
    <link rel="stylesheet" href="../assets/css/05-odometer.css" />
    <link rel="stylesheet" href="../assets/css/06-swiper.min.css" />
    <link rel="stylesheet" href="../assets/css/07-animate.min.css" />
    <link rel="stylesheet" href="../assets/css/08-custom-animate.css" />
    <link rel="stylesheet" href="../assets/css/09-slick.css" />
    <link rel="stylesheet" href="../assets/css/10-icomoon.css" />
    <link rel="stylesheet" href="../assets/vendor/custom-animate/custom-animate.css"/>
    <link rel="stylesheet" href="../assets/vendor/jarallax/jarallax.css" />
    <link rel="stylesheet" href="../assets/vendor/odometer/odometer.min.css" />
    <link rel="stylesheet" href="../assets/fonts/gilroy/stylesheet.css" />

    <link rel="stylesheet" href="../assets/css/style.css" />
    <link rel="stylesheet" href="../assets/css/color1.css" />
    <link rel="stylesheet" href="../assets/css/responsive.css" />
    
    <!-- Add Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <!-- Custom Module Styles - Same as before -->
    <style>
      /* Custom styles for module page */
      .module-hero {
        background: var(--thm-secondary);
        background-size: cover;
        background-position: center;
        padding: 80px 0;
        color: #fff;
        border-radius: 10px;
        margin-bottom: 40px;
      }
      
      /* Enhanced module card styles 🎨 */
      .module-card {
        background: #ffffff;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        padding: 30px;
        height: 100%;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        position: relative;
        overflow: hidden;
        margin-bottom: 30px;
        border: 1px solid rgba(0, 0, 0, 0.03);
      }
      
      .module-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
      }
      
      .module-card:after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-radius: 15px;
        opacity: 0;
        background: linear-gradient(135deg, rgba(var(--primary-rgb), 0.05), rgba(var(--secondary-rgb), 0.05));
        z-index: -1;
        transition: opacity 0.4s ease;
      }
      
      .module-card:hover:after {
        opacity: 1;
      }
      
      .module-icon {
        width: 80px;
        height: 80px;
        background: rgba(var(--primary-rgb), 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
        position: relative;
      }
      
      .module-icon:before {
        content: '';
        position: absolute;
        width: 94px;
        height: 94px;
        border: 1px dashed var(--thm-primary);
        border-radius: 50%;
        animation: spin 30s linear infinite;
      }
      
      @keyframes spin {
        from {
          transform: rotate(0deg);
        }
        to {
          transform: rotate(360deg);
        }
      }
      
      .module-icon i {
        font-size: 36px;
        color: var(--thm-primary);
        transition: all 0.3s ease;
      }
      
      .module-card:hover .module-icon i {
        transform: scale(1.1);
      }
      
      .float-animation {
        animation: float 3s infinite ease-in-out;
      }
      
      @keyframes float {
        0%, 100% {
          transform: translateY(0);
        }
        50% {
          transform: translateY(-10px);
        }
      }
      
      .module-title {
        font-size: 22px;
        color: var(--thm-black);
        font-weight: 600;
        margin-bottom: 15px;
        text-align: center;
      }
      
      .module-text {
        color: #6c757d;
        margin-bottom: 25px;
        text-align: center;
        font-size: 15px;
        line-height: 1.6;
      }
      
      .feature-list {
        margin-bottom: 25px;
      }
      
      .feature-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 12px;
        padding-bottom: 12px;
        border-bottom: 1px dashed #eee;
      }
      
      .feature-item:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
      }
      
      .feature-icon {
        margin-right: 12px;
        color: var(--thm-primary);
        margin-top: 3px;
        flex-shrink: 0;
      }
      
      .feature-text p {
        margin-bottom: 0;
        font-size: 14px;
        color: #6c757d;
      }
      
      /* Form styling */
      .form-control {
        height: 55px;
        border: 1px solid #eee;
        border-radius: 10px;
        padding: 10px 20px;
        font-size: 16px;
        transition: all 0.3s ease;
      }
      
      .form-control:focus {
        border-color: var(--thm-primary);
        box-shadow: 0 0 0 3px rgba(var(--primary-rgb), 0.1);
      }
      
      .form-label {
        font-weight: 500;
        margin-bottom: 8px;
        font-size: 15px;
      }
      
      .form-text {
        font-size: 13px;
        color: #6c757d;
      }
      
      .info-box {
        background-color: rgba(var(--primary-rgb), 0.05);
        border-left: 4px solid var(--thm-primary);
        padding: 15px;
        border-radius: 8px;
        display: flex;
        align-items: center;
      }
      
      .info-box i {
        font-size: 24px;
        color: var(--thm-primary);
        margin-right: 15px;
      }
      
      .btn-check-module {
        background: var(--thm-primary);
        color: #fff;
        border: none;
        height: 55px;
        border-radius: 10px;
        padding: 0 30px;
        font-size: 16px;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-top: 20px;
      }
      
      .btn-check-module:hover {
        background-color: var(--thm-black);
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
      }
      
      .btn-check-module i {
        margin-right: 8px;
      }
      
      /* Status container styles */
      #status-container {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        padding: 40px;
        text-align: center;
        position: relative;
        overflow: hidden;
        margin-top: 30px;
      }
      
      #status-container:before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 200px;
        height: 200px;
        background: rgba(var(--primary-rgb), 0.03);
        border-radius: 50%;
        transform: translate(50%, -50%);
        z-index: 0;
      }
      
      #status-container:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 200px;
        height: 200px;
        background: rgba(var(--secondary-rgb), 0.03);
        border-radius: 50%;
        transform: translate(-50%, 50%);
        z-index: 0;
      }
      
      .status-icon {
        width: 100px;
        height: 100px;
        background: rgba(var(--primary-rgb), 0.05);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
      }
      
      .status-icon i {
        font-size: 48px;
      }
      
      .status-message {
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 30px;
        color: var(--thm-black);
      }
      
      .status-details {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 25px;
        margin-bottom: 30px;
        text-align: left;
      }
      
      .status-detail-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
      }
      
      .status-detail-item:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
      }
      
      .status-detail-item span {
        color: #6c757d;
        font-size: 15px;
      }
      
      .status-detail-item strong {
        font-weight: 600;
        color: var(--thm-black);
      }
      
      /* Process steps styling */
      .steps-container {
        position: relative;
        padding-left: 50px;
      }
      
      .steps-container:before {
        content: '';
        position: absolute;
        left: 24px;
        top: 0;
        width: 2px;
        height: 100%;
        background: #e9ecef;
        z-index: 1;
      }
      
      .step-item {
        position: relative;
        margin-bottom: 50px;
        z-index: 2;
      }
      
      .step-item:last-child {
        margin-bottom: 0;
      }
      
      .step-number {
        position: absolute;
        left: -50px;
        top: 0;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: #fff;
        border: 2px solid var(--thm-primary);
        color: var(--thm-primary);
        font-weight: 600;
        font-size: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 3;
        transition: all 0.3s ease;
      }
      
      .step-item:hover .step-number {
        background: var(--thm-primary);
        color: #fff;
        transform: scale(1.1);
      }
      
      .step-content h4 {
        font-size: 20px;
        margin-bottom: 10px;
        font-weight: 600;
        color: var(--thm-black);
      }
      
      .step-content p {
        color: #6c757d;
        margin-bottom: 0;
        font-size: 15px;
      }
      
      /* FAQ styles */
      .faq-item {
        margin-bottom: 15px;
        border: none;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.03);
      }
      
      .faq-button {
        background: #fff;
        color: var(--thm-black);
        font-size: 17px;
        font-weight: 600;
        padding: 20px;
        position: relative;
        text-align: left;
        width: 100%;
        border: none;
        border-radius: 10px;
      }
      
      .faq-button:not(.collapsed) {
        background-color: var(--thm-primary);
        color: #fff;
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
      }
      
      .faq-icon {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        transition: all 0.3s ease;
      }
      
      .faq-button:not(.collapsed) .faq-icon {
        transform: translateY(-50%) rotate(180deg);
        color: #fff;
      }
      
      .faq-body {
        padding: 20px;
        background-color: #fff;
        font-size: 15px;
        color: #6c757d;
        line-height: 1.7;
      }
      
      /* Contact card styling */
      .module-contact-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        padding: 40px;
        position: relative;
        overflow: hidden;
      }
      
      .module-contact-title {
        color: var(--thm-black);
        font-size: 22px;
        font-weight: 600;
      }
      
      .module-contact-info {
        display: flex;
        align-items: flex-start;
        margin-bottom: 25px;
      }
      
      .module-contact-icon {
        width: 45px;
        height: 45px;
        background: rgba(var(--primary-rgb), 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        flex-shrink: 0;
      }
      
      .module-contact-icon i {
        font-size: 20px;
        color: var(--thm-primary);
      }
      
      .module-contact-info h5 {
        font-size: 17px;
        margin-bottom: 5px;
        font-weight: 600;
        color: var(--thm-black);
      }
      
      .module-contact-info p {
        margin-bottom: 0;
        color: #6c757d;
        font-size: 15px;
      }
      
      /* Fixed Preloader Styles - Enhancement */
      #preloader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background-color: #fff;
        transition: opacity 0.5s ease, visibility 0.5s ease;
      }
      
      #loading-center {
        width: 100%;
        height: 100%;
        position: relative;
      }
      
      .loader {
        width: 60px;
        height: 60px;
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -30px;
        margin-left: -30px;
        border-radius: 50%;
        animation: loader 1s linear infinite;
      }
      
      .loader-outter {
        position: absolute;
        border: 4px solid var(--thm-primary);
        border-left-color: transparent;
        border-bottom: 0;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        animation: loader-outter 1s cubic-bezier(.42, .61, .58, .41) infinite;
      }
      
      .loader-inner {
        position: absolute;
        border: 4px solid var(--thm-secondary);
        border-radius: 50%;
        width: 40px;
        height: 40px;
        left: calc(50% - 20px);
        top: calc(50% - 20px);
        border-right: 0;
        border-top-color: transparent;
        animation: loader-inner 1s cubic-bezier(.42, .61, .58, .41) infinite;
      }
      
      @keyframes loader-outter {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
      }
      
      @keyframes loader-inner {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(-360deg); }
      }
      
      /* Fade out preloader */
      .preloader-hide {
        opacity: 0;
        visibility: hidden;
      }
      
      /* Responsive styling */
      @media (max-width: 767px) {
        .module-card {
          padding: 20px;
        }
        
        #status-container {
          padding: 25px;
        }
        
        .status-details {
          padding: 15px;
        }
        
        .module-contact-card {
          padding: 25px;
        }
        
        .step-content h4 {
          font-size: 18px;
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

    <?php
    require_once '../koneksi.php';
    ?>
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
                  <a href="../">
                    <img src="../assets/img/resource/logo.png" alt="Logo" />
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
                          <li><a href="../">Home</a></li>
                          <li class="menu-item-has-children">
                            <a href="#">Aplikasi UT</a>
                            <ul class="sub-menu">
                              <li>
                                <a href="https://elearning.ut.ac.id">Elearning/Tuton</a>
                              </li>
                              <li>
                                <a href="https://tmk.ut.ac.id">Tugas Mata Kuliah (TMK)</a>
                              </li>
                              <li>
                                <a href="https://silayar.ut.ac.id">SILAYAR UT</a>
                              </li>
                              <li>
                                <a href="https://aksi.ut.ac.id">AKSI UT</a>
                              </li>
                              <li>
                                <a href="https://the.ut.ac.id">Take Home Exam (THE)</a>
                              </li>
                            </ul>
                          </li>
                          <li class="menu-item-has-children">
                            <a href="#">Layanan</a>
                            <ul class="sub-menu">
                              <li><a href="../informasi.php">Informasi Akademik</a></li>
                              <li><a href="../administrasi/">Administrasi Akademik</a></li>
                              <li><a href="../kegiatan.php">Kegiatan Akademik</a></li>
                              <li><a href="../modul/">Pengambilan Modul</a></li>
                              <li><a href="../legalisir/">Legalisir Ijazah</a></li>
                              <li><a href="../suratketerangan/">Surat Keterangan</a></li>
                            </ul>
                          </li>
                          <li><a href="../galeri/">Galeri</a></li>
                          <li class="menu-item-has-children">
                            <a href="#">Tentang</a>
                            <ul class="sub-menu">
                              <li><a href="../tentang/">Universitas Terbuka</a></li>
                              <li><a href="../tentang/salut/">SALUT</a></li>
                              <li><a href="../tentang/saluttator.php">SALUT Tana Toraja</a></li>
                              <li><a href="../tentang/kepalasalut.php">Pesan Kepala SALUT</a></li>
                            </ul>
                          </li>
                          <li class="menu-item-has-children">
                            <a href="#">Program</a>
                            <ul class="sub-menu">
                              <li><a href="../rpl.php">RPL</a></li>
                              <li><a href="../reguler.php">Reguler</a></li>
                              <li><a href="../jurusan.php">Program Studi</a></li>
                            </ul>
                          </li>
                          <li><a href="../biaya.php">Biaya Kuliah</a></li>
                        </ul>
                      </div>
                    </nav>
                  </div>
                </div>
              </div>

              <div class="main-header-one__bottom-right">
                <div class="header-btn-box-one">
                  <a class="thm-btn" href="../pendaftaran/">
                    <span class="txt">Mendaftar Disini</span>
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
              <a href="../">
                <img src="../assets/img/resource/mobile-menu-logo.png" alt="Logo" />
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
          <img src="../assets/img/shape/page-header-shape1.png" alt="" />
        </div>
        <div class="shape2 float-bob-x">
          <img src="../assets/img/shape/page-header-shape2.png" alt="" />
        </div>
        <div class="container">
          <div class="page-header__inner">
            <h2>Modul Pembelajaran</h2>
            <ul class="thm-breadcrumb">
              <li>
                <a href="../"><span class="fa fa-home"></span> Home</a>
              </li>
              <li><i class="icon-right-arrow-angle"></i></li>
              <li>Layanan</li>
              <li><i class="icon-right-arrow-angle"></i></li>
              <li class="color-base">Modul Pembelajaran</li>
            </ul>
          </div>
        </div>
      </section>
      <!--End Page Header-->

      <!-- Hero Section -->
      <section class="pb-5">
        <div class="container">
          <div class="module-hero wow fadeIn" data-wow-delay="0.1s">
            <div class="container text-center">
              <div class="row justify-content-center">
                <div class="col-lg-8">
                  <h1 class="display-5 fw-bold mb-4">Bahan Ajar Universitas Terbuka</h1>
                  <p class="text-white lead fs-5 mb-4">Akses dan periksa ketersediaan modul cetak dan bahan ajar digital untuk mendukung pembelajaran Anda di Universitas Terbuka</p>
                  <a href="#check-module" class="btn btn-primary btn-lg">
                    <span>Cek Ketersediaan Modul</span>
                    <i class="bi bi-arrow-down-circle ms-2"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Module Types Section -->
      <section class="py-5">
        <div class="container">
          <div class="section-title text-center mb-5">
            <span class="subtitle">Jenis Bahan Ajar</span>
            <h2>Bahan Ajar yang Tersedia</h2>
            <p class="mx-auto" style="max-width: 700px;">Universitas Terbuka menyediakan beberapa jenis bahan ajar untuk mendukung proses pembelajaran mandiri mahasiswa</p>
          </div>
          
          <div class="row g-4">
            <!-- Card 1: Printed Module -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
              <div class="module-card">
                <div class="module-icon float-animation">
                  <i class="bi bi-book"></i>
                </div>
                <h3 class="module-title">Modul Cetak</h3>
                <p class="module-text">Bahan ajar cetak yang berisi materi pembelajaran lengkap untuk setiap mata kuliah.</p>
                
                <div class="feature-list">
                  <div class="feature-item">
                    <div class="feature-icon">
                      <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div class="feature-text">
                      <p>Dikirimkan langsung ke mahasiswa</p>
                    </div>
                  </div>
                  <div class="feature-item">
                    <div class="feature-icon">
                      <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div class="feature-text">
                      <p>Dapat diambil di SALUT setempat</p>
                    </div>
                  </div>
                  <div class="feature-item">
                    <div class="feature-icon">
                      <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div class="feature-text">
                      <p>Berisi latihan dan tes mandiri</p>
                    </div>
                  </div>
                </div>
                
                <div class="text-center">
                  <a href="#check-module" class="btn btn-outline-primary">Cek Ketersediaan</a>
                </div>
              </div>
            </div>
            
            <!-- Card 2: Digital Module -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
              <div class="module-card">
                <div class="module-icon float-animation">
                  <i class="bi bi-tablet"></i>
                </div>
                <h3 class="module-title">Modul Digital</h3>
                <p class="module-text">Versi elektronik dari bahan ajar cetak yang dapat diakses melalui platform digital.</p>
                
                <div class="feature-list">
                  <div class="feature-item">
                    <div class="feature-icon">
                      <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div class="feature-text">
                      <p>Akses dari mana saja dan kapan saja</p>
                    </div>
                  </div>
                  <div class="feature-item">
                    <div class="feature-icon">
                      <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div class="feature-text">
                      <p>Tersedia secara online</p>
                    </div>
                  </div>
                  <div class="feature-item">
                    <div class="feature-icon">
                      <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div class="feature-text">
                      <p>Dapat diakses melalui aplikasi UT</p>
                    </div>
                  </div>
                </div>
                
                <div class="text-center">
                  <a href="https://pustaka.ut.ac.id/lib/" target="_blank" class="btn btn-outline-primary">Akses Modul Digital</a>
                </div>
              </div>
            </div>
            
            <!-- Card 3: Supplementary Materials -->
            <div class="col-lg-4 col-md-6 mx-md-auto wow fadeInUp" data-wow-delay="0.3s">
              <div class="module-card">
                <div class="module-icon float-animation">
                  <i class="bi bi-collection-play"></i>
                </div>
                <h3 class="module-title">Bahan Ajar Penunjang</h3>
                <p class="module-text">Bahan pembelajaran tambahan untuk mendukung pemahaman mahasiswa tentang materi kuliah.</p>
                
                <div class="feature-list">
                  <div class="feature-item">
                    <div class="feature-icon">
                      <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div class="feature-text">
                      <p>Tutorial online dan tatap muka</p>
                    </div>
                  </div>
                  <div class="feature-item">
                    <div class="feature-icon">
                      <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div class="feature-text">
                      <p>Video pembelajaran dan webinar</p>
                    </div>
                  </div>
                  <div class="feature-item">
                    <div class="feature-icon">
                      <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div class="feature-text">
                      <p>Latihan dan simulasi ujian</p>
                    </div>
                  </div>
                </div>
                
                <div class="text-center">
                  <a href="https://elearning.ut.ac.id" target="_blank" class="btn btn-outline-primary">Lihat Bahan Penunjang</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Module Check Section -->
      <section id="check-module" class="py-5 bg-light">
        <div class="container">
          <div class="section-title text-center mb-5">
            <span class="subtitle">Cek Ketersediaan</span>
            <h2>Periksa Status Pengiriman Modul</h2>
            <p class="mx-auto" style="max-width: 700px;">Masukkan NIM dan tanggal lahir Anda untuk memeriksa status ketersediaan dan pengiriman modul pembelajaran</p>
          </div>
          
          <div class="row justify-content-center">
            <div class="col-lg-8">
              <div class="module-card">
                <form id="cekModulForm" class="mb-0">
                  <div class="row g-4">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="nim" class="form-label">Nomor Induk Mahasiswa (NIM) <span class="text-danger">*</span></label>
                        <input 
                          type="text" 
                          class="form-control" 
                          id="nim" 
                          name="nim" 
                          placeholder="Masukkan NIM (9 digit)" 
                          required 
                          maxlength="9"
                          pattern="\d{9}"
                        />
                        <div class="form-text">NIM harus terdiri dari 9 angka sesuai kartu mahasiswa Anda.</div>
                      </div>
                    </div>
                    
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                        <input 
                          type="text" 
                          class="form-control" 
                          id="tanggal_lahir" 
                          name="tanggal_lahir" 
                          placeholder="DD/MM/YYYY" 
                          required
                        />
                        <div class="form-text">Masukkan tanggal lahir sesuai format DD/MM/YYYY (contoh: 31/12/1990).</div>
                      </div>
                    </div>
                    
                    <div class="col-md-12">
                      <div class="info-box mb-0">
                        <i class="bi bi-info-circle-fill"></i>
                        <span>Pastikan data yang Anda masukkan sesuai dengan data yang terdaftar di Universitas Terbuka.</span>
                      </div>
                    </div>
                    
                    <div class="col-md-12 text-center">
                      <button type="submit" class="btn-check-module">
                        <i class="bi bi-search"></i>
                        <span>Cek Status Modul</span>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
              
              <!-- Results Container -->
              <div id="status-container" style="display: none;" class="wow fadeIn" data-wow-delay="0.3s">
                <div class="status-icon">
                  <i class="bi bi-check-circle-fill text-success"></i>
                </div>
                <h3 class="status-message">Status Modul</h3>
                
                <div class="status-details">
                  <div class="status-detail-item">
                    <span>Nama Mahasiswa:</span>
                    <strong id="student-name">-</strong>
                  </div>
                  <div class="status-detail-item">
                    <span>Program Studi:</span>
                    <strong id="student-program">-</strong>
                  </div>
                  <div class="status-detail-item">
                    <span>Status Modul:</span>
                    <strong id="module-status">-</strong>
                  </div>
                  <div class="status-detail-item">
                    <span>Tanggal Pengiriman:</span>
                    <strong id="shipping-date">-</strong>
                  </div>
                  <div class="status-detail-item">
                    <span>Estimasi Tiba:</span>
                    <strong id="arrival-date">-</strong>
                  </div>
                </div>
                
                <p class="mt-4">Untuk informasi lebih lanjut tentang modul Anda, silakan hubungi admin SALUT Tana Toraja.</p>
                
                <div class="mt-4">
                  <button class="btn btn-secondary me-2" id="kembaliButton">
                    <i class="bi bi-arrow-left"></i>
                    <span>Cek NIM Lain</span>
                  </button>
                  <a href="https://wa.me/6281354852018" class="btn btn-success" target="_blank">
                    <i class="bi bi-whatsapp"></i>
                    <span>Tanya Admin</span>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Module Pickup Procedure Section -->
      <section class="py-5">
        <div class="container">
          <div class="section-title text-center mb-5">
            <span class="subtitle">Prosedur</span>
            <h2>Cara Pengambilan Modul</h2>
            <p class="mx-auto" style="max-width: 700px;">Ikuti langkah-langkah berikut untuk melakukan pengambilan modul di SALUT Tana Toraja</p>
          </div>
          
          <div class="row">
            <div class="col-lg-8 mx-auto">
              <div class="steps-container">
                <!-- Step 1 -->
                <div class="step-item wow fadeInUp" data-wow-delay="0.1s">
                  <div class="step-number">1</div>
                  <div class="step-content">
                    <h4>Cek Ketersediaan Modul</h4>
                    <p>Gunakan formulir di atas atau hubungi admin SALUT untuk memeriksa apakah modul Anda sudah tersedia.</p>
                  </div>
                </div>
                
                <!-- Step 2 -->
                <div class="step-item wow fadeInUp" data-wow-delay="0.2s">
                  <div class="step-number">2</div>
                  <div class="step-content">
                    <h4>Siapkan Dokumen</h4>
                    <p>Siapkan kartu mahasiswa atau identitas diri (KTP) untuk verifikasi saat pengambilan modul.</p>
                  </div>
                </div>
                
                <!-- Step 3 -->
                <div class="step-item wow fadeInUp" data-wow-delay="0.3s">
                  <div class="step-number">3</div>
                  <div class="step-content">
                    <h4>Kunjungi SALUT Tana Toraja</h4>
                    <p>Datang ke kantor SALUT Tana Toraja pada jam kerja (Senin-Sabtu: 08.30-15.30 WITA).</p>
                  </div>
                </div>
                
                <!-- Step 4 -->
                <div class="step-item wow fadeInUp" data-wow-delay="0.4s">
                  <div class="step-number">4</div>
                  <div class="step-content">
                    <h4>Verifikasi Identitas</h4>
                    <p>Tunjukkan identitas Anda kepada petugas untuk verifikasi data mahasiswa.</p>
                  </div>
                </div>
                
                <!-- Step 5 -->
                <div class="step-item wow fadeInUp" data-wow-delay="0.5s">
                  <div class="step-number">5</div>
                  <div class="step-content">
                    <h4>Tanda Terima Pengambilan</h4>
                    <p>Isi dan tandatangani formulir tanda terima pengambilan modul yang disediakan oleh petugas.</p>
                  </div>
                </div>
                
                <!-- Step 6 -->
                <div class="step-item wow fadeInUp" data-wow-delay="0.6s">
                  <div class="step-number">6</div>
                  <div class="step-content">
                    <h4>Pengambilan Modul</h4>
                    <p>Terima modul Anda dan periksa kelengkapan sesuai dengan mata kuliah yang Anda ambil pada semester berjalan.</p>
                  </div>
                </div>
              </div>
              
              <div class="info-box mt-4 wow fadeInUp" data-wow-delay="0.7s">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <span><strong>Penting:</strong> Modul dapat diambil oleh mahasiswa yang bersangkutan atau dapat diwakilkan.</span>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- FAQ Section -->
      <section class="py-5 bg-light">
        <div class="container">
          <div class="section-title text-center mb-5">
            <span class="subtitle">Tanya Jawab</span>
            <h2>Pertanyaan Umum</h2>
            <p class="mx-auto" style="max-width: 700px;">Temukan jawaban atas pertanyaan umum seputar modul pembelajaran Universitas Terbuka</p>
          </div>
          
          <div class="row">
            <div class="col-lg-8 mx-auto">
              <div class="accordion" id="faqAccordion">
                <!-- FAQ Item 1 -->
                <div class="faq-item wow fadeInUp" data-wow-delay="0.1s">
                  <h2 class="faq-header" id="heading1">
                    <button class="faq-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                      Kapan modul akan dikirim setelah registrasi?
                      <i class="bi bi-chevron-down faq-icon"></i>
                    </button>
                  </h2>
                  <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="heading1" data-bs-parent="#faqAccordion">
                    <div class="faq-body">
                      <p>Modul cetak biasanya dikirim 2-3 minggu setelah periode registrasi mata kuliah berakhir. Waktu pengiriman dapat bervariasi tergantung lokasi dan kondisi pengiriman. Untuk lokasi yang jauh dari kantor pusat, pengiriman dapat memakan waktu hingga 4 minggu.</p>
                    </div>
                  </div>
                </div>
                
                <!-- FAQ Item 2 -->
                <div class="faq-item wow fadeInUp" data-wow-delay="0.2s">
                  <h2 class="faq-header" id="heading2">
                    <button class="faq-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                      Apakah saya harus mengambil modul cetak jika sudah mengakses modul digital?
                      <i class="bi bi-chevron-down faq-icon"></i>
                    </button>
                  </h2>
                  <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#faqAccordion">
                    <div class="faq-body">
                        <p>Ya, Anda tetap harus mengambil modul cetak meskipun sudah mengakses modul digital. Hal ini karena biaya modul cetak sudah termasuk dalam paket SPP yang Anda bayarkan dan tidak bisa dipisahkan. Modul cetak dan digital saling melengkapi dalam proses pembelajaran jarak jauh UT. Modul cetak memiliki beberapa keunggulan seperti kemudahan penggunaan tanpa perlu perangkat elektronik, dapat dibaca kapan saja bahkan saat tidak ada koneksi internet, dan dapat digunakan untuk pembelajaran jangka panjang. Oleh karena itu, sangat disarankan untuk mengambil modul cetak yang sudah menjadi hak Anda sebagai mahasiswa. 📚✨</p>
                    </div>
                  </div>
                </div>
                
                <!-- FAQ Item 3 -->
                <!-- <div class="faq-item wow fadeInUp" data-wow-delay="0.3s">
                  <h2 class="faq-header" id="heading3">
                    <button class="faq-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                      Bagaimana jika modul yang saya terima rusak atau tidak lengkap?
                      <i class="bi bi-chevron-down faq-icon"></i>
                    </button>
                  </h2>
                  <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#faqAccordion">
                    <div class="faq-body">
                      <p>Jika modul yang Anda terima dalam kondisi rusak atau tidak lengkap, segera laporkan ke SALUT Tana Toraja dengan membawa bukti modul yang rusak tersebut. Pihak SALUT akan membantu proses penggantian atau penyelesaiannya. Pelaporan sebaiknya dilakukan maksimal 7 hari setelah menerima modul.</p>
                    </div>
                  </div>
                </div> -->
                
                <!-- FAQ Item 4 -->
                <div class="faq-item wow fadeInUp" data-wow-delay="0.4s">
                  <h2 class="faq-header" id="heading4">
                    <button class="faq-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                      Bisakah orang lain mengambil modul atas nama saya?
                      <i class="bi bi-chevron-down faq-icon"></i>
                    </button>
                  </h2>
                  <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#faqAccordion">
                    <div class="faq-body">
                        <p>Ya, pengambilan modul dapat diwakilkan kepada orang lain (keluarga, teman, atau rekan) tanpa perlu surat kuasa formal. Namun, sebaiknya Anda memberitahu admin SALUT terlebih dahulu melalui WhatsApp atau telepon bahwa akan ada seseorang yang mengambil modul atas nama Anda. 📚✨</p>
                    </div>
                  </div>
                </div>
                
                <!-- FAQ Item 5 -->
                <div class="faq-item wow fadeInUp" data-wow-delay="0.5s">
                  <h2 class="faq-header" id="heading5">
                    <button class="faq-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                      Berapa lama waktu penyimpanan modul di SALUT jika tidak diambil?
                      <i class="bi bi-chevron-down faq-icon"></i>
                    </button>
                  </h2>
                  <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#faqAccordion">
                    <div class="faq-body">
                      <p>Modul yang telah dikirim ke SALUT akan disimpan hingga akhir semester berjalan. Jika tidak diambil hingga batas waktu tersebut, modul akan diarsipkan. Dianjurkan untuk mengambil modul sesegera mungkin setelah informasi ketersediaan diterima.</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Contact Section -->
      <section class="py-5">
        <div class="container">
          <div class="section-title text-center mb-5">
            <span class="subtitle">Kontak</span>
            <h2>Hubungi Admin Modul</h2>
            <p class="mx-auto" style="max-width: 700px;">Untuk informasi lebih lanjut tentang modul pembelajaran, silakan hubungi admin modul SALUT Tana Toraja</p>
          </div>
          
          <div class="row justify-content-center">
            <div class="col-lg-6">
              <div class="module-contact-card wow fadeInUp" data-wow-delay="0.1s">
                <h3 class="module-contact-title text-center mb-4">Informasi Kontak</h3>
                
                <div class="module-contact-info">
                  <div class="module-contact-icon">
                    <i class="bi bi-person-fill"></i>
                  </div>
                  <div>
                    <h5 class="mb-1">Admin Modul</h5>
                    <p class="mb-0">Elza</p>
                  </div>
                </div>
                
                <div class="module-contact-info">
                  <div class="module-contact-icon">
                    <i class="bi bi-whatsapp"></i>
                  </div>
                  <div>
                    <h5 class="mb-1">WhatsApp</h5>
                    <p class="mb-0"><a href="https://wa.me/6281354852018" class="text-primary">+62 813-5485-2018</a></p>
                  </div>
                </div>
                
                <div class="module-contact-info">
                  <div class="module-contact-icon">
                    <i class="bi bi-envelope-fill"></i>
                  </div>
                  <div>
                    <h5 class="mb-1">Email</h5>
                    <p class="mb-0"><a href="mailto:saluttanatoraja@gmail.com" class="text-primary">saluttanatoraja@gmail.com</a></p>
                  </div>
                </div>
                
                <div class="module-contact-info">
                  <div class="module-contact-icon">
                    <i class="bi bi-clock-fill"></i>
                  </div>
                  <div>
                    <h5 class="mb-1">Jam Layanan Pengambilan</h5>
                    <p class="mb-0">Senin - Jumat: 08.00 - 16.00 WITA<br>Sabtu: 09.00 - 13.00 WITA</p>
                  </div>
                </div>
                
                <div class="text-center mt-4">
                  <a href="https://wa.me/6281354852018" class="btn btn-primary" target="_blank">
                    <i class="bi bi-whatsapp me-2"></i>
                    Hubungi via WhatsApp
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!--Start Footer Three-->
      <footer class="footer-three">
        <div class="footer-main footer-main__three">
          <div class="footer-three__shape1">
            <img src="../assets/img/shape/footer-three__shape1.png" alt="shapes" />
          </div>
          <div class="footer-three__shape2">
            <img src="../assets/img/shape/footer-three__shape2.png" alt="shapes" />
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
                        <p class="white-text">
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
                          <p><a href="../tentang/">Tentang UT</a></p>
                        </li>
                        <li>
                          <p><a href="../informasi.php">Informasi Akademik</a></p>
                        </li>
                        <li>
                          <p><a href="../administrasi/">Administrasi</a></p>
                        </li>
                        <li>
                          <p><a href="../tentang/kepalasalut.php">Sapaan dari Kepala SALUT</a></p>
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
                            <a href="../informasi.php">Informasi Akademik</a>
                          </p>
                        </li>
                        <li>
                          <p>
                            <a href="../administrasi/">Administrasi Akademik</a>
                          </p>
                        </li>
                        <li>
                          <p>
                            <a href="../kegiatan.php">Kegiatan</a>
                          </p>
                        </li>
                        <li>
                          <p>
                            <a href="../modul/">Pengambilan Modul</a>
                          </p>
                        </li>
                        <li>
                          <p>
                            <a href="../suratketerangan/">Surat Keterangan</a>
                          </p>
                        </li>
                        <li>
                          <p>
                            <a href="../legalisir/">Legalisir Ijazah</a>
                          </p>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <!--End Single Footer Widget-->

                <!--Start Single Footer Widget-->
                <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".4s">
                  <div class="single-footer-widget single-footer-widget-style2">
                    <div class="title">
                      <h3>Bahan Ajar UT 📚</h3>
                    </div>
                    <div class="footer-module-info">
                      <p>Bahan ajar Universitas Terbuka terdiri dari berbagai jenis yang dapat Anda akses untuk mendukung proses pembelajaran jarak jauh Anda.</p>
                      <div class="footer-module-links">
                        <a href="https://pustaka.ut.ac.id" class="footer-module-btn" target="_blank">
                          <i class="bi bi-laptop"></i> Akses Modul Digital
                        </a>
                        <a href="#check-module" class="footer-module-btn">
                          <i class="bi bi-search"></i> Cek Status Modul
                        </a>
                      </div>
                      <div class="footer-social-icons">
                        <span>Ikuti kami:</span>
                        <a href="https://facebook.com/uttoraja" target="_blank"><i class="bi bi-facebook"></i></a>
                        <a href="https://instagram.com/uttoraja" target="_blank"><i class="bi bi-instagram"></i></a>
                        <a href="https://youtube.com/@SALUTTanaToraja" target="_blank"><i class="bi bi-youtube"></i></a>
                      </div>
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

    <!-- JS here -->
    <script src="../assets/js/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/01-ajax-form.js"></script>
    <script src="../assets/js/03-jquery.appear.js"></script>
    <script src="../assets/js/04-swiper.min.js"></script>
    <script src="../assets/js/05-jquery.odometer.min.js"></script>
    <script src="../assets/js/06-jquery.magnific-popup.min.js"></script>
    <script src="../assets/js/08-slick.min.js"></script>
    <script src="../assets/js/09-wow.min.js"></script>
    <script src="../assets/js/10-jquery.circleType.js"></script>
    <script src="../assets/js/11-jquery.lettering.min.js"></script>
    <script src="../assets/js/12-TweenMax.min.js"></script>
    <script src="../assets/vendor/jarallax/jarallax.min.js"></script>
    <script src="../assets/vendor/marquee/marquee.min.js"></script>
    <script src="../assets/vendor/odometer/odometer.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/main.js"></script>
    
    <script>
      // Fixed Preloader Script - Solves the stuck preloader issue 🛠️
      $(window).on('load', function() {
        // Hide preloader with fade effect
        setTimeout(function() {
          $('#preloader').addClass('preloader-hide');
        }, 500);
        
        // Completely remove preloader after animation completes
        setTimeout(function() {
          $('#preloader').remove();
        }, 1000);
      });
      
      // Backup solution: If load event didn't work, force hide after 5 seconds
      setTimeout(function() {
        if ($('#preloader').length > 0) {
          $('#preloader').addClass('preloader-hide');
          setTimeout(function() {
            $('#preloader').remove();
          }, 500);
        }
      }, 5000);
      
      // Initialize WOW animations
      new WOW().init();
      
      // Initialize datepicker
      $(function() {
        $("#tanggal_lahir").datepicker({
          dateFormat: 'dd/mm/yy',
          changeMonth: true,
          changeYear: true,
          yearRange: "1950:2024",
          maxDate: '0',
          showAnim: 'fadeIn',
          dayNames: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
          dayNamesMin: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
          monthNames: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
          monthNamesShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des']
        });
        
        // NIM validation - numbers only
        $("#nim").on("input", function() {
          this.value = this.value.replace(/\D/g, '');
        });
      });
      
      // Form validation and submission 
      const cekModulForm = document.getElementById('cekModulForm');
      const statusContainer = document.getElementById('status-container');
      const kembaliButton = document.getElementById('kembaliButton');
      
      cekModulForm.addEventListener('submit', function(event) {
        event.preventDefault();
        
        const nim = document.getElementById('nim').value;
        const tanggalLahir = document.getElementById('tanggal_lahir').value;
        
        // Validate NIM
        if (nim.length !== 9 || !/^\d+$/.test(nim)) {
          showToast('NIM harus terdiri dari 9 digit angka', 'error');
          return;
        }
        
        // Validate date format
        if (!isValidDateFormat(tanggalLahir)) {
          showToast('Format tanggal lahir tidak valid. Gunakan format DD/MM/YYYY', 'error');
          return;
        }
        
        // Show loading
        document.querySelector('.btn-check-module').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...';
        document.querySelector('.btn-check-module').disabled = true;
        
        // Simulate checking module status (replace with actual AJAX call)
        setTimeout(function() {
          // Reset button state
          document.querySelector('.btn-check-module').innerHTML = '<i class="bi bi-search"></i><span>Cek Status Modul</span>';
          document.querySelector('.btn-check-module').disabled = false;
          
          // Show result (mock data - replace with actual data from server)
          showModuleStatus({
            name: "Budi Santoso",
            program: "S1 Manajemen",
            status: "Sudah Tersedia",
            shipDate: "15 Mei 2024",
            arrivalDate: "20 Mei 2024"
          });
          
          // Hide form, show results
          cekModulForm.closest('.module-card').style.display = 'none';
          statusContainer.style.display = 'block';
          
          // Scroll to results
          statusContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }, 2000);
      });
      
      kembaliButton.addEventListener('click', function() {
        // Hide results, show form
        cekModulForm.closest('.module-card').style.display = 'block';
        statusContainer.style.display = 'none';
        
        // Reset form
        cekModulForm.reset();
      });
      
      // Function to validate date format DD/MM/YYYY
      function isValidDateFormat(dateString) {
        const pattern = /^(\d{1,2})\/(\d{1,2})\/(\d{4})$/;
        if (!pattern.test(dateString)) return false;
        
        const parts = dateString.split('/');
        const day = parseInt(parts[0], 10);
        const month = parseInt(parts[1], 10);
        const year = parseInt(parts[2], 10);
        
        // Check month range
        if (month < 1 || month > 12) return false;
        
        // Check day range based on month
        const daysInMonth = new Date(year, month, 0).getDate();
        if (day < 1 || day > daysInMonth) return false;
        
        // Validate year is not in the future
        const currentYear = new Date().getFullYear();
        if (year > currentYear) return false;
        
        return true;
      }
      
      // Toast notification helper
      function showToast(message, type = 'info') {
        // Create toast element if it doesn't exist
        if (!document.getElementById('toast-container')) {
          const toastContainer = document.createElement('div');
          toastContainer.id = 'toast-container';
          toastContainer.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 1050;';
          document.body.appendChild(toastContainer);
        }
        
        const toast = document.createElement('div');
        toast.className = `toast bg-${type === 'error' ? 'danger' : type === 'success' ? 'success' : 'info'} text-white`;
        toast.style.cssText = 'min-width: 300px; margin-bottom: 10px; box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.1);';
        
        toast.innerHTML = `
          <div class="toast-header bg-${type === 'error' ? 'danger' : type === 'success' ? 'success' : 'info'} text-white">
            <strong class="me-auto">${type === 'error' ? 'Error' : type === 'success' ? 'Success' : 'Information'}</strong>
            <button type="button" class="btn-close btn-close-white" onclick="this.parentElement.parentElement.remove()"></button>
          </div>
          <div class="toast-body">
            ${message}
          </div>
        `;
        
        document.getElementById('toast-container').appendChild(toast);
        
        // Auto remove toast after 5 seconds
        setTimeout(() => {
          if (toast && toast.parentNode) {
            toast.remove();
          }
        }, 5000);
      }
      
      // Function to display module status
      function showModuleStatus(data) {
        // Update status icon based on status
        const statusIcon = document.querySelector('.status-icon');
        if (data.status === "Sudah Tersedia") {
          statusIcon.innerHTML = '<i class="bi bi-check-circle-fill text-success"></i>';
        } else if (data.status === "Dalam Perjalanan") {
          statusIcon.innerHTML = '<i class="bi bi-truck text-warning"></i>';
        } else {
          statusIcon.innerHTML = '<i class="bi bi-exclamation-circle-fill text-danger"></i>';
        }
        
        // Update status details
        document.getElementById('student-name').textContent = data.name;
        document.getElementById('student-program').textContent = data.program;
        document.getElementById('module-status').textContent = data.status;
        document.getElementById('shipping-date').textContent = data.shipDate || '-';
        document.getElementById('arrival-date').textContent = data.arrivalDate || '-';
        
        // Update status message
        let statusMessage = '';
        if (data.status === "Sudah Tersedia") {
          statusMessage = "Modul Anda telah tersedia dan siap untuk diambil!";
        } else if (data.status === "Dalam Perjalanan") {
          statusMessage = "Modul Anda sedang dalam proses pengiriman.";
        } else {
          statusMessage = "Modul Anda belum tersedia.";
        }
        document.querySelector('.status-message').textContent = statusMessage;
      }
    </script>
    
    <!-- Custom styles for toast notifications -->
    <style>
      #toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1050;
      }
      
      .toast {
        opacity: 1 !important;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        animation: fadeInRight 0.5s ease;
      }
      
      @keyframes fadeInRight {
        0% {
          opacity: 0;
          transform: translateX(20px);
        }
        100% {
          opacity: 1;
          transform: translateX(0);
        }
      }
      
      .toast-header {
        padding: 0.75rem 1.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border: none;
      }
      
      .toast-body {
        padding: 1.25rem;
        font-size: 14px;
        line-height: 1.5;
      }
      
      .btn-close-white {
        filter: invert(1);
        opacity: 0.8;
        transition: opacity 0.3s ease;
      }
      
      .btn-close-white:hover {
        opacity: 1;
      }
      
      /* Fix for datepicker z-index */
      .ui-datepicker {
        z-index: 1051 !important;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        border: none;
      }
      
      .ui-datepicker-header {
        background: var(--thm-primary);
        color: #fff;
        border: none;
      }
      
      .ui-datepicker-calendar th {
        color: var(--thm-black);
      }
      
      .ui-datepicker-calendar .ui-state-default {
        background: #f8f9fa;
        border: 1px solid #eee;
        color: #333;
        text-align: center;
      }
      
      .ui-datepicker-calendar .ui-state-highlight {
        background: var(--thm-primary);
        color: #fff;
        border-color: var(--thm-primary);
      }
    </style>

    <!-- Custom styles for module footer -->
    <style>
      /* Enhanced Footer Styles for Module Page 🎨 */
      .footer-three {
        position: relative;
        z-index: 1;
        margin-top: 50px;
      }
      
      .footer-main__three {
        background-color: #0f172a;
        padding: 80px 0 30px;
        position: relative;
        overflow: hidden;
        color: #e2e8f0;
      }
      
      .footer-three__shape1, 
      .footer-three__shape2 {
        position: absolute;
        opacity: 0.03;
        z-index: 0;
      }
      
      .footer-three__shape1 {
        top: 0;
        right: 0;
        animation: float-slow 8s infinite ease-in-out;
      }
      
      .footer-three__shape2 {
        bottom: 0;
        left: 0;
        animation: float-slow 10s infinite ease-in-out;
      }
      
      @keyframes float-slow {
        0%, 100% {
          transform: translateY(0) rotate(0deg);
        }
        50% {
          transform: translateY(-15px) rotate(5deg);
        }
      }
      
      .single-footer-widget-style2 .title h3 {
        color: #ffffff;
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 28px;
        position: relative;
        display: inline-block;
      }
      
      .single-footer-widget-style2 .title h3:after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -12px;
        height: 3px;
        width: 50px;
        background: var(--thm-primary);
        border-radius: 3px;
      }
      
      .single-footer-widget__about--2 .text {
        margin-bottom: 25px;
      }
      
      .single-footer-widget__about--2 ul li {
        position: relative;
        display: flex;
        align-items: flex-start;
        margin-bottom: 18px;
      }
      
      .single-footer-widget__about--2 ul li .icon {
        margin-right: 15px;
        font-size: 18px;
        color: var(--thm-primary);
        flex-shrink: 0;
        margin-top: 5px;
      }
      
      .single-footer-widget__about--2 ul li p,
      .single-footer-widget__about--2 ul li p a {
        color: #e2e8f0;
        transition: all 0.3s ease;
      }
      
      .single-footer-widget__about--2 ul li p a:hover {
        color: var(--thm-primary);
      }
      
      .single-footer-widget__links-style2 ul li {
        margin-bottom: 12px;
      }
      
      .single-footer-widget__links-style2 ul li p a {
        position: relative;
        color: #e2e8f0;
        padding-left: 18px;
        transition: all 0.3s ease;
      }
      
      .single-footer-widget__links-style2 ul li p a:before {
        content: '';
        position: absolute;
        top: 12px;
        left: 0;
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--thm-primary);
        transform: translateY(-50%);
        transition: all 0.3s ease;
      }
      
      .single-footer-widget__links-style2 ul li p a:hover {
        color: var(--thm-primary);
        padding-left: 22px;
      }
      
      .footer-bottom-three {
        background-color: #0c1322;
        padding: 20px 0;
      }
      
      .footer-bottom__three-inner .copyright-text p {
        color: #cbd5e1;
        margin: 0;
      }
      
      .footer-bottom__three-inner .copyright-text p a {
        color: var(--thm-primary);
        transition: all 0.3s ease;
      }
      
      .footer-bottom__three-inner .copyright-text p a:hover {
        color: #ffffff;
      }
      
      /* Footer module info styles */
      .footer-module-info {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 12px;
        padding: 25px;
        transition: all 0.3s ease;
      }
      
      .footer-module-info:hover {
        background: rgba(255, 255, 255, 0.08);
        transform: translateY(-5px);
      }
      
      .footer-module-links {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin: 20px 0;
      }
      
      .footer-module-btn {
        display: inline-flex;
        align-items: center;
        padding: 10px 18px;
        background: rgba(255, 255, 255, 0.1);
        color: #e2e8f0;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s ease;
      }
      
      .footer-module-btn i {
        margin-right: 10px;
      }
      
      .footer-module-btn:hover {
        background: var(--thm-primary);
        color: #fff;
        transform: translateY(-3px);
      }
      
      .footer-social-icons {
        margin-top: 25px;
        display: flex;
        align-items: center;
        gap: 12px;
      }
      
      .footer-social-icons span {
        font-size: 14px;
        margin-right: 10px;
      }
      
      .footer-social-icons a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        background: rgba(255, 255, 255, 0.08);
        color: #e2e8f0;
        border-radius: 50%;
        transition: all 0.3s ease;
      }
      
      .footer-social-icons a:hover {
        background: var(--thm-primary);
        color: #fff;
        transform: translateY(-3px) rotate(10deg);
      }
      
      /* Responsive adjustments */
      @media (max-width: 991px) {
        .ml55, .ml50 {
          margin-left: 0;
        }
        
        .footer-main__three {
          padding: 60px 0 30px;
        }
        
        .single-footer-widget {
          margin-bottom: 40px;
        }
      }
      
      @media (max-width: 767px) {
        .footer-module-links {
          flex-direction: column;
        }
        
        .footer-module-btn {
          text-align: center;
        }
      }
    </style>
  </body>
</html>
