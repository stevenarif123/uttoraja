<!DOCTYPE html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Pesan Kepala SALUT | UT Tana Toraja</title>
    <meta name="description" content="Sambutan dan pesan khusus dari Kepala Sentra Layanan Universitas Terbuka (SALUT) Tana Toraja untuk mahasiswa dan calon mahasiswa UT" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link
      rel="shortcut icon"
      type="image/x-icon"
      href="../assets/img/favicon.png"
    />
    <!-- Place favicon.ico in the root directory -->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

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
    
    <!-- Add Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />

    <link rel="stylesheet" href="../assets/css/style.css" />
    <link rel="stylesheet" href="../assets/css/color1.css" />
    <link rel="stylesheet" href="../assets/css/responsive.css" />
    
    <!-- Custom styles for the message page -->
    <style>
        .message-hero {
            position: relative;
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
                        url('../assets/img/background/message-bg.jpg');
            background-size: cover;
            background-position: center;
            padding: 100px 0;
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
            height: 70px;
            background: url('../assets/img/shape/wave-pattern.png') repeat-x;
            background-size: contain;
            opacity: 0.2;
        }
        
        .message-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            padding: 40px;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }
        
        .message-pattern {
            position: absolute;
            top: 0;
            right: 0;
            width: 200px;
            height: 200px;
            background: var(--thm-primary);
            opacity: 0.05;
            border-radius: 70% 30% 30% 70% / 60% 40% 60% 40%;
            z-index: 0;
        }
        
        .message-header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .message-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 25px;
            border: 3px solid var(--thm-primary);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .message-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .message-author h3 {
            margin-bottom: 5px;
            color: var(--thm-black);
        }
        
        .message-author p {
            color: var(--thm-primary);
            font-weight: 500;
            margin-bottom: 0;
        }
        
        .message-content {
            position: relative;
            z-index: 1;
        }
        
        .message-quote {
            position: relative;
            padding: 20px 30px;
            background: rgba(var(--primary-rgb), 0.05);
            border-left: 4px solid var(--thm-primary);
            border-radius: 0 10px 10px 0;
            margin-bottom: 30px;
            font-style: italic;
            color: var(--thm-black);
        }
        
        .message-quote::before {
            content: '\f10d';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            position: absolute;
            top: -15px;
            left: 20px;
            font-size: 24px;
            color: var(--thm-primary);
            opacity: 0.5;
        }
        
        .message-paragraph {
            margin-bottom: 20px;
            line-height: 1.8;
            color: #6c757d;
        }
        
        .message-signature {
            margin-top: 40px;
            text-align: right;
        }
        
        .signature-img {
            max-width: 150px;
            margin-bottom: 10px;
        }
        
        .message-footer {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px dashed #eee;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .message-date {
            color: #6c757d;
            font-style: italic;
        }
        
        .social-links {
            display: flex;
            gap: 10px;
        }
        
        .social-links a {
            width: 40px;
            height: 40px;
            background: rgba(var(--primary-rgb), 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--thm-primary);
            transition: all 0.3s ease;
        }
        
        .social-links a:hover {
            background: var(--thm-primary);
            color: #fff;
            transform: translateY(-3px);
        }
        
        .profile-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            padding: 0;
            margin-bottom: 30px;
            overflow: hidden;
        }
        
        .profile-header {
            background: linear-gradient(135deg, var(--thm-primary) 0%, var(--thm-secondary) 100%);
            padding: 30px;
            color: #fff;
            position: relative;
            overflow: hidden;
        }
        
        .profile-shape {
            position: absolute;
            width: 150px;
            height: 150px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
        }
        
        .shape-1 {
            top: -75px;
            right: -75px;
        }
        
        .shape-2 {
            bottom: -75px;
            left: -75px;
        }
        
        .profile-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 5px solid rgba(255,255,255,0.3);
            overflow: hidden;
            margin: 0 auto 20px;
        }
        
        .profile-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .profile-name {
            text-align: center;
            margin-bottom: 5px;
            font-size: 24px;
        }
        
        .profile-designation {
            text-align: center;
            opacity: 0.9;
            font-size: 16px;
            margin-bottom: 0;
        }
        
        .profile-body {
            padding: 30px;
        }
        
        .profile-info-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px dashed #eee;
        }
        
        .profile-info-item:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }
        
        .profile-info-icon {
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
        
        .profile-info-icon i {
            font-size: 18px;
            color: var(--thm-primary);
        }
        
        .profile-info-content h4 {
            font-size: 16px;
            margin-bottom: 3px;
            color: var(--thm-black);
        }
        
        .profile-info-content p {
            margin-bottom: 0;
            color: #6c757d;
            font-size: 14px;
        }
        
        .credentials-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .credentials-item {
            position: relative;
            padding-left: 28px;
            margin-bottom: 12px;
        }
        
        .credentials-item:last-child {
            margin-bottom: 0;
        }
        
        .credentials-item::before {
            content: '\f058';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            position: absolute;
            left: 0;
            top: 2px;
            color: var(--thm-primary);
        }
        
        .vision-card {
            background: linear-gradient(135deg, var(--thm-primary) 0%, var(--thm-secondary) 100%);
            border-radius: 15px;
            padding: 30px;
            color: #fff;
            position: relative;
            overflow: hidden;
            margin-bottom: 30px;
        }
        
        .vision-shape {
            position: absolute;
            width: 150px;
            height: 150px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            z-index: 0;
        }
        
        .shape-3 {
            top: -75px;
            right: -75px;
        }
        
        .shape-4 {
            bottom: -75px;
            left: -75px;
        }
        
        .vision-content {
            position: relative;
            z-index: 1;
        }
        
        .vision-title {
            font-size: 24px;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 15px;
            color: #fff;
        }
        
        .vision-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: #fff;
            border-radius: 3px;
        }
        
        .vision-text {
            margin-bottom: 0;
            line-height: 1.8;
            opacity: 0.9;
        }
        
        .cta-box {
            background: #fff;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            margin-top: 30px;
            text-align: center;
        }
        
        .cta-title {
            font-size: 22px;
            margin-bottom: 15px;
            color: var(--thm-black);
        }
        
        .cta-text {
            margin-bottom: 20px;
            color: #6c757d;
        }
        
        @media (max-width: 767px) {
            .message-header {
                flex-direction: column;
                text-align: center;
            }
            
            .message-avatar {
                margin-right: 0;
                margin-bottom: 15px;
            }
            
            .message-card,
            .profile-card {
                padding: 20px;
            }
            
            .message-footer {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
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
                              <a href="#">Akademik</a>
                              <ul class="sub-menu">
                                <li><a href="../informasi">Informasi Akademik</a></li>
                                <li><a href="../kalender">Kalender Akademik</a></li>
                                <li><a href="../jurusan.php">Program Studi</a></li>
                                <li><a href="../biaya.php">Biaya Kuliah</a></li>
                              </ul>
                            </li>
                            <li class="menu-item-has-children">
                              <a href="#">Program</a>
                              <ul class="sub-menu">
                                <li><a href="../rpl.php">Rekognisi Pembelajaran Lampau (RPL)</a></li>
                                <li><a href="../reguler.php">Program Reguler</a></li>
                                <li><a href="../pasca.php">Program Pascasarjana</a></li>
                              </ul>
                            </li>
                            <li class="menu-item-has-children">
                              <a href="#">Layanan</a>
                              <ul class="sub-menu">
                                <li><a href="../administrasi/">Administrasi Akademik</a></li>
                                <li><a href="../kegiatan">Kegiatan Akademik</a></li>
                                <li><a href="../modul/">Pengambilan Modul</a></li>
                                <li><a href="../legalisir/">Legalisir Ijazah</a></li>
                                <li><a href="../suratketerangan/">Surat Keterangan</a></li>
                              </ul>
                            </li>
                            <li class="menu-item-has-children active">
                              <a href="#">Tentang</a>
                              <ul class="sub-menu">
                                <li><a href="../tentang/">Universitas Terbuka</a></li>
                                <li><a href="../tentang/salut/">SALUT</a></li>
                                <li><a href="../tentang/saluttator">SALUT Tana Toraja</a></li>
                                <li class="active"><a href="../tentang/kepalasalut">Pesan Kepala SALUT</a></li>
                              </ul>
                            </li>
                            <li><a href="../galeri/">Galeri</a></li>
                            <li><a href="../kontak">Kontak</a></li>
                          </ul>
                        </div>
                      </nav>
                    </div>
                  </div>
                </div>

                <div class="main-header-one__bottom-right">
                <div class="header-btn-box-one">
                  <a class="thm-btn" href="../pendaftaran/">
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
            <h2>Pesan Kepala SALUT</h2>
            <ul class="thm-breadcrumb">
              <li>
                <a href="../"><span class="fa fa-home"></span> Home</a>
              </li>
              <li><i class="icon-right-arrow-angle"></i></li>
              <li>Tentang</li>
              <li><i class="icon-right-arrow-angle"></i></li>
              <li class="color-base">Pesan Kepala SALUT</li>
            </ul>
          </div>
        </div>
      </section>
      <!--End Page Header-->

      <!-- Hero Section -->
      <section class="pb-5">
        <div class="container">
          <div class="message-hero wow fadeIn" data-wow-delay="0.1s">
            <div class="hero-pattern"></div>
            <div class="container text-center">
              <div class="row justify-content-center">
                <div class="col-lg-8">
                  <h1 class="display-5 fw-bold mb-4">Kata Sambutan Kepala SALUT</h1>
                  <p class="text-white lead fs-5 mb-4">Pesan khusus dari Ribka Padang, S.Pd., M.Pd., M.H. sebagai Kepala Sentra Layanan Universitas Terbuka (SALUT) Tana Toraja</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Message Section -->
      <section class="py-5">
        <div class="container">
          <div class="row">
            <!-- Message Column -->
            <div class="col-lg-8 order-2 order-lg-1 wow fadeInLeft" data-wow-delay="0.1s">
              <div class="message-card">
                <div class="message-pattern"></div>
                <div class="message-header">
                  <div class="message-avatar">
                    <img src="../assets/img/team/kepala-salut.jpg" alt="Kepala SALUT">
                  </div>
                  <div class="message-author">
                    <h3>Ribka Padang, S.Pd., M.Pd., M.H.</h3>
                    <p>Kepala SALUT Tana Toraja</p>
                  </div>
                </div>
                
                <div class="message-content">
                  <div class="message-quote">
                    "Pendidikan adalah kunci dalam membuka pintu kesuksesan dan SALUT Tana Toraja hadir untuk memastikan bahwa pendidikan tinggi berkualitas dapat diakses oleh semua kalangan masyarakat di wilayah Tana Toraja dan sekitarnya."
                  </div>
                  
                  <p class="message-paragraph">Assalamualaikum Wr. Wb. dan salam sejahtera bagi kita semua,</p>
                  
                  <p class="message-paragraph">Puji syukur kita panjatkan ke hadirat Tuhan Yang Maha Esa atas segala rahmat dan karunia-Nya sehingga Sentra Layanan Universitas Terbuka (SALUT) Tana Toraja dapat terus berperan aktif dalam pengembangan pendidikan tinggi di wilayah Tana Toraja dan sekitarnya.</p>
                  
                  <p class="message-paragraph">Saya menyambut dengan gembira kehadiran Anda di situs web resmi SALUT Tana Toraja. Sebagai Kepala SALUT Tana Toraja, saya ingin mengucapkan terima kasih atas kepercayaan yang telah diberikan kepada kami dalam melayani kebutuhan pendidikan tinggi melalui sistem pembelajaran jarak jauh yang ditawarkan oleh Universitas Terbuka.</p>
                  
                  <p class="message-paragraph">SALUT Tana Toraja didirikan dengan tujuan untuk memperluas akses pendidikan tinggi berkualitas kepada masyarakat di wilayah Tana Toraja dan sekitarnya. Kami berkomitmen untuk memberikan layanan terbaik bagi mahasiswa dan calon mahasiswa Universitas Terbuka, mulai dari informasi akademik, pendaftaran, administrasi, hingga dukungan selama proses pembelajaran.</p>
                  
                  <p class="message-paragraph">Di era digital seperti sekarang, pendidikan tinggi tidak lagi dibatasi oleh ruang dan waktu. Melalui sistem pembelajaran jarak jauh yang ditawarkan oleh Universitas Terbuka, siapapun dapat melanjutkan pendidikan tinggi tanpa harus meninggalkan kewajiban dan tanggung jawab sehari-hari. Fleksibilitas ini menjadi keunggulan utama yang kami tawarkan.</p>
                  
                  <p class="message-paragraph">Kami menyadari bahwa pendidikan merupakan investasi jangka panjang yang akan memberikan manfaat berkelanjutan bagi kehidupan seseorang. Oleh karena itu, kami selalu berupaya meningkatkan kualitas layanan dan memberikan dukungan maksimal kepada mahasiswa agar dapat menyelesaikan pendidikannya dengan baik.</p>
                  
                  <p class="message-paragraph">Kepada para mahasiswa, saya mengajak untuk terus bersemangat dalam menuntut ilmu dan mengembangkan diri. Tetaplah fokus dan disiplin dalam proses pembelajaran, manfaatkan setiap kesempatan untuk bertanya dan berdiskusi, serta jangan segan untuk menghubungi kami jika membutuhkan bantuan.</p>
                  
                  <p class="message-paragraph">Bagi calon mahasiswa yang sedang mempertimbangkan untuk melanjutkan pendidikan tinggi, saya mengundang Anda untuk bergabung dengan Universitas Terbuka melalui SALUT Tana Toraja. Kami siap membantu dan memberikan informasi yang Anda butuhkan untuk memulai perjalanan pendidikan tinggi Anda.</p>
                  
                  <p class="message-paragraph">Akhir kata, saya berharap SALUT Tana Toraja dapat terus berkontribusi dalam meningkatkan kualitas pendidikan dan sumber daya manusia di wilayah Tana Toraja dan sekitarnya. Mari bersama-sama membangun masa depan yang lebih baik melalui pendidikan berkualitas.</p>
                  
                  <p class="message-paragraph">Terima kasih dan salam hangat,</p>
                  
                  <div class="message-signature">
                    <img src="../assets/img/team/signature-kepala.png" alt="Tanda tangan Kepala SALUT" class="signature-img">
                    <h4>Ribka Padang, S.Pd., M.Pd., M.H.</h4>
                    <p>Kepala SALUT Tana Toraja</p>
                  </div>
                </div>
                
                <div class="message-footer">
                  <div class="message-date">
                    <i class="bi bi-calendar-event me-2"></i> Makale, 1 Mei 2024
                  </div>
                  <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Profile Column -->
            <div class="col-lg-4 order-1 order-lg-2 mb-4 mb-lg-0 wow fadeInRight" data-wow-delay="0.2s">
              <!-- Profile Card -->
              <div class="profile-card">
                <div class="profile-header">
                  <div class="profile-shape shape-1"></div>
                  <div class="profile-shape shape-2"></div>
                  <div class="profile-img">
                    <img src="../assets/img/team/kepala-salut.jpg" alt="Kepala SALUT">
                  </div>
                  <h3 class="profile-name">Ribka Padang, S.Pd., M.Pd., M.H.</h3>
                  <p class="profile-designation">Kepala SALUT Tana Toraja</p>
                </div>
                <div class="profile-body">
                  <div class="profile-info-item">
                    <div class="profile-info-icon">
                      <i class="bi bi-building"></i>
                    </div>
                    <div class="profile-info-content">
                      <h4>Jabatan</h4>
                      <p>Kepala Sentra Layanan Universitas Terbuka Tana Toraja</p>
                    </div>
                  </div>
                  
                  <div class="profile-info-item">
                    <div class="profile-info-icon">
                      <i class="bi bi-mortarboard"></i>
                    </div>
                    <div class="profile-info-content">
                      <h4>Pendidikan</h4>
                      <p>- S1 Pendidikan Guru Bahasa Inggris, Universitas Negeri Makassar</p>
                      <p>- S2 Magister Pendidikan, Universitas Kristen Indonesia Jakarta</p>
                      <p>- S2 Magister Hukum, Universitas Kristen Indonesia Paulus</p>
                    </div>
                  </div>
                  
                  <div class="profile-info-item">
                    <div class="profile-info-icon">
                      <i class="bi bi-briefcase"></i>
                    </div>
                    <div class="profile-info-content">
                      <h4>Pengalaman</h4>
                      <p>Lebih dari 15 tahun di bidang pendidikan tinggi</p>
                    </div>
                  </div>
                  
                  <div class="profile-info-item">
                    <div class="profile-info-icon">
                      <i class="bi bi-envelope"></i>
                    </div>
                    <div class="profile-info-content">
                      <h4>Email</h4>
                      <p><a href="mailto:ribkapadang74ps@gmail.com">ribkapadang74ps@gmail.com</a></p>
                    </div>
                  </div>
                </div>
              </div>
              
              <!-- Credentials Card -->
              <!-- <div class="message-card">
                <div class="message-pattern"></div>
                <h4>Kredensial & Prestasi</h4>
                <ul class="credentials-list">
                  <li>Pelopor Digitalisasi Layanan Akademik UT</li>
                  <li>Pembicara Nasional Pendidikan Jarak Jauh</li>
                  <li>Anggota Dewan Pendidikan Tana Toraja</li>
                  <li>Penggagas Program "UT Menyapa Desa"</li>
                </ul>
              </div> -->
              
              <!-- Vision Card -->
              <div class="vision-card">
                <div class="vision-shape shape-3"></div>
                <div class="vision-shape shape-4"></div>
                <div class="vision-content">
                  <h3 class="vision-title">Visi Kepemimpinan</h3>
                  <p class="text-white vision-text">Menjadikan SALUT Tana Toraja sebagai pusat layanan pendidikan tinggi jarak jauh terdepan yang inovatif, berkualitas, dan terjangkau bagi seluruh lapisan masyarakat di wilayah Tana Toraja dan sekitarnya.</p>
                </div>
              </div>
              
              <!-- CTA Box -->
              <div class="cta-box">
                <h4 class="cta-title">Butuh Informasi Lebih Lanjut?</h4>
                <p class="cta-text">Hubungi kami untuk konsultasi dan informasi tentang program studi Universitas Terbuka.</p>
                <a href="../kontak/" class="thm-btn">
                  <span class="txt">Kontak Kami</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Related Programs Section -->
      <section class="py-5 bg-light">
        <div class="container">
          <div class="section-title text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <span class="subtitle">Program Studi</span>
            <h2>Program Unggulan</h2>
            <p class="mx-auto" style="max-width: 700px;">Beberapa program studi unggulan yang dapat Anda pilih di Universitas Terbuka melalui SALUT Tana Toraja</p>
          </div>
          
          <div class="row g-4">
            <!-- Program Card 1 -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
              <div class="message-card h-100">
                <div class="message-pattern"></div>
                <div class="text-center mb-4">
                  <div class="d-inline-block bg-primary bg-opacity-10 p-3 rounded-circle mb-3">
                    <i class="bi bi-briefcase-fill text-primary fs-3"></i>
                  </div>
                  <h3>S1 Manajemen</h3>
                  <div class="badge bg-primary mb-2">Favorit</div>
                </div>
                <p>Program Studi S1 Manajemen dirancang untuk menghasilkan lulusan yang memiliki kompetensi di bidang manajemen dan bisnis serta mampu bersaing di era global.</p>
                <div class="mt-3">
                  <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-check-circle-fill text-primary me-2"></i>
                    <span>Kurikulum berbasis industri</span>
                  </div>
                  <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-check-circle-fill text-primary me-2"></i>
                    <span>Akreditasi A (Unggul)</span>
                  </div>
                  <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle-fill text-primary me-2"></i>
                    <span>Jaringan alumni tersebar luas</span>
                  </div>
                </div>
                <div class="text-center mt-4">
                  <a href="../pendaftaran/" class="btn btn-outline-primary">Daftar Sekarang</a>
                </div>
              </div>
            </div>
            
            <!-- Program Card 2 -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
              <div class="message-card h-100">
                <div class="message-pattern"></div>
                <div class="text-center mb-4">
                  <div class="d-inline-block bg-success bg-opacity-10 p-3 rounded-circle mb-3">
                    <i class="bi bi-bank2 text-success fs-3"></i>
                  </div>
                  <h3>S1 Akuntansi</h3>
                  <div class="badge bg-success mb-2">Prospektif</div>
                </div>
                <p>Program Studi S1 Akuntansi menyediakan pendidikan yang komprehensif di bidang akuntansi dan keuangan untuk mempersiapkan profesional yang kompeten dan beretika.</p>
                <div class="mt-3">
                  <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                    <span>Akreditasi A (Unggul)</span>
                  </div>
                  <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                    <span>Studi kasus dari industri</span>
                  </div>
                  <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                    <span>Sertifikasi profesi tambahan</span>
                  </div>
                </div>
                <div class="text-center mt-4">
                  <a href="../pendaftaran/" class="btn btn-outline-success">Daftar Sekarang</a>
                </div>
              </div>
            </div>
            
            <!-- Program Card 3 -->
            <div class="col-lg-4 col-md-6 mx-md-auto wow fadeInUp" data-wow-delay="0.3s">
              <div class="message-card h-100">
                <div class="message-pattern"></div>
                <div class="text-center mb-4">
                  <div class="d-inline-block bg-info bg-opacity-10 p-3 rounded-circle mb-3">
                    <i class="bi bi-mortarboard-fill text-info fs-3"></i>
                  </div>
                  <h3>S1 PGSD</h3>
                  <div class="badge bg-info mb-2">Terdepan</div>
                </div>
                <p>Program Studi Pendidikan Guru Sekolah Dasar (PGSD) mempersiapkan guru profesional untuk pendidikan dasar dengan pendekatan yang komprehensif dan inovatif.</p>
                <div class="mt-3">
                  <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-check-circle-fill text-info me-2"></i>
                    <span>Akreditasi A (Unggul)</span>
                  </div>
                  <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-check-circle-fill text-info me-2"></i>
                    <span>Praktek mengajar terintegrasi</span>
                  </div>
                  <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle-fill text-info me-2"></i>
                    <span>Pengembangan karakter pendidik</span>
                  </div>
                </div>
                <div class="text-center mt-4">
                  <a href="../pendaftaran/" class="btn btn-outline-info">Daftar Sekarang</a>
                </div>
              </div>
            </div>
          </div>
          
          <div class="text-center mt-5 wow fadeInUp" data-wow-delay="0.4s">
            <a href="../informasi.php" class="thm-btn">
              <span class="txt">Lihat Semua Program</span>
              <i class="bi bi-arrow-right ms-2"></i>
            </a>
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

                <!--Start Single Footer Widget-->
                <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".4s">
                  <div class="single-footer-widget single-footer-widget-style2">
                    <div class="title">
                      <h3>SALUT Tana Toraja</h3>
                    </div>
                    <div class="single-footer-widget-box single-footer-widget__newsletter">
                      <p>Berlangganan newsletter kami untuk mendapatkan informasi terbaru tentang kegiatan dan layanan SALUT Tana Toraja.</p>
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
        
        // Add hover effect to message card
        $('.message-card').hover(
          function() {
            $(this).css('transform', 'translateY(-10px)');
            $(this).css('box-shadow', '0 15px 40px rgba(0, 0, 0, 0.1)');
          },
          function() {
            $(this).css('transform', 'translateY(0)');
            $(this).css('box-shadow', '0 10px 30px rgba(0, 0, 0, 0.05)');
          }
        );
        
        // Add typing animation to vision text
        let i = 0;
        const visionText = $('.vision-text').text();
        $('.vision-text').text('');
        
        function typeWriter() {
          if (i < visionText.length) {
            $('.vision-text').text($('.vision-text').text() + visionText.charAt(i));
            i++;
            setTimeout(typeWriter, 25);
          }
        }
        
        // Start typing animation when the element is in view
        $('.vision-card').on('inview', function(event, isInView) {
          if (isInView && i === 0) {
            typeWriter();
          }
        });
        
        // Manually trigger for demo purposes
        setTimeout(function() {
          if (i === 0) typeWriter();
        }, 1500);
      });
    </script>
  </body>
</html>
