<!DOCTYPE html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Hubungi Kami | Sentra Layanan Universitas Terbuka Tana Toraja</title>
    <meta name="description" content="Hubungi tim SALUT UT Tana Toraja untuk informasi dan bantuan seputar perkuliahan di Universitas Terbuka" />
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
    <link rel="stylesheet" href="../assets/vendor/custom-animate/custom-animate.css" />
    <link rel="stylesheet" href="../assets/vendor/jarallax/jarallax.css" />
    <link rel="stylesheet" href="../assets/vendor/odometer/odometer.min.css" />
    <link rel="stylesheet" href="../assets/fonts/gilroy/stylesheet.css" />

    <link rel="stylesheet" href="../assets/css/style.css" />
    <link rel="stylesheet" href="../assets/css/color1.css" />
    <link rel="stylesheet" href="../assets/css/responsive.css" />
    
    <!-- Add Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    
    <style>
      /* Custom styles for contact page */
      .contact-info-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        padding: 30px;
        height: 100%;
        transition: all 0.3s ease;
      }
      
      .contact-info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      }
      
      .contact-icon {
        width: 70px;
        height: 70px;
        background: rgba(var(--primary-rgb), 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
      }
      
      .contact-icon i {
        font-size: 32px;
        color: var(--thm-primary);
      }
      
      .contact-title {
        font-size: 20px;
        margin-bottom: 15px;
        color: var(--thm-black);
        text-align: center;
      }
      
      .contact-text {
        text-align: center;
        margin-bottom: 15px;
        color: #666;
      }
      
      .contact-link {
        font-weight: 500;
        color: var(--thm-primary);
        text-align: center;
        display: block;
        transition: all 0.3s ease;
      }
      
      .contact-link:hover {
        color: var(--thm-secondary);
      }
      
      /* Form styles */
      .contact-form-box {
        background: #fff;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        border-radius: 10px;
        padding: 40px;
        position: relative;
        overflow: hidden;
        z-index: 1;
      }
      
      .contact-form-shape {
        position: absolute;
        width: 200px;
        height: 200px;
        background: rgba(var(--primary-rgb), 0.05);
        border-radius: 50%;
        z-index: -1;
      }
      
      .shape-1 {
        top: -100px;
        right: -100px;
      }
      
      .shape-2 {
        bottom: -100px;
        left: -100px;
      }
      
      .form-group {
        margin-bottom: 20px;
      }
      
      .form-control {
        height: 55px;
        border: 1px solid #eee;
        border-radius: 8px;
        padding: 10px 20px;
        font-size: 15px;
        transition: all 0.3s ease;
      }
      
      .form-control:focus {
        border-color: var(--thm-primary);
        box-shadow: 0 0 0 3px rgba(var(--primary-rgb), 0.1);
      }
      
      textarea.form-control {
        height: 150px;
        resize: none;
      }
      
      .form-label {
        font-weight: 500;
        margin-bottom: 8px;
        color: #333;
      }
      
      .btn-contact {
        background: var(--thm-primary);
        color: #fff;
        border: none;
        height: 55px;
        border-radius: 8px;
        padding: 0 30px;
        font-size: 16px;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
      }
      
      .btn-contact:hover {
        background: var(--thm-secondary);
        transform: translateY(-3px);
      }
      
      .btn-contact i {
        margin-left: 8px;
      }
      
      /* Map section */
      .map-section {
        padding: 80px 0;
        background-color: #f9fafc;
      }
      
      .map-container {
        height: 450px;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
      }
      
      /* Form alert */
      .alert {
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
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
      
      /* Social media section */
      .social-section {
        background: linear-gradient(135deg, var(--thm-primary) 0%, var(--thm-secondary) 100%);
        padding: 60px 0;
        color: #fff;
      }
      
      .social-title {
        font-size: 28px;
        font-weight: 600;
        margin-bottom: 30px;
        color: #fff;
      }
      
      .social-icons {
        display: flex;
        gap: 20px;
        justify-content: center;
      }
      
      .social-icon {
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: #fff;
        transition: all 0.3s ease;
      }
      
      .social-icon:hover {
        background: #fff;
        color: var(--thm-primary);
        transform: translateY(-5px);
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
        <!-- ... existing code ... -->
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
                    <!-- ... existing code ... -->
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
                            <li class="active"><a href="../kontak/">Kontak</a></li>
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
          <!-- ... existing code ... -->
          <nav class="menu-box">
            <div class="close-btn">
              <i class="fas fa-times"></i>
            </div>
            <div class="nav-logo">
              <a href="../">
                <img
                  src="../assets/img/resource/mobile-menu-logo.png"
                  alt="Logo"
                />
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
            <h2>Hubungi Kami</h2>
            <ul class="thm-breadcrumb">
              <li>
                <a href="../"><span class="fa fa-home"></span> Home</a>
              </li>
              <li><i class="icon-right-arrow-angle"></i></li>
              <li class="color-base">Kontak</li>
            </ul>
          </div>
        </div>
      </section>
      <!--End Page Header-->
      
      <!-- Contact Info Section -->
      <section class="contact-info-section py-5">
        <div class="container">
          <div class="section-title text-center mb-5">
            <span class="subtitle">Bantuan & Informasi</span>
            <h2>Cara Menghubungi Kami</h2>
            <p class="mx-auto" style="max-width: 600px;">Kami siap membantu Anda dengan segala pertanyaan tentang SALUT UT Tana Toraja. Pilih metode kontak yang paling nyaman untuk Anda.</p>
          </div>
          
          <div class="row g-4">
            <!-- Card 1: Phone -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
              <div class="contact-info-card">
                <div class="contact-icon">
                  <i class="bi bi-telephone-fill"></i>
                </div>
                <h3 class="contact-title">Telepon / WhatsApp</h3>
                <p class="contact-text">Hubungi kami via telepon atau WhatsApp untuk jawaban cepat atas pertanyaan Anda.</p>
                <a href="tel:+6281355619225" class="contact-link">+62 813-5561-9225</a>
                <a href="https://wa.me/6281355619225" class="contact-link">Chat via WhatsApp</a>
              </div>
            </div>
            
            <!-- Card 2: Email -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
              <div class="contact-info-card">
                <div class="contact-icon">
                  <i class="bi bi-envelope-fill"></i>
                </div>
                <h3 class="contact-title">Email</h3>
                <p class="contact-text">Kirim email kepada tim kami untuk pertanyaan atau permintaan yang lebih rinci.</p>
                <a href="mailto:saluttanatoraja@gmail.com" class="contact-link">saluttanatoraja@gmail.com</a>
                <a href="mailto:info@uttoraja.com" class="contact-link">info@uttoraja.com</a>
              </div>
            </div>
            
            <!-- Card 3: Location -->
            <div class="col-lg-4 col-md-6 mx-md-auto wow fadeInUp" data-wow-delay="0.3s">
              <div class="contact-info-card">
                <div class="contact-icon">
                  <i class="bi bi-geo-alt-fill"></i>
                </div>
                <h3 class="contact-title">Alamat Kantor</h3>
                <p class="contact-text">Kunjungi kantor kami untuk konsultasi langsung dengan tim SALUT UT Tana Toraja.</p>
                <span class="contact-link">Jl. Buntu Pantan No. 22, Makale, Tana Toraja, Sulawesi Selatan 91811</span>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Contact Form Section -->
      <section class="contact-form-section py-5">
        <div class="container">
          <div class="row g-4 align-items-center">
            <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.1s">
              <div class="pe-lg-5">
                <div class="section-title mb-4">
                  <span class="subtitle">Kirim Pesan</span>
                  <h2>Butuh Informasi atau Bantuan?</h2>
                </div>
                <p class="mb-4">Silakan isi formulir ini untuk mengirimkan pertanyaan, saran, atau permintaan Anda kepada tim kami. Kami akan merespons pesan Anda secepat mungkin. Anda juga dapat menghubungi kami melalui telepon atau WhatsApp untuk bantuan yang lebih cepat.</p>
                
                <div class="d-flex mb-4">
                  <div class="me-3 mt-1">
                    <i class="bi bi-check-circle-fill text-primary fs-4"></i>
                  </div>
                  <div>
                    <h5 class="mb-2">Jam Operasional</h5>
                    <p>Senin - Jumat: 08.00 - 16.00 WITA<br>Sabtu: 09.00 - 13.00 WITA<br>Minggu & Hari Libur: Tutup</p>
                  </div>
                </div>
                
                <div class="d-flex mb-4">
                  <div class="me-3 mt-1">
                    <i class="bi bi-check-circle-fill text-primary fs-4"></i>
                  </div>
                  <div>
                    <h5 class="mb-2">Respons Cepat</h5>
                    <p>Kami berusaha merespons semua pertanyaan dalam waktu 1-2 hari kerja. Untuk kebutuhan mendesak, gunakan WhatsApp.</p>
                  </div>
                </div>
                
                <div class="d-flex">
                  <div class="me-3 mt-1">
                    <i class="bi bi-check-circle-fill text-primary fs-4"></i>
                  </div>
                  <div>
                    <h5 class="mb-2">Layanan Online</h5>
                    <p>Nikmati kemudahan layanan online kami untuk administrasi dan informasi akademik.</p>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.2s">
              <div class="contact-form-box">
                <!-- Decorative shapes -->
                <div class="contact-form-shape shape-1"></div>
                <div class="contact-form-shape shape-2"></div>
                
                <!-- Display success or error message -->
                <?php if (isset($_GET['status'])): ?>
                  <div class="alert <?php echo ($_GET['status'] == 'success') ? 'alert-success' : 'alert-danger'; ?>" role="alert">
                    <?php echo ($_GET['status'] == 'success') ? 
                      '<i class="bi bi-check-circle me-2"></i> Pesan Anda telah terkirim! Tim kami akan menghubungi Anda secepatnya.' : 
                      '<i class="bi bi-exclamation-triangle me-2"></i> Terjadi kesalahan saat mengirim pesan. Silakan coba lagi.'; ?>
                  </div>
                <?php endif; ?>
                
                <form action="send_contact.php" method="post" class="contact-form">
                  <div class="row g-4">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama lengkap Anda" required>
                      </div>
                    </div>
                    
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan alamat email Anda" required>
                      </div>
                    </div>
                    
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="phone" class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="Masukkan nomor telepon Anda" required>
                      </div>
                    </div>
                    
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="subject" class="form-label">Subjek</label>
                        <input type="text" class="form-control" id="subject" name="subject" placeholder="Masukkan subjek pesan Anda">
                      </div>
                    </div>
                    
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="message" class="form-label">Pesan <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="message" name="message" rows="5" placeholder="Tulis pesan Anda di sini" required></textarea>
                      </div>
                    </div>
                    
                    <div class="col-md-12">
                      <button type="submit" name="submit" class="btn-contact">
                        Kirim Pesan
                        <i class="bi bi-send-fill"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Map Section -->
      <section class="map-section">
        <div class="container">
          <div class="section-title text-center mb-5">
            <span class="subtitle">Lokasi</span>
            <h2>Temukan Kami</h2>
            <p class="mx-auto" style="max-width: 600px;">Kunjungi kantor SALUT UT Tana Toraja untuk konsultasi langsung dengan tim kami.</p>
          </div>
          
          <div class="map-container wow fadeInUp" data-wow-delay="0.1s">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15960.009343150962!2d119.82967791331788!3d-3.096392578357006!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2d93ef675a92e0cd%3A0x162ed84e537c84db!2sMakale%2C%20Tana%20Toraja%20Regency%2C%20South%20Sulawesi!5e0!3m2!1sen!2sid!4v1649508419179!5m2!1sen!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
          
          <div class="text-center mt-4">
            <a href="https://goo.gl/maps/YourGoogleMapsLink" target="_blank" class="btn-contact">
              Dapatkan Petunjuk Arah
              <i class="bi bi-map"></i>
            </a>
          </div>
        </div>
      </section>
      
      <!-- Social Media Section -->
      <section class="social-section">
        <div class="container">
          <div class="text-center">
            <h3 class="social-title">Ikuti Kami di Media Sosial</h3>
            <div class="social-icons">
              <a href="https://www.facebook.com/uttoraja" class="social-icon" target="_blank">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a href="#" class="social-icon" target="_blank">
                <i class="fab fa-twitter"></i>
              </a>
              <a href="https://www.instagram.com/uttoraja/" class="social-icon" target="_blank">
                <i class="fab fa-instagram"></i>
              </a>
              <a href="https://www.youtube.com/@SALUTTanaToraja" class="social-icon" target="_blank">
                <i class="fab fa-youtube"></i>
              </a>
            </div>
          </div>
        </div>
      </section>

      <!--Start Footer Three-->
      <footer class="footer-three">
        <!-- ... existing code ... -->
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

    <!--Start Search Popup -->
    <div class="search-popup">
      <!-- ... existing code ... -->
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
        // Form validation enhancement
        $('form.contact-form').on('submit', function(e) {
          const name = $('#name').val().trim();
          const email = $('#email').val().trim();
          const phone = $('#phone').val().trim();
          const message = $('#message').val().trim();
          
          let isValid = true;
          
          // Simple validation
          if (name === '') {
            $('#name').addClass('is-invalid');
            isValid = false;
          } else {
            $('#name').removeClass('is-invalid');
          }
          
          if (email === '' || !isValidEmail(email)) {
            $('#email').addClass('is-invalid');
            isValid = false;
          } else {
            $('#email').removeClass('is-invalid');
          }
          
          if (phone === '') {
            $('#phone').addClass('is-invalid');
            isValid = false;
          } else {
            $('#phone').removeClass('is-invalid');
          }
          
          if (message === '') {
            $('#message').addClass('is-invalid');
            isValid = false;
          } else {
            $('#message').removeClass('is-invalid');
          }
          
          if (!isValid) {
            e.preventDefault();
          }
        });
        
        // Email validation helper
        function isValidEmail(email) {
          const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
          return re.test(email);
        }
        
        // Convert input to uppercase if needed
        function toUpperCase(input) {
          input.value = input.value.toUpperCase();
        }
        
        // Phone number formatter
        $('#phone').on('input', function() {
          let value = $(this).val().replace(/\D/g, ''); // Remove non-digits
          
          // Format with hyphens
          if (value.length > 3 && value.length <= 6) {
            value = value.slice(0, 3) + '-' + value.slice(3);
          } else if (value.length > 6) {
            value = value.slice(0, 3) + '-' + value.slice(3, 6) + '-' + value.slice(6);
          }
          
          $(this).val(value);
        });
        
        // Add floating animation to contact icons
        $('.contact-icon').addClass('floating');
        
        // Add animations to social icons on hover
        $('.social-icon').hover(
          function() {
            $(this).css('transform', 'translateY(-5px) rotate(10deg)');
          },
          function() {
            $(this).css('transform', 'translateY(0) rotate(0deg)');
          }
        );
      });
    </script>
  </body>
</html>