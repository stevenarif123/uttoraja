<!DOCTYPE html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>CEK MODUL</title>
    <meta name="description" content="" />
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
    <link rel="stylesheet" href="../assets/css/04-nice-select.css" />
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

    <style>
        .contact-field {
            margin-bottom: 1.5rem;
        }
        
        .contact-field label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #333;
        }
        
        .contact-field input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #e4e4e4;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .contact-field input:focus {
            border-color: #4b3da7;
            box-shadow: 0 0 10px rgba(75, 61, 167, 0.1);
        }
        
        .input-description {
            display: block;
            font-size: 0.8rem;
            color: #666;
            margin-top: 0.5rem;
        }
        
        .pnd-btn {
            background: #4b3da7;
            color: #fff;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .pnd-btn:hover {
            background: #3c308a;
        }
        
        #status-container {
            padding: 2rem;
            border-radius: 8px;
            background: #f8f9fa;
        }
        
        #status-text {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }
        
        #status-text.success {
            color: #28a745;
        }
        
        #status-text.error {
            color: #dc3545;
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
                          <li><a href="./">Home</a></li>
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
            <h2>CEK MODUL</h2>
            <ul class="thm-breadcrumb">
              <li>
                <a href="../"><span class="fa fa-home"></span> Home</a>
              </li>
              <li><i class="icon-right-arrow-angle"></i></li>
              <li class="color-base"> Pengecekan Modul</li>
            </ul>
          </div>
        </div>
      </section>
      <!--End Page Header-->

      <!--Start Contents Page-->
      <section id="cek-modul" class="contact-area contact-bg pt-120 pb-100 p-relative fix">
        <div class="container jarakcontainer">
          <div class="row justify-content-center">
            <div class="col-lg-8">
              <div class="contact-bg02">
                <div class="section-title center-align">
                  <h3 style="margin-bottom: 20px;">Formulir Pengecekan Modul</h3>
                </div>
                <form class="contact-form mt-30" id="cekModulForm">
                  <div class="contact-field position-relative mb-4">
                    <label for="nim">Nomor Induk Mahasiswa</label>
                    <input 
                      type="text" 
                      id="nim" 
                      name="nim" 
                      placeholder="Masukkan NIM (9 digit)*" 
                      required 
                      maxlength="9"
                      pattern="\d{9}"
                    />
                    <span class="input-description">NIM harus terdiri dari 9 angka.</span>
                  </div>

                  <div class="contact-field position-relative mb-4">
                    <label for="tanggal_lahir">Tanggal Lahir</label>
                    <input 
                        type="text" 
                        id="tanggal_lahir" 
                        name="tanggal_lahir" 
                        placeholder="DD/MM/YYYY*" 
                        required 
                        pattern="^(0[1-9]|[12][0-9]|3[01])[/](0[1-9]|1[012])[/](19|20)\d\d$"
                    />
                    <span class="input-description">Format: DD/MM/YYYY (contoh: 31/12/1990)</span>
                  </div>

                  <div class="slider-btn text-center">
                    <button type="submit" class="pnd-btn">
                      <i class="fas fa-search mr-2"></i> Cek Modul
                    </button>
                  </div>
                </form>

                <div id="status-container" style="display: none;" class="text-center mt-4">
                  <div class="status-icon mb-3">
                    <i class="fas fa-check-circle text-success" style="font-size: 48px;"></i>
                  </div>
                  <h3 id="status-text" class="mb-4"></h3>
                  <button class="pnd-btn" id="kembaliButton">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!--End Contents Page-->

      <script>
        // Date validation and formatting
        function isValidDate(dateString) {
            const parts = dateString.split('/');
            if (parts.length !== 3) return false;
            
            const day = parseInt(parts[0], 10);
            const month = parseInt(parts[1], 10);
            const year = parseInt(parts[2], 10);
            
            const date = new Date(year, month - 1, day);
            return date.getDate() === day && 
                   date.getMonth() === month - 1 && 
                   date.getFullYear() === year &&
                   year >= 1950 && 
                   year <= new Date().getFullYear();
        }

        // Form validation and submission 
        const nimInput = document.getElementById('nim');
        const tanggalInput = document.getElementById('tanggal_lahir');
        const cekModulForm = document.getElementById('cekModulForm');
        const statusContainer = document.getElementById('status-container');
        const statusText = document.getElementById('status-text');
        const kembaliButton = document.getElementById('kembaliButton');

        // Date input handling
        tanggalInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 8) {
                value = value.substr(0, 8);
            }
            if (value.length >= 2) {
                value = value.substr(0, 2) + (value.length > 2 ? '/' + value.substr(2) : '');
            }
            if (value.length >= 5) {
                value = value.substr(0, 5) + (value.length > 5 ? '/' + value.substr(5) : '');
            }
            e.target.value = value;
        });

        // Form submission with date validation
        cekModulForm.addEventListener('submit', function(event) {
            event.preventDefault();
            
            if (nimInput.value.length !== 9) {
                alert('NIM harus terdiri dari 9 angka.');
                return;
            }

            if (!isValidDate(tanggalInput.value)) {
                alert('Format tanggal tidak valid. Gunakan format DD/MM/YYYY');
                return;
            }

            // Convert date format for server (DD/MM/YYYY to YYYY-MM-DD)
            const parts = tanggalInput.value.split('/');
            const serverDate = `${parts[2]}-${parts[1]}-${parts[0]}`;
            
            const formData = new FormData(this);
            formData.set('tanggal_lahir', serverDate);

            // Show loading state
            statusText.textContent = 'Memproses...';
            statusContainer.style.display = 'block';
            cekModulForm.style.display = 'none';

            fetch('cek_modul.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "1") {
                    statusText.innerHTML = '<i class="fas fa-check-circle text-success"></i> SUDAH TERSEDIA';
                    statusText.style.color = 'green';
                } else if (data.status === "0") {
                    statusText.innerHTML = '<i class="fas fa-times-circle text-danger"></i> BELUM TERSEDIA';
                    statusText.style.color = 'red';
                } else {
                    statusText.innerHTML = '<i class="fas fa-exclamation-circle text-warning"></i> Data tidak ditemukan';
                    statusText.style.color = '#856404';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                statusText.innerHTML = '<i class="fas fa-exclamation-triangle text-danger"></i> Terjadi kesalahan';
                statusText.style.color = 'red';
            });
        });

        // Reset form
        kembaliButton.addEventListener('click', function(event) {
            event.preventDefault();
            cekModulForm.reset();
            cekModulForm.style.display = 'block';
            statusContainer.style.display = 'none';
        });

        // Initialize datepicker with Indonesian format
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
        });
      </script>

      <!--Start Footer Three-->
      <footer class="footer-three">
        <!-- Start Footer Main -->
        <div class="footer-main footer-main__three">
          <div class="footer-three__shape1">
            <img src="../img/shape/footer-three__shape1.png" alt="shapes" />
          </div>
          <div class="footer-three__shape2">
            <img src="../assets/img/shape/footer-three__shape2.png" alt="shapes" />
          </div>
          <div class="container">
            <div class="footer-main__inner footer-main-two__inner footer-main-three__inner">
              <div class="row">
                <!--Start Single Footer Widget-->
                <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".1s" style="visibility: visible; animation-delay: 0.1s; animation-name: fadeInUp;">
                  <div class="single-footer-widget single-footer-widget-style2">
                    <div class="title">
                      <h3>Bantuan & Dukungan</h3>
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
    <script src="../assets/js/02-bootstrap.min.js"></script>
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
    <script src="../assets/vendor/jarallax/jarallax.min.js"></script>
    <script src="../assets/vendor/marquee/marquee.min.js"></script>
    <script src="../assets/vendor/odometer/odometer.min.js"></script>

    <script src="../assets/js/jquery-ui.min.js"></script>
    <script src="../assets/js/main.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script>
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
        });
    </script>
  </body>
</html>
