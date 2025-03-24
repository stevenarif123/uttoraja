<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>AKADEMIK AKADEMIK</title>
  <meta name="description" content="" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <link
    rel="shortcut icon"
    type="image/x-icon"
    href="../assets/img/favicon.png" />
  <!-- Place favicon.ico in the root directory -->

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

  <!-- CSS here -->
  <link rel="stylesheet" href="../assets/css/01-bootstrap.min.css" />
  <link rel="stylesheet" href="../assets/css/02-all.min.css" />
  <link rel="stylesheet" href="../assets/css/03-jquery.magnific-popup.css" />
  <link rel="stylesheet" href="../assets/css/04-nice-select.css" />
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
  
  <!-- Add custom styles for administrasi page -->
  <style>
    /* Contact Cards Styles */
    .contact-card {
      background: #fff;
      transition: all 0.3s ease;
      border-radius: 8px;
    }
    .hover-shadow:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 16px rgba(0,0,0,0.1) !important;
    }
    .icon-box {
      width: 80px;
      height: 80px;
      line-height: 80px;
      border-radius: 50%;
      background: rgba(var(--primary-rgb), 0.1);
      margin: 0 auto;
    }
    .card-info {
      color: #666;
    }
    
    /* FAQ Styles */
    .faq-item {
      margin-bottom: 1rem;
      border: 1px solid #e9e9e9;
      border-radius: 8px;
      overflow: hidden;
    }
    .faq-header {
      margin: 0;
    }
    .faq-button {
      display: flex;
      width: 100%;
      padding: 1.25rem;
      font-size: 1rem;
      color: #212529;
      text-align: left;
      background-color: #fff;
      border: 0;
      border-radius: 0;
      overflow-anchor: none;
      align-items: center;
      justify-content: space-between;
      font-weight: 500;
    }
    .faq-button:not(.collapsed) {
      color: var(--thm-primary);
      background-color: rgba(var(--primary-rgb), 0.05);
    }
    .faq-button:focus {
      z-index: 3;
      border-color: transparent;
      outline: 0;
      box-shadow: none;
    }
    .faq-body {
      padding: 1rem 1.25rem;
      background-color: #f8f9fa;
    }
    
    /* Feature Cards Styles */
    .feature-card {
      background: #fff;
      padding: 2rem;
      border-radius: 8px;
      box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
      transition: all 0.3s ease;
      height: 100%;
    }
    .feature-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
    .feature-icon {
      font-size: 2.5rem;
      margin-bottom: 1.5rem;
      color: var(--thm-primary);
      display: inline-block;
    }
    .feature-title {
      margin-bottom: 1rem;
      font-weight: 600;
    }
    
    /* Section Titles */
    .section-title .subtitle {
      display: inline-block;
      color: var(--thm-primary);
      font-size: 1rem;
      font-weight: 600;
      line-height: 1;
      margin-bottom: 0.75rem;
    }
    .section-title h2 {
      font-size: 2.5rem;
      margin-bottom: 1rem;
      font-weight: 700;
    }
    
    /* Document Cards */
    .document-card {
      transition: all 0.3s ease;
      height: 100%;
    }
    .document-icon i {
      transition: all 0.3s ease;
    }
    
    /* CTA Section */
    .cta-box {
      background: linear-gradient(135deg, var(--thm-primary) 0%, var(--thm-secondary) 100%);
    }
    .cta-shape {
      transition: all 4s ease-in-out;
    }
    
    /* Schedule Table */
    .schedule-table th {
      font-weight: 600;
      background-color: rgba(var(--primary-rgb), 0.1);
    }
    
    /* Location Details */
    .location-details h5 {
      font-size: 1rem;
      font-weight: 600;
      color: var(--thm-primary);
    }
    
    /* Animations */
    .fa-bounce {
      animation: bounce 1s infinite;
    }
    .fa-spin {
      animation: spin 2s infinite linear;
    }
    @keyframes bounce {
      0%, 100% {
        transform: translateY(0);
      }
      50% {
        transform: translateY(-10px);
      }
    }
    @keyframes spin {
      from {
        transform: rotate(0deg);
      }
      to {
        transform: rotate(360deg);
      }
    }
    @keyframes pulse {
      0% {
        transform: scale(1);
        opacity: 1;
      }
      50% {
        transform: scale(1.1);
        opacity: 0.8;
      }
      100% {
        transform: scale(1);
        opacity: 1;
      }
    }
    
    /* Fix for contact area spacing */
    .contact-area {
      margin-bottom: 0 !important;
    }
    .mb-5 {
      margin-bottom: 2rem !important;
    }
    
    /* Responsive adjustments */
    @media (max-width: 767.98px) {
      .section-title h2 {
        font-size: 1.75rem;
      }
      .feature-card, .document-card {
        padding: 1.5rem;
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
                      <i class="icon.youtube"></i>
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
              <img
                src="assets/img/resource/mobile-menu-logo.png"
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
          <h2>ADMINISTRASI AKADEMIK</h2>
          <ul class="thm-breadcrumb">
            <li>
              <a href="../"><span class="fa fa-home"></span> Home</a>
            </li>
            <li><i class="icon-right-arrow-angle"></i></li>
            <li class="color-base">Administrasi Akademik</li>
          </ul>
        </div>
      </div>
    </section>
    <!--End Page Header-->

    <!--Start Contents Page-->
    <section id="contact" class="contact-area contact-bg pt-120 pb-100 p-relative fix mb-80">
      <div class="container">
        <div class="section-intro text-center mb-5">
          <h3 class="fw-bold">Bantuan Administrasi Akademik</h3>
          <p class="lead">Hubungi admin kami sesuai dengan jurusan Anda untuk bantuan administrasi</p> 
        </div>

        <div class="row g-4">
          <!-- Pendas Card -->
          <div class="col-lg-6">
            <div class="contact-card h-100 p-4 rounded-3 shadow-sm hover-shadow">
              <div class="card-content text-center">
                <div class="icon-box mb-4">
                  <span class="icon-graduation display-4 text-primary"></span>
                </div>
                <h4 class="card-title mb-3">Pendidikan Dasar (PENDAS)</h4>
                <div class="card-info mb-4">
                  <p class="mb-1">Program Studi PGSD & PAUD</p>
                  <p class="mb-1">Admin: Elza</p>
                  <p class="text-primary mb-3">081354852018</p>
                </div>
                <a class="thm-btn w-100" href="https://wa.me/6281354852018">
                  <span class="txt">Hubungi via WhatsApp</span>
                  <i class="fab fa-whatsapp ms-2"></i>
                </a>
              </div>
            </div>
          </div>

          <!-- Non-Pendas Card -->
          <div class="col-lg-6">
            <div class="contact-card h-100 p-4 rounded-3 shadow-sm hover-shadow">
              <div class="card-content text-center">
                <div class="icon-box mb-4">
                  <span class="icon-education display-4 text-primary"></span>
                </div>
                <h4 class="card-title mb-3">Non Pendidikan Dasar (NON PENDAS)</h4>
                <div class="card-info mb-4">
                  <p class="mb-1">Semua Program Studi selain PENDAS</p>
                  <p class="mb-1">Admin: Eva</p>
                  <p class="text-primary mb-3">085242460651</p>
                </div>
                <a class="thm-btn w-100" href="https://wa.me/6285242460651">
                  <span class="txt">Hubungi via WhatsApp</span>
                  <i class="fab fa-whatsapp ms-2"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <style>
        .contact-card {
          background: #fff;
          transition: all 0.3s ease;
        }
        .hover-shadow:hover {
          transform: translateY(-5px);
          box-shadow: 0 8px 16px rgba(0,0,0,0.1) !important;
        }
        .icon-box {
          width: 80px;
          height: 80px;
          line-height: 80px;
          border-radius: 50%;
          background: rgba(var(--primary-rgb), 0.1);
          margin: 0 auto;
        }
        .card-info {
          color: #666;
        }
        .thm-btn {
          border-radius: 5px;
        }
        .thm-btn:hover {
          opacity: 0.9;
        }
        .contact-area {
          margin-bottom: 120px !important; /* Add extra bottom spacing */
        }
        .mb-5{
          margin-bottom: 2px !important;
          margin-top: 15px
        }
      </style>
    </section>
    <!--End Contents Page-->
    
    <!-- Admin FAQ Section -->
    <section class="admin-faq-section py-5 bg-light">
      <div class="container">
        <div class="section-title">
          <span class="subtitle">Pertanyaan Umum</span>
          <h2>FAQ Administrasi Akademik</h2>
          <p class="mx-auto mt-3" style="max-width: 700px;">Temukan jawaban atas pertanyaan yang sering diajukan seputar layanan administrasi akademik di SALUT Tana Toraja</p>
        </div>
        
        <div class="row">
          <div class="col-lg-10 mx-auto">
            <div class="accordion" id="faqAccordion">
              <!-- FAQ Item 1 -->
              <div class="faq-item wow fadeInUp" data-wow-delay="0.1s">
                <h2 class="faq-header" id="headingOne">
                  <button class="faq-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <i class="bi bi-question-circle me-2"></i> Berapa lama waktu yang dibutuhkan untuk memproses permintaan administrasi?
                    <i class="bi bi-chevron-down"></i>
                  </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                  <div class="faq-body">
                    <p>Waktu pemrosesan bervariasi tergantung jenis permintaan. Secara umum, permintaan standar seperti verifikasi pembayaran atau registrasi mata kuliah dapat diselesaikan dalam 1-2 hari kerja. Untuk permintaan yang memerlukan koordinasi dengan UT Pusat seperti pengaduan nilai atau permintaan transkrip resmi, mungkin membutuhkan waktu 3-7 hari kerja. Kami selalu berusaha memberikan layanan secepat mungkin dengan tetap memastikan akurasi dan kualitas. ⏱️</p>
                  </div>
                </div>
              </div>
              
              <!-- FAQ Item 2 -->
              <div class="faq-item wow fadeInUp" data-wow-delay="0.2s">
                <h2 class="faq-header" id="headingTwo">
                  <button class="faq-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    <i class="bi bi-question-circle me-2"></i> Dokumen apa yang perlu saya siapkan untuk mengurus administrasi?
                    <i class="bi bi-chevron-down"></i>
                  </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                  <div class="faq-body">
                    <p>Untuk kebanyakan layanan administrasi, Anda perlu menyiapkan: </p>
                    <ul>
                      <li>Kartu Tanda Mahasiswa (KTM) atau bukti identitas yang valid</li>
                      <li>Bukti pembayaran SPP semester berjalan</li>
                      <li>Formulir permintaan layanan yang relevan (akan diberikan oleh admin)</li>
                      <li>Dokumen pendukung tambahan sesuai jenis permintaan (misalnya bukti kelulusan mata kuliah untuk transkrip)</li>
                    </ul>
                    <p>Admin akan memberikan petunjuk lengkap tentang dokumen spesifik yang diperlukan saat Anda mengajukan permintaan. 📄</p>
                  </div>
                </div>
              </div>
              
              <!-- FAQ Item 3 -->
              <div class="faq-item wow fadeInUp" data-wow-delay="0.3s">
                <h2 class="faq-header" id="headingThree">
                  <button class="faq-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    <i class="bi bi-question-circle me-2"></i> Bagaimana jika nilai mata kuliah saya belum keluar setelah ujian?
                    <i class="bi bi-chevron-down"></i>
                  </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                  <div class="faq-body">
                    <p>Jika nilai mata kuliah belum keluar setelah 1-2 bulan dari tanggal ujian, Anda dapat mengikuti langkah-langkah berikut:</p>
                    <ol>
                      <li>Cek status nilai di sistem SIM-UT secara berkala</li>
                      <li>Hubungi admin program studi Anda melalui WhatsApp dengan menyertakan NIM, nama, kode dan nama mata kuliah, serta tanggal ujian</li>
                      <li>Admin akan membantu melakukan pengecekan dan penelusuran nilai ke bagian Pengujian UT</li>
                      <li>Jika diperlukan, admin akan membantu mengajukan pengaduan nilai resmi</li>
                    </ol>
                    <p>Proses penelusuran nilai biasanya memakan waktu 1-3 minggu, tergantung kompleksitas masalah dan respons dari UT Pusat. 📊</p>
                  </div>
                </div>
              </div>
              
              <!-- FAQ Item 4 -->
              <div class="faq-item wow fadeInUp" data-wow-delay="0.4s">
                <h2 class="faq-header" id="headingFour">
                  <button class="faq-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                    <i class="bi bi-question-circle me-2"></i> Apakah layanan administrasi dikenakan biaya tambahan?
                    <i class="bi bi-chevron-down"></i>
                  </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                  <div class="faq-body">
                    <p>Sebagian besar layanan administrasi akademik dasar sudah termasuk dalam biaya kuliah yang Anda bayarkan dan tidak dikenakan biaya tambahan, seperti:</p>
                    <ul>
                      <li>Konsultasi akademik</li>
                      <li>Registrasi mata kuliah reguler</li>
                      <li>Verifikasi pembayaran</li>
                      <li>Pengaduan nilai</li>
                      <li>Informasi jadwal ujian</li>
                    </ul>
                    <p>Namun, beberapa layanan khusus mungkin dikenakan biaya sesuai ketentuan UT, seperti:</p>
                    <ul>
                      <li>Penerbitan transkrip resmi (±Rp 50.000)</li>
                      <li>Legalisir ijazah (±Rp 10.000 per lembar)</li>
                      <li>Penerbitan surat keterangan khusus (±Rp 25.000)</li>
                      <li>Ujian susulan atau perbaikan nilai (sesuai kebijakan UT)</li>
                    </ul>
                    <p>Admin akan selalu menginformasikan biaya yang perlu dibayarkan (jika ada) sebelum memproses permintaan Anda. 💰</p>
                  </div>
                </div>
              </div>
              
              <!-- FAQ Item 5 -->
              <div class="faq-item wow fadeInUp" data-wow-delay="0.5s">
                <h2 class="faq-header" id="headingFive">
                  <button class="faq-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                    <i class="bi bi-question-circle me-2"></i> Bagaimana cara melakukan registrasi mata kuliah untuk semester baru?
                    <i class="bi bi-chevron-down"></i>
                  </button>
                </h2>
                <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                  <div class="faq-body">
                    <p>Untuk melakukan registrasi mata kuliah semester baru, ikuti langkah-langkah berikut:</p>
                    <ol>
                      <li>Konsultasikan rencana studi Anda dengan admin program studi</li>
                      <li>Dapatkan daftar mata kuliah yang tersedia dan disarankan untuk diambil</li>
                      <li>Lakukan pembayaran biaya semester melalui bank yang bekerja sama dengan UT</li>
                      <li>Kirimkan bukti pembayaran dan daftar mata kuliah yang diambil ke admin program studi</li>
                      <li>Admin akan membantu proses registrasi mata kuliah di sistem UT</li>
                      <li>Verifikasi mata kuliah yang telah terdaftar melalui SIM-UT atau melalui admin</li>
                    </ol>
                    <p>Penting untuk memperhatikan jadwal registrasi yang ditetapkan oleh UT setiap semesternya. Keterlambatan registrasi dapat menyebabkan status tidak aktif atau biaya tambahan. 📅</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End Admin FAQ Section -->

    <!-- Features Section -->
    <section class="features-section mt-5">
      <div class="container">
        <div class="section-title">
          <span class="subtitle">Mengapa Memilih Kami</span>
          <h2>Keunggulan Layanan Administrasi SALUT Toraja</h2>
          <p class="mx-auto mt-3" style="max-width: 700px;">Kami berkomitmen memberikan layanan administrasi terbaik untuk mendukung perjalanan akademik Anda</p>
        </div>
        
        <div class="row">
          <div class="col-lg-4 col-md-6 mb-4">
            <div class="feature-card wow fadeInUp" data-wow-delay="0.1s">
              <div class="feature-icon">
                <i class="bi bi-lightning-charge"></i>
              </div>
              <h4 class="feature-title">Respon Cepat ⚡</h4>
              <p>Tim kami berkomitmen memberikan respon dalam waktu kurang dari 24 jam untuk semua permintaan layanan administrasi akademik Anda.</p>
            </div>
          </div>
          
          <div class="col-lg-4 col-md-6 mb-4">
            <div class="feature-card wow fadeInUp" data-wow-delay="0.2s">
              <div class="feature-icon">
                <i class="bi bi-shield-check"></i>
              </div>
              <h4 class="feature-title">Terpercaya 🔐</h4>
              <p>Didukung oleh staf yang terlatih dan berpengalaman, kami menjamin keamanan dan kerahasiaan data Anda selama proses administrasi.</p>
            </div>
          </div>
          
          <div class="col-lg-4 col-md-6 mb-4">
            <div class="feature-card wow fadeInUp" data-wow-delay="0.3s">
              <div class="feature-icon">
                <i class="bi bi-chat-dots"></i>
              </div>
              <h4 class="feature-title">Konsultasi Mudah 💬</h4>
              <p>Dapatkan bantuan administrasi melalui berbagai kanal komunikasi termasuk WhatsApp, email, atau konsultasi tatap muka di kantor SALUT.</p>
            </div>
          </div>
          
          <div class="col-lg-4 col-md-6 mb-4">
            <div class="feature-card wow fadeInUp" data-wow-delay="0.4s">
              <div class="feature-icon">
                <i class="bi bi-graph-up-arrow"></i>
              </div>
              <h4 class="feature-title">Solusi Tepat 📈</h4>
              <p>Kami tidak hanya memproses permintaan administrasi, tapi juga memberikan panduan tepat untuk mengatasi masalah akademik Anda.</p>
            </div>
          </div>
          
          <div class="col-lg-4 col-md-6 mb-4">
            <div class="feature-card wow fadeInUp" data-wow-delay="0.5s">
              <div class="feature-icon">
                <i class="bi bi-clock-history"></i>
              </div>
              <h4 class="feature-title">Fleksibel ⏱️</h4>
              <p>Layanan administrasi yang dapat diakses kapan saja dan dari mana saja, sangat cocok untuk mahasiswa jarak jauh.</p>
            </div>
          </div>
          
          <div class="col-lg-4 col-md-6 mb-4">
            <div class="feature-card wow fadeInUp" data-wow-delay="0.6s">
              <div class="feature-icon">
                <i class="bi bi-person-check"></i>
              </div>
              <h4 class="feature-title">Personalisasi 👤</h4>
              <p>Setiap mahasiswa ditangani sesuai kebutuhan spesifik program studi dan situasi akademiknya oleh admin yang berpengalaman.</p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End Features Section -->

    <!-- Admin Documents Section -->
    <section class="document-section py-5 bg-light">
      <div class="container">
        <div class="section-title">
          <span class="subtitle">Dokumen Penting</span>
          <h2>Dokumen & Formulir Administrasi</h2>
          <p class="mx-auto mt-3" style="max-width: 700px;">Unduh dokumen dan formulir penting untuk keperluan administrasi akademik Anda</p>
        </div>
        
        <div class="row g-4">
          <!-- Document Item 1 -->
          <div class="col-lg-4 col-md-6">
            <div class="document-card p-4 bg-white rounded-3 shadow-sm hover-shadow wow fadeInUp" data-wow-delay="0.1s">
              <div class="d-flex align-items-center mb-3">
                <div class="document-icon me-3">
                  <i class="bi bi-file-earmark-pdf text-danger fs-1"></i>
                </div>
                <div>
                  <h5 class="mb-0">Formulir Registrasi</h5>
                  <span class="text-muted small">PDF, 128KB</span>
                </div>
              </div>
              <p class="mb-3">Digunakan untuk registrasi mata kuliah di setiap awal semester.</p>
              <a href="#" class="btn btn-sm btn-outline-primary d-flex align-items-center justify-content-center">
                <i class="bi bi-download me-2"></i> Unduh Dokumen
              </a>
            </div>
          </div>
          
          <!-- Document Item 2 -->
          <div class="col-lg-4 col-md-6">
            <div class="document-card p-4 bg-white rounded-3 shadow-sm hover-shadow wow fadeInUp" data-wow-delay="0.2s">
              <div class="d-flex align-items-center mb-3">
                <div class="document-icon me-3">
                  <i class="bi bi-file-earmark-excel text-success fs-1"></i>
                </div>
                <div>
                  <h5 class="mb-0">Form Pengaduan Nilai</h5>
                  <span class="text-muted small">XLS, 76KB</span>
                </div>
              </div>
              <p class="mb-3">Untuk mengajukan pengaduan nilai yang belum keluar atau tidak sesuai.</p>
              <a href="#" class="btn btn-sm btn-outline-primary d-flex align-items-center justify-content-center">
                <i class="bi bi-download me-2"></i> Unduh Dokumen
              </a>
            </div>
          </div>
          
          <!-- Document Item 3 -->
          <div class="col-lg-4 col-md-6">
            <div class="document-card p-4 bg-white rounded-3 shadow-sm hover-shadow wow fadeInUp" data-wow-delay="0.3s">
              <div class="d-flex align-items-center mb-3">
                <div class="document-icon me-3">
                  <i class="bi bi-file-earmark-word text-primary fs-1"></i>
                </div>
                <div>
                  <h5 class="mb-0">Surat Keterangan Aktif</h5>
                  <span class="text-muted small">DOCX, 94KB</span>
                </div>
              </div>
              <p class="mb-3">Template surat keterangan aktif kuliah untuk keperluan beasiswa atau instansi.</p>
              <a href="#" class="btn btn-sm btn-outline-primary d-flex align-items-center justify-content-center">
                <i class="bi bi-download me-2"></i> Unduh Dokumen
              </a>
            </div>
          </div>
          
          <!-- Document Item 4 -->
          <div class="col-lg-4 col-md-6">
            <div class="document-card p-4 bg-white rounded-3 shadow-sm hover-shadow wow fadeInUp" data-wow-delay="0.4s">
              <div class="d-flex align-items-center mb-3">
                <div class="document-icon me-3">
                  <i class="bi bi-file-earmark-pdf text-danger fs-1"></i>
                </div>
                <div>
                  <h5 class="mb-0">Formulir Legalisir</h5>
                  <span class="text-muted small">PDF, 112KB</span>
                </div>
              </div>
              <p class="mb-3">Digunakan untuk mengajukan permohonan legalisir ijazah atau transkrip.</p>
              <a href="#" class="btn btn-sm btn-outline-primary d-flex align-items-center justify-content-center">
                <i class="bi bi-download me-2"></i> Unduh Dokumen
              </a>
            </div>
          </div>
          
          <!-- Document Item 5 -->
          <div class="col-lg-4 col-md-6">
            <div class="document-card p-4 bg-white rounded-3 shadow-sm hover-shadow wow fadeInUp" data-wow-delay="0.5s">
              <div class="d-flex align-items-center mb-3">
                <div class="document-icon me-3">
                  <i class="bi bi-file-earmark-text text-secondary fs-1"></i>
                </div>
                <div>
                  <h5 class="mb-0">Panduan Pembayaran SPP</h5>
                  <span class="text-muted small">PDF, 246KB</span>
                </div>
              </div>
              <p class="mb-3">Petunjuk lengkap cara pembayaran SPP melalui berbagai kanal pembayaran.</p>
              <a href="#" class="btn btn-sm btn-outline-primary d-flex align-items-center justify-content-center">
                <i class="bi bi-download me-2"></i> Unduh Dokumen
              </a>
            </div>
          </div>
          
          <!-- Document Item 6 -->
          <div class="col-lg-4 col-md-6">
            <div class="document-card p-4 bg-white rounded-3 shadow-sm hover-shadow wow fadeInUp" data-wow-delay="0.6s">
              <div class="d-flex align-items-center mb-3">
                <div class="document-icon me-3">
                  <i class="bi bi-file-earmark-zip text-warning fs-1"></i>
                </div>
                <div>
                  <h5 class="mb-0">Semua Dokumen</h5>
                  <span class="text-muted small">ZIP, 1.2MB</span>
                </div>
              </div>
              <p class="mb-3">Semua formulir administrasi akademik dalam satu paket file terkompresi.</p>
              <a href="#" class="btn btn-sm btn-outline-primary d-flex align-items-center justify-content-center">
                <i class="bi bi-download me-2"></i> Unduh Semua
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End Admin Documents Section -->
    
    <!-- CTA Section -->
    <section class="cta-section py-5">
      <div class="container">
        <div class="cta-box bg-primary text-white p-5 rounded-3 shadow position-relative overflow-hidden wow fadeInUp" data-wow-delay="0.1s">
          <div class="row align-items-center">
            <div class="col-lg-8">
              <h2 class="mb-3">Butuh Bantuan Administrasi? 📝</h2>
              <p class="fs-5 mb-lg-0">Jangan ragu untuk menghubungi tim administrasi kami untuk mendapatkan bantuan seputar urusan akademik Anda. Kami siap membantu!</p>
            </div>
            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
              <a href="#kontak" class="thm-btn rounded-pill px-4 py-3">
                <span class="txt">Hubungi Admin</span>
                <i class="bi bi-arrow-right-circle ms-2"></i>
              </a>
            </div>
          </div>
          <!-- Animated shapes -->
          <div class="cta-shape shape1" style="position: absolute; top: -20px; right: -20px; width: 150px; height: 150px; border-radius: 50%; background: rgba(255,255,255,0.1); z-index: 0;"></div>
          <div class="cta-shape shape2" style="position: absolute; bottom: -30px; left: -30px; width: 180px; height: 180px; border-radius: 50%; background: rgba(255,255,255,0.1); z-index: 0;"></div>
        </div>
      </div>
    </section>
    <!-- End CTA Section -->

    <!-- Admin Schedule Section -->
    <section class="schedule-section py-5">
      <div class="container">
        <div class="section-title">
          <span class="subtitle">Jam Operasional</span>
          <h2>Jadwal Layanan Administrasi</h2>
          <p class="mx-auto mt-3" style="max-width: 700px;">Layanan administrasi kami tersedia pada jam kerja berikut untuk membantu Anda</p>
        </div>
        
        <div class="row g-4 justify-content-center">
          <div class="col-md-10">
            <div class="schedule-table-wrapper bg-white p-4 rounded-3 shadow-sm wow fadeInUp" data-wow-delay="0.2s">
              <div class="table-responsive">
                <table class="table table-hover schedule-table">
                  <thead class="table-primary">
                    <tr>
                      <th>Hari</th>
                      <th>Jam Layanan</th>
                      <th>Jenis Layanan</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        <span class="fw-bold">Senin - Kamis</span>
                      </td>
                      <td>08:00 - 16:00 WITA</td>
                      <td>Semua layanan administrasi</td>
                    </tr>
                    <tr>
                      <td>
                        <span class="fw-bold">Jumat</span>
                      </td>
                      <td>08:00 - 15:00 WITA</td>
                      <td>Semua layanan administrasi</td>
                    </tr>
                    <tr>
                      <td>
                        <span class="fw-bold">Sabtu</span>
                      </td>
                      <td>09:00 - 13:00 WITA</td>
                      <td>Layanan terbatas (konsultasi & pengambilan dokumen)</td>
                    </tr>
                    <tr class="table-light">
                      <td>
                        <span class="fw-bold">Minggu & Hari Libur</span>
                      </td>
                      <td>Tutup</td>
                      <td>-</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              
              <div class="schedule-notes mt-4 p-3 bg-light rounded-3">
                <h5 class="mb-3"><i class="bi bi-info-circle me-2"></i> Catatan Penting:</h5>
                <ul class="mb-0">
                  <li>Layanan WhatsApp tetap dapat diakses di luar jam kerja, namun respons akan diberikan pada jam kerja berikutnya.</li>
                  <li>Pada masa registrasi dan ujian, jadwal layanan dapat diperpanjang sesuai kebutuhan.</li>
                  <li>Perubahan jadwal layanan akan diinformasikan melalui media sosial resmi SALUT Tana Toraja.</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End Admin Schedule Section -->
    
    <!-- Admin Location Section -->
    <section class="location-section py-5 bg-light">
      <div class="container">
        <div class="section-title">
          <span class="subtitle">Lokasi Kami</span>
          <h2>Kantor Administrasi Akademik</h2>
          <p class="mx-auto mt-3" style="max-width: 700px;">Kunjungi kantor kami untuk konsultasi administrasi langsung dengan tim kami</p>
        </div>
        
        <div class="row g-4">
          <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.1s">
            <div class="location-map rounded-3 shadow-sm overflow-hidden" style="height: 400px;">
              <!-- Replace with a Google Maps embed or any other map service -->
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15960.009343150962!2d119.82967791331788!3d-3.096392578357006!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2d93ef675a92e0cd%3A0x162ed84e537c84db!2sMakale%2C%20Tana%20Toraja%20Regency%2C%20South%20Sulawesi!5e0!3m2!1sen!2sid!4v1649508419179!5m2!1sen!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
          </div>
          <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.2s">
            <div class="location-info bg-white p-4 rounded-3 shadow-sm h-100">
              <h4 class="mb-4">Kantor SALUT Tana Toraja</h4>
              <ul class="location-details list-unstyled">
                <li class="d-flex mb-4">
                  <div class="location-icon me-3">
                    <i class="bi bi-geo-alt-fill text-primary fs-4"></i>
                  </div>
                  <div>
                    <h5 class="mb-1">Alamat</h5>
                    <p class="mb-0">Jl. Buntu Pantan No. 22, Makale, Tana Toraja, Sulawesi Selatan 91811</p>
                  </div>
                </li>
                <li class="d-flex mb-4">
                  <div class="location-icon me-3">
                    <i class="bi bi-telephone-fill text-primary fs-4"></i>
                  </div>
                  <div>
                    <h5 class="mb-1">Telepon</h5>
                    <p class="mb-0">
                      <a href="tel:6281355619225" class="text-body">+62 813-5561-9225</a>
                    </p>
                  </div>
                </li>
                <li class="d-flex mb-4">
                  <div class="location-icon me-3">
                    <i class="bi bi-envelope-fill text-primary fs-4"></i>
                  </div>
                  <div>
                    <h5 class="mb-1">Email</h5>
                    <p class="mb-0">
                      <a href="mailto:saluttanatoraja@gmail.com" class="text-body">saluttanatoraja@gmail.com</a>
                    </p>
                  </div>
                </li>
                <li class="d-flex">
                  <div class="location-icon me-3">
                    <i class="bi bi-building text-primary fs-4"></i>
                  </div>
                  <div>
                    <h5 class="mb-1">Gedung</h5>
                    <p class="mb-0">Gedung SALUT, Lantai 1, Ruang Administrasi Akademik</p>
                  </div>
                </li>
              </ul>
              <div class="mt-4 pt-3 border-top">
                <a href="https://goo.gl/maps/7Z3Z3Z3Z3Z3Z3Z3Z3" target="_blank" class="btn btn-outline-primary d-flex align-items-center justify-content-center w-100">
                  <i class="bi bi-map me-2"></i> Dapatkan Petunjuk Arah
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End Admin Location Section -->

    <!-- Spacer div for extra gap -->
    <div class="spacer-section"></div>

    <style>
      .spacer-section {
        height: 60px; /* Adjustable height for spacing */
        background: transparent;
      }
    </style>

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
              <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".1s" style="visibility: visible; animation-delay: 0.1s; animation-name: fadeInUp;">
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
              <div class="col-xl-2 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
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
                        <p><a href="../layanan/informasi.php">Informasi Akademik</a></p>
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
              <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInUp;">
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
                          <a href="../administrasi">Administrasi Akademik</a>
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
                          <a href="../suratketerangan">Surat Keterangan</a>
                        </p>
                      </li>
                      <li>
                        <p>
                          <a href="../legalisir">Legalisir Ijazah</a>
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
              class="footer-bottom__inner footer-bottom__two-inner footer-bottom__three-inner">
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
  <script src="../assets/js/07-jquery.nice-select.min.js"></script>
  <script src="../assets/js/08-slick.min.js"></script>
  <script src="../assets/js/09-wow.min.js"></script>
  <script src="../assets/js/10-jquery.circleType.js"></script>
  <script src="../assets/js/11-jquery.lettering.min.js"></script>
  <script src="../assets/js/12-TweenMax.min.js"></script>
  <script src="../assets/js/popper.min.js"></script>
  <script src="../assets/vendor/jarallax/jarallax.min.js"></script>
  <script src="../assets/vendor/marquee/marquee.min.js"></script>
  <script src="../assets/vendor/odometer/odometer.min.js"></script>
  <script src="../assets/vendor/progress-bar/knob.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/main.js"></script>
  
  <script>
    // Initialize WOW.js for animations
    new WOW().init();
    
    // Add animation to stat numbers
    $(document).ready(function() {
      // Start counter animation when element is in viewport
      $('.stat-number').each(function() {
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
      
      // Toggle icons on FAQ accordion items
      $('.faq-button').on('click', function() {
        const icon = $(this).find('.bi-chevron-down');
        
        if ($(this).hasClass('collapsed')) {
          icon.css('transform', 'rotate(0deg)');
        } else {
          icon.css('transform', 'rotate(180deg)');
        }
      });
      
      // Service items hover effect enhancement
      $('.service-item').hover(
        function() {
          $(this).find('.service-icon i').css('transform', 'scale(1.2)');
        },
        function() {
          $(this).find('.service-icon i').css('transform', 'scale(1)');
        }
      );
      
      // Add floating animation to shapes
      function animateFloatingShapes() {
        $('.floating-shape').each(function(index) {
          const randomX = Math.random() * 15 - 7.5;
          const randomY = Math.random() * 15 - 7.5;
          
          $(this).css({
            'transform': `translate(${randomX}px, ${randomY}px)`,
            'transition': 'transform 3s ease-in-out'
          });
        });
        
        setTimeout(animateFloatingShapes, 3000);
      }
      
      animateFloatingShapes();
      
      // Timeline item animation on hover
      $('.timeline-item').hover(
        function() {
          $(this).find('.timeline-dot').css('transform', 'scale(1.2)');
        },
        function() {
          $(this).find('.timeline-dot').css('transform', 'scale(1)');
        }
      );
      
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
      
      // Document card hover effect
      $('.document-card').hover(
        function() {
          $(this).find('.document-icon i').addClass('fa-bounce');
        },
        function() {
          $(this).find('.document-icon i').removeClass('fa-bounce');
        }
      );
      
      // Feature card hover effect
      $('.feature-card').hover(
        function() {
          $(this).find('.feature-icon i').addClass('fa-spin');
        },
        function() {
          $(this).find('.feature-icon i').removeClass('fa-spin');
        }
      );
      
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
    });
  </script>
  
  <style>
    .fa-bounce {
      animation: bounce 1s infinite;
    }
    
    .fa-spin {
      animation: spin 2s infinite linear;
    }
    
    @keyframes bounce {
      0%, 100% {
        transform: translateY(0);
      }
      50% {
        transform: translateY(-10px);
      }
    }
    
    @keyframes spin {
      from {
        transform: rotate(0deg);
      }
      to {
        transform: rotate(360deg);
      }
    }
    
    .document-card {
      transition: all 0.3s ease;
    }
    
    .document-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    
    .schedule-table th, .schedule-table td {
      padding: 15px;
    }
    
    .location-details h5 {
      font-size: 1rem;
      font-weight: 600;
      color: var(--thm-secondary);
    }
  </style>
</body>

</html>