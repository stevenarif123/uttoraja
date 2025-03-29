<!DOCTYPE html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Legalisir Ijazah & Transkrip | Sentra Layanan Universitas Terbuka Tana Toraja</title>
    <meta name="description" content="Layanan legalisir ijazah dan transkrip bagi alumni Universitas Terbuka di SALUT Tana Toraja" />
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
    
    <style>
      /* Custom styles for legalisir page */
      .legalisir-hero {
        background: var(--thm-secondary);
        background-size: cover;
        background-position: center;
        padding: 100px 0;
        color: #fff;
        margin-bottom: 50px;
        border-radius: 10px;
        position: relative;
        overflow: hidden;
      }
      
      .legalisir-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        padding: 30px;
        height: 100%;
        transition: all 0.3s ease;
      }
      
      .legalisir-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      }
      
      .legalisir-icon {
        width: 80px;
        height: 80px;
        background: rgba(var(--primary-rgb), 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
      }
      
      .legalisir-icon i {
        font-size: 36px;
        color: var(--thm-primary);
      }
      
      .legalisir-title {
        font-size: 22px;
        margin-bottom: 15px;
        font-weight: 600;
        text-align: center;
      }
      
      .legalisir-text {
        color: #666;
        margin-bottom: 25px;
      }
      
      .step-box {
        display: flex;
        margin-bottom: 20px;
        padding: 20px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
      }
      
      .step-box:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      }
      
      .step-number {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: var(--thm-primary);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        font-weight: 600;
        margin-right: 20px;
        flex-shrink: 0;
      }
      
      .step-content h4 {
        font-size: 18px;
        margin-bottom: 8px;
      }
      
      .document-list {
        margin-bottom: 30px;
      }
      
      .document-item {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px dashed #eee;
      }
      
      .document-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
      }
      
      .document-icon {
        width: 40px;
        height: 40px;
        background: rgba(var(--primary-rgb), 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        flex-shrink: 0;
      }
      
      .document-icon i {
        font-size: 18px;
        color: var(--thm-primary);
      }
      
      .document-content h5 {
        font-size: 16px;
        margin-bottom: 5px;
      }
      
      .document-content p {
        font-size: 14px;
        color: #666;
        margin: 0;
      }
      
      .info-card {
        position: relative;
        padding: 25px;
        background: #f8f9fa;
        border-radius: 10px;
        border-left: 4px solid var(--thm-primary);
        margin-bottom: 30px;
      }
      
      .info-card-icon {
        position: absolute;
        right: 15px;
        top: 15px;
        font-size: 40px;
        opacity: 0.15;
        color: var(--thm-primary);
      }
      
      .highlight {
        color: var(--thm-primary);
        font-weight: 600;
      }
      
      .pricing-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 30px;
      }
      
      .pricing-table th {
        background-color: var(--thm-primary);
        color: #fff;
        padding: 15px;
        text-align: left;
        font-weight: 600;
      }
      
      .pricing-table th:first-child {
        border-top-left-radius: 8px;
      }
      
      .pricing-table th:last-child {
        border-top-right-radius: 8px;
      }
      
      .pricing-table td {
        padding: 15px;
        border-bottom: 1px solid #eee;
      }
      
      .pricing-table tr:last-child td {
        border-bottom: none;
      }
      
      .pricing-table tr:nth-child(even) {
        background-color: #f8f9fa;
      }
      
      .contact-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        padding: 30px;
        margin-bottom: 30px;
      }
      
      .contact-info {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
      }
      
      .contact-icon {
        width: 40px;
        height: 40px;
        background: rgba(var(--primary-rgb), 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
      }
      
      .contact-icon i {
        font-size: 18px;
        color: var(--thm-primary);
      }
      
      .cta-box {
        background: linear-gradient(135deg, var(--thm-primary) 0%, var(--thm-secondary) 100%);
        padding: 40px;
        border-radius: 10px;
        color: #fff;
        margin: 50px 0;
        position: relative;
        overflow: hidden;
      }
      
      .cta-shape {
        position: absolute;
        width: 150px;
        height: 150px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        z-index: 1;
      }
      
      .shape-1 {
        top: -75px;
        right: -75px;
      }
      
      .shape-2 {
        bottom: -75px;
        left: -75px;
      }
      
      .accordion-item {
        margin-bottom: 15px;
        border: none;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0,0,0,0.05);
      }
      
      .accordion-button {
        padding: 15px 20px;
        font-weight: 500;
        border-radius: 8px;
        background: #fff;
      }
      
      .accordion-button:not(.collapsed) {
        background-color: var(--thm-primary);
        color: #fff;
      }
      
      .accordion-body {
        padding: 20px;
        background-color: #f8f9fa;
      }
      
      /* Animation for elements */
      .floating {
        animation: floating 3s infinite ease-in-out;
      }
      
      @keyframes floating {
        0%, 100% {
          transform: translateY(0);
        }
        50% {
          transform: translateY(-10px);
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
                                <li class="active"><a href="../legalisir/">Legalisir Ijazah</a></li>
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
                            <li><a href="../kontak/">Kontak</a></li>
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
            <h2>Legalisir Ijazah & Transkrip</h2>
            <ul class="thm-breadcrumb">
              <li>
                <a href="../"><span class="fa fa-home"></span> Home</a>
              </li>
              <li><i class="icon-right-arrow-angle"></i></li>
              <li>Layanan</li>
              <li><i class="icon-right-arrow-angle"></i></li>
              <li class="color-base">Legalisir Ijazah</li>
            </ul>
          </div>
        </div>
      </section>
      <!--End Page Header-->

      <!-- Hero Section -->
      <section class="pb-5">
        <div class="container">
          <div class="legalisir-hero wow fadeIn" data-wow-delay="0.1s">
            <div class="container text-center">
              <div class="row justify-content-center">
                <div class="col-lg-8">
                  <h1 class="text-white display-5 fw-bold mb-4">Layanan Legalisir Dokumen Akademik</h1>
                  <p class="text-white lead fs-5 mb-4">Tersedia layanan legalisir ijazah, transkrip nilai dan dokumen akademik lainnya untuk alumni Universitas Terbuka di SALUT Tana Toraja</p>
                  <a href="#prosedur" class="thm-btn">
                    <span class="txt">Lihat Prosedur</span>
                    <i class="bi bi-arrow-down-circle ms-2"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Services Section -->
      <section class="services-section py-5">
        <div class="container">
          <div class="section-title text-center mb-5">
            <span class="subtitle">Layanan Legalisir</span>
            <h2>Dokumen Yang Dapat Dilegalisir</h2>
            <p class="mx-auto mt-3" style="max-width: 700px;">SALUT Tana Toraja menyediakan layanan legalisir untuk berbagai dokumen akademik Universitas Terbuka</p>
          </div>
          
          <div class="row g-4">
            <!-- Service Card 1 -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
              <div class="legalisir-card">
                <div class="legalisir-icon">
                  <i class="bi bi-mortarboard-fill"></i>
                </div>
                <h3 class="legalisir-title">Ijazah</h3>
                <p class="legalisir-text">Legalisir ijazah untuk keperluan resmi termasuk melamar pekerjaan, kenaikan pangkat, atau melanjutkan studi ke jenjang yang lebih tinggi. Dapat legalisir secara online atau dikirim ke Makassar</p>
                <a href="#prosedur" class="btn btn-outline-primary d-block">Lihat Prosedur</a>
              </div>
            </div>
            
            <!-- Service Card 2 -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
              <div class="legalisir-card">
                <div class="legalisir-icon">
                  <i class="bi bi-file-earmark-text"></i>
                </div>
                <h3 class="legalisir-title">Transkrip Nilai</h3>
                <p class="legalisir-text">Legalisir transkrip nilai asli yang menunjukkan hasil studi dan nilai yang diperoleh selama masa studi di Universitas Terbuka.</p>
                <a href="#prosedur" class="btn btn-outline-primary d-block">Lihat Prosedur</a>
              </div>
            </div>
            
            <!-- Service Card 3 -->
            <div class="col-lg-4 col-md-6 mx-md-auto wow fadeInUp" data-wow-delay="0.3s">
              <div class="legalisir-card">
                <div class="legalisir-icon">
                  <i class="bi bi-file-earmark-check"></i>
                </div>
                <h3 class="legalisir-title">Dokumen Lainnya</h3>
                <p class="legalisir-text">Legalisir dokumen akademik lainnya seperti Surat Akta IV, Surat Keterangan Pendamping Ijazah (SKPI), sertifikat, dan dokumen pendukung lainnya.</p>
                <a href="#prosedur" class="btn btn-outline-primary d-block">Lihat Prosedur</a>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Procedure Section -->
      <section id="prosedur" class="procedure-section py-5 bg-light">
        <div class="container">
          <div class="section-title text-center mb-5">
            <span class="subtitle">Prosedur</span>
            <h2>Cara Mengajukan Legalisir</h2>
            <p class="mx-auto mt-3" style="max-width: 700px;">Ikuti langkah-langkah berikut untuk mengajukan legalisir dokumen di SALUT Tana Toraja</p>
          </div>
          
          <div class="row">
            <div class="col-lg-8 mx-auto">
              <!-- Step 1 -->
              <div class="step-box wow fadeInUp" data-wow-delay="0.1s">
                <div class="step-number">1</div>
                <div class="step-content">
                  <h4>Siapkan Dokumen Asli</h4>
                  <p>Persiapkan dokumen asli yang akan dilegalisir (ijazah, transkrip nilai, atau dokumen lainnya) atau fotokopi dokumen tersebut sesuai kebutuhan jumlah legalisir.</p>
                </div>
              </div>
              
              <!-- Step 2 -->
              <div class="step-box wow fadeInUp" data-wow-delay="0.2s">
                <div class="step-number">2</div>
                <div class="step-content">
                  <h4>Hubungi Admin Legalisir</h4>
                  <p>Hubungi admin legalisir melalui WhatsApp untuk mengonfirmasi ketersediaan layanan dan membuat janji (appointment) untuk proses legalisir.</p>
                </div>
              </div>
              
              <!-- Step 3 -->
              <div class="step-box wow fadeInUp" data-wow-delay="0.3s">
                <div class="step-number">3</div>
                <div class="step-content">
                  <h4>Kunjungi Kantor SALUT</h4>
                  <p>Datang ke kantor SALUT Tana Toraja sesuai dengan jadwal yang telah disepakati dengan membawa dokumen asli dan fotokopi yang akan dilegalisir.</p>
                </div>
              </div>
              
              <!-- Step 4 -->
              <div class="step-box wow fadeInUp" data-wow-delay="0.4s">
                <div class="step-number">4</div>
                <div class="step-content">
                  <h4>Verifikasi Dokumen</h4>
                  <p>Admin akan melakukan verifikasi keaslian dokumen dengan mencocokkan dokumen asli dengan data yang ada di sistem Universitas Terbuka.</p>
                </div>
              </div>
              
              <!-- Step 5 -->
              <div class="step-box wow fadeInUp" data-wow-delay="0.5s">
                <div class="step-number">5</div>
                <div class="step-content">
                  <h4>Pembayaran Biaya</h4>
                  <p>Lakukan pembayaran biaya legalisir sesuai dengan jumlah dokumen dan lembar yang ingin dilegalisir.</p>
                </div>
              </div>
              
              <!-- Step 6 -->
              <div class="step-box wow fadeInUp" data-wow-delay="0.6s">
                <div class="step-number">6</div>
                <div class="step-content">
                  <h4>Pengambilan Dokumen</h4>
                  <p>Ambil dokumen yang sudah dilegalisir sesuai dengan waktu yang ditentukan oleh admin (biasanya 3-7 hari kerja).</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Required Documents Section -->
      <section class="documents-section py-5">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.1s">
              <div class="pe-lg-4">
                <div class="section-title mb-4">
                  <span class="subtitle">Persyaratan</span>
                  <h2>Dokumen Yang Diperlukan</h2>
                </div>
                <p class="mb-4">Untuk mengajukan legalisir dokumen, Anda perlu menyiapkan beberapa dokumen berikut:</p>
                
                <div class="document-list">
                  <!-- Document Item 1 -->
                  <div class="document-item">
                    <div class="document-icon">
                      <i class="bi bi-file-earmark-text"></i>
                    </div>
                    <div class="document-content">
                      <h5>Dokumen Asli</h5>
                      <p>Ijazah, transkrip nilai, atau dokumen lain yang akan dilegalisir (wajib)</p>
                    </div>
                  </div>
                  
                  <!-- Document Item 2 -->
                  <div class="document-item">
                    <div class="document-icon">
                      <i class="bi bi-files"></i>
                    </div>
                    <div class="document-content">
                      <h5>Fotokopi Dokumen</h5>
                      <p>Fotokopi dokumen yang akan dilegalisir sesuai jumlah yang diperlukan</p>
                    </div>
                  </div>
                  
                  <!-- Document Item 3 -->
                  <div class="document-item">
                    <div class="document-icon">
                      <i class="bi bi-person-badge"></i>
                    </div>
                    <div class="document-content">
                      <h5>Kartu Identitas</h5>
                      <p>KTP/SIM/Paspor yang masih berlaku sebagai identifikasi</p>
                    </div>
                  </div>
                  
                  <!-- Document Item 4 -->
                  <div class="document-item">
                    <div class="document-icon">
                      <i class="bi bi-file-earmark-person"></i>
                    </div>
                    <div class="document-content">
                      <h5>Surat Kuasa (jika diwakilkan)</h5>
                      <p>Jika proses legalisir diwakilkan oleh orang lain</p>
                    </div>
                  </div>
                </div>
                
                <div class="info-card">
                  <div class="info-card-icon">
                    <i class="bi bi-info-circle"></i>
                  </div>
                  <h5>Catatan Penting</h5>
                  <p>Semua dokumen asli akan langsung dikembalikan setelah proses pengajuan legalisir selesai. Dokumen yang dilegalisir adalah fotokopi dari dokumen asli tersebut.</p>
                </div>
              </div>
            </div>
            
            <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.2s">
              <div class="ps-lg-4">
                <div class="section-title mb-4">
                  <span class="subtitle">Biaya</span>
                  <h2>Tarif Legalisir</h2>
                </div>
                <p class="mb-4">Berikut adalah biaya legalisir dokumen di SALUT Tana Toraja:</p>
                
                <table class="pricing-table">
                  <thead>
                    <tr>
                      <th>Jenis Dokumen</th>
                      <th>Biaya Legalisir</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Legalisir Online(Ijazah dan Transkrip Nilai)</td>
                      <td>Rp 150.000</td>
                    </tr>
                    <tr>
                      <td>Legalisir Offline (Kirim ke UPBJJ Makassar)</td>
                      <td>Rp 235.000 (10 Lembar)</td>
                    </tr>
                  </tbody>
                </table>
                
                <div class="info-card">
                  <div class="info-card-icon">
                    <i class="bi bi-credit-card"></i>
                  </div>
                  <h5>Metode Pembayaran</h5>
                  <p>Pembayaran dapat dilakukan secara tunai di kantor SALUT Tana Toraja saat pengajuan legalisir.</p>
                </div>
                
                <div class="info-card">
                  <div class="info-card-icon">
                    <i class="bi bi-clock"></i>
                  </div>
                  <h5>Waktu Proses</h5>
                  <p>Proses legalisir membutuhkan waktu <span class="highlight">3-7 hari kerja</span> tergantung dari proses sistem atau dengan UPBJJ.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- CTA Section -->
      <section class="cta-section py-5">
        <div class="container">
          <div class="cta-box wow fadeInUp" data-wow-delay="0.1s">
            <div class="cta-shape shape-1"></div>
            <div class="cta-shape shape-2"></div>
            <div class="row align-items-center position-relative z-index-1">
              <div class="col-lg-8">
                <h2 class="mb-3">Butuh Bantuan Legalisir Ijazah? 📑</h2>
                <p class="text-white fs-5 mb-lg-0">Hubungi admin kami sekarang untuk bantuan legalisir ijazah, transkrip, dan dokumen akademik lainnya.</p>
              </div>
              <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                <a href="https://wa.me/6281354852018" class="thm-btn rounded-pill px-4 py-3" target="_blank">
                  <span class="txt">Chat Admin Legalisir</span>
                  <i class="bi bi-whatsapp ms-2"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- FAQ Section -->
      <section class="faq-section py-5">
        <div class="container">
          <div class="section-title text-center mb-5">
            <span class="subtitle">Tanya Jawab</span>
            <h2>Pertanyaan yang Sering Diajukan</h2>
            <p class="mx-auto mt-3" style="max-width: 700px;">Temukan jawaban atas pertanyaan umum seputar legalisir dokumen di SALUT Tana Toraja</p>
          </div>
          
          <div class="row">
            <div class="col-lg-8 mx-auto">
              <div class="accordion" id="faqAccordion">
                <!-- FAQ Item 1 -->
                <div class="accordion-item wow fadeInUp" data-wow-delay="0.1s">
                  <h2 class="accordion-header" id="heading1">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                      <i class="bi bi-question-circle me-2"></i> Apakah legalisir harus dilakukan sendiri atau bisa diwakilkan?
                    </button>
                  </h2>
                  <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="heading1" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                      <p>Ya, layanan legalisir dokumen dapat diwakilkan oleh orang lain tanpa perlu membawa surat kuasa formal! Yang terpenting adalah wakil Anda membawa dokumen asli yang akan dilegalisir, fotokopi dalam jumlah yang dibutuhkan, dan identitas diri yang masih berlaku. Admin kami akan dengan senang hati membantu proses legalisir meskipun bukan pemilik dokumen yang datang langsung. Ini sangat memudahkan alumni yang tinggal jauh atau memiliki kesibukan yang tidak memungkinkan untuk datang secara langsung ke kantor SALUT Tana Toraja! ✨📄</p>
                    </div>
                  </div>
                </div>
                
                <!-- FAQ Item 2 -->
                <div class="accordion-item wow fadeInUp" data-wow-delay="0.2s">
                  <h2 class="accordion-header" id="heading2">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                      <i class="bi bi-question-circle me-2"></i> Berapa lama waktu yang dibutuhkan untuk proses legalisir?
                    </button>
                  </h2>
                  <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        <p>Proses legalisir dokumen memerlukan waktu sekitar <strong>3-7 hari kerja</strong> ⏱️ tergantung pada beban kerja sistem dan kompleksitas verifikasi. Waktu tunggu ini bisa sedikit lebih lama saat terjadi pembaruan sistem di Universitas Terbuka atau pada periode sibuk ketika banyak alumni mengajukan legalisir secara bersamaan. Kami selalu berusaha memproses dokumen Anda secepat mungkin dengan tetap menjaga kualitas dan keabsahan legalisir! 📝✨</p>
                    </div>
                  </div>
                </div>
                
                <!-- FAQ Item 3 -->
                <div class="accordion-item wow fadeInUp" data-wow-delay="0.3s">
                  <h2 class="accordion-header" id="heading3">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                      <i class="bi bi-question-circle me-2"></i> Bisakah saya meminta legalisir dokumen dalam jumlah banyak?
                    </button>
                  </h2>
                  <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        <p>Ya, Anda dapat meminta legalisir dokumen dalam jumlah banyak sesuai kebutuhan Anda. Untuk legalisir online, Anda hanya perlu mencetak sejumlah salinan yang diperlukan setelah proses legalisir selesai. Sementara itu, untuk legalisir offline yang dikirim ke UPBJJ Makassar, Anda perlu menyediakan tambahan fotokopi dari berkas yang akan dilegalisir dan membayar biaya tambahan sebesar Rp 10.000 untuk setiap lembar tambahan. Kami siap membantu Anda mengurus legalisir dokumen dalam jumlah berapapun yang Anda butuhkan! 📑✨</p>
                    </div>
                  </div>
                </div>
    </ul>            
                <!-- FAQ Item 4 -->
                <div class="accordion-item wow fadeInUp" data-wow-delay="0.4s">
                  <h2 class="accordion-header" id="heading4">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                      <i class="bi bi-question-circle me-2"></i> Apakah ada opsi lain selain legalisir offline?
                    </button>
                  </h2>
                  <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                      <p>Ya, SALUT Tana Toraja menyediakan dua opsi layanan legalisir dokumen: online dan offline. 📱💻 Layanan online memiliki masa berlaku 3 bulan dengan biaya tetap Rp 150.000 (tidak tergantung jumlah lembar), sangat praktis untuk kebutuhan mendesak! 🚀 Sementara layanan offline melalui UPBJJ Makassar memiliki masa berlaku lebih lama yaitu 6 bulan dengan biaya Rp 235.000 untuk 10 lembar dokumen. Kedua layanan ini dirancang untuk memudahkan alumni sesuai dengan kebutuhan dan preferensi Anda! ✨ Silahkan konsultasikan dengan admin kami untuk memilih opsi yang paling sesuai dengan kebutuhan Anda. 🤝</p>
                    </div>
                  </div>
                </div>
                
                <!-- FAQ Item 5 -->
                <div class="accordion-item wow fadeInUp" data-wow-delay="0.5s">
                  <h2 class="accordion-header" id="heading5">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                      <i class="bi bi-question-circle me-2"></i> Berapa lama dokumen legalisir berlaku?
                    </button>
                  </h2>
                  <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                      <p>Masa berlaku dokumen legalisir berbeda berdasarkan metode yang Anda pilih! ⏳ Untuk legalisir online, dokumen akan berlaku selama 3 bulan sejak tanggal penerbitan, sementara legalisir offline melalui UPBJJ Makassar memiliki masa berlaku lebih panjang yaitu 6 bulan. Pastikan Anda mempertimbangkan kebutuhan dan timeline penggunaan dokumen saat memilih jenis layanan legalisir yang tepat untuk Anda! 📝✨</p>
                    </div>
                  </div>
                </div>

                <!-- FAQ Item 6 -->
                <div class="accordion-item wow fadeInUp" data-wow-delay="0.4s">
                  <h2 class="accordion-header" id="heading6">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6" aria-expanded="false" aria-controls="collapse4">
                      <i class="bi bi-question-circle me-2"></i> Berapa lembar jumlah legalisir yang dapat dilakukan?
                    </button>
                  </h2>
                  <div id="collapse6" class="accordion-collapse collapse" aria-labelledby="heading6" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        <p>Untuk legalisir online, Anda memiliki fleksibilitas tak terbatas karena hasilnya berupa file PDF yang bisa Anda cetak sesuai kebutuhan! 🖨️ Sementara itu, layanan legalisir offline sudah mencakup 10 lembar legalisir untuk setiap jenis dokumen (ijazah, transkrip nilai, Akta IV) dalam biaya standar. Jika Anda membutuhkan lebih banyak, tersedia opsi penambahan dengan biaya Rp 10.000 per lembar tambahan. Kami siap membantu memenuhi kebutuhan legalisir Anda dalam jumlah berapapun! ✨📑</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Contact Section -->
      <section class="contact-section py-5">
        <div class="container">
          <div class="row g-4 align-items-center">
            <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.1s">
              <div class="pe-lg-5">
                <div class="section-title mb-4">
                  <span class="subtitle">Kontak</span>
                  <h2>Hubungi Admin Legalisir</h2>
                </div>
                <p class="mb-4">Untuk informasi lebih lanjut dan bantuan legalisir dokumen, silakan hubungi admin kami melalui kontak berikut:</p>
                
                <div class="contact-card">
                  <div class="contact-info">
                    <div class="contact-icon">
                      <i class="bi bi-person-fill"></i>
                    </div>
                    <div>
                      <h5 class="mb-1">Admin Legalisir</h5>
                      <p class="mb-0">Elza</p>
                    </div>
                  </div>
                  
                  <div class="contact-info">
                    <div class="contact-icon">
                      <i class="bi bi-whatsapp"></i>
                    </div>
                    <div>
                      <h5 class="mb-1">WhatsApp</h5>
                      <p class="mb-0"><a href="https://wa.me/6281354852018" class="text-primary">+62 813-5485-2018</a></p>
                    </div>
                  </div>
                  
                  <div class="contact-info">
                    <div class="contact-icon">
                      <i class="bi bi-envelope-fill"></i>
                    </div>
                    <div>
                      <h5 class="mb-1">Email</h5>
                      <p class="mb-0"><a href="mailto:saluttanatoraja@gmail.com" class="text-primary">saluttanatoraja@gmail.com</a></p>
                    </div>
                  </div>
                  
                  <div class="contact-info">
                    <div class="contact-icon">
                      <i class="bi bi-clock-fill"></i>
                    </div>
                    <div>
                      <h5 class="mb-1">Jam Layanan</h5>
                      <p class="mb-0">Senin - Jumat: 08.30 - 15.30 WITA<br>Sabtu: 08.30 - 15.30 WITA</p>
                    </div>
                  </div>
                  
                  <div class="mt-4 d-grid">
                    <a href="https://wa.me/6281354852018" class="thm-btn" target="_blank">
                      <span class="txt">Chat Sekarang</span>
                      <i class="bi bi-whatsapp ms-2"></i>
                    </a>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.2s">
              <div class="ps-lg-5">
                <div class="section-title mb-4">
                  <span class="subtitle">Lokasi</span>
                  <h2>Kantor SALUT Tana Toraja</h2>
                </div>
                <div class="map-container rounded-3 shadow-sm overflow-hidden" style="height: 400px;">
                  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3984.0246234317324!2d119.85904430000001!3d-3.0881011999999997!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2d93edf1c2aefbab%3A0x20382e4bc7be4445!2sUniversitas%20Terbuka%20Kabupaten%20Tana%20Toraja!5e0!3m2!1sen!2sid!4v1743245567824!5m2!1sen!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <div class="mt-3 text-center">
                  <p><i class="bi bi-geo-alt-fill text-primary me-2"></i> Jl. Buntu Pantan No. 22, Makale, Tana Toraja, Sulawesi Selatan 91811</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!--Start Footer Three-->
      <footer class="footer-three">
        <!-- Start Footer Main -->
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
              </div>
            </div>
          </div>
          <!-- End Footer Main -->

          <!--Start Footer Bottom -->
          <div class="footer-bottom footer-bottom-two footer-bottom-three">
            <div class="container">
              <div
                class="footer-bottom__inner footer-bottom__two-inner footer-bottom__three-inner"
              >
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/main.js"></script>
    
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
        
        // Add floating animation to icons
        $('.legalisir-icon').addClass('floating');
        
        // Add animation on accordion buttons
        $('.accordion-button').on('click', function() {
          if($(this).hasClass('collapsed')) {
            $(this).find('i.bi-chevron-down').css('transform', 'rotate(0deg)');
          } else {
            $(this).find('i.bi-chevron-down').css('transform', 'rotate(180deg)');
          }
        });
        
        // CTA shapes animation
        function animateCTAShapes() {
          $('.cta-shape').each(function(index) {
            const scale = 0.9 + Math.random() * 0.2; // Random scale between 0.9 and 1.1
            $(this).css({
              'transform': `scale(${scale})`,
              'transition': 'transform 4s ease-in-out'
            });
          });
          
          setTimeout(animateCTAShapes, 4000);
        }
        
        animateCTAShapes();
        
        // Step boxes hover effect
        $('.step-box').hover(
          function() {
            $(this).find('.step-number').css('transform', 'scale(1.1)');
          },
          function() {
            $(this).find('.step-number').css('transform', 'scale(1)');
          }
        );
        
        // Animate counters when in viewport
        $('.counter-number').each(function() {
          const $this = $(this);
          const countTo = $this.attr('data-count');
          
          $({ Counter: 0 }).animate({
            Counter: countTo
          }, {
            duration: 2000,
            easing: 'swing',
            step: function() {
              $this.text(Math.floor(this.Counter));
            },
            complete: function() {
              $this.text(this.Counter);
            }
          });
        });
      });
    </script>
  </body>
</html>
