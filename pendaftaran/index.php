<?php
// Koneksi ke database (ganti dengan informasi koneksi Anda)
require_once '../koneksi.php';

// Ambil data jurusan dari database
$sql = "SELECT nama_program_studi FROM prodi_admisi";
$result = $conn->query($sql);

// Simpan data jurusan dalam array
$jurusanOptions = array();
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $jurusanOptions[] = $row["nama_program_studi"];
  }
}

// Tutup koneksi database
$conn->close();
?>
<!DOCTYPE html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>PENDAFTARAN MAHASISWA BARU SALUT TANA TORAJA</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link
      rel="shortcut icon"
      type="image/x-icon"
      href="../assets/img/favicon.png"
    />
    <!-- Place favicon.ico in the root directory -->

    <link
      href="https://fonts.googleapis.com/css2?family=Inter+Tight:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet"
    />

    <!-- CSS here -->
    <link rel="stylesheet" href="../assets/css/01-bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/css/02-all.min.css" />
    <link rel="stylesheet" href="../assets/css/03-jquery.magnific-popup.css" />
    <!-- <link rel="stylesheet" href="assets/css/04-nice-select.css" /> -->
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
    .dropdown-icon {
      position: absolute;
      top: 50%;
      right: 10px;
      transform: translateY(-50%);
      pointer-events: none;

    a {
      color: black !important;
    }
    }
    </style>
    <script>
      function toUpperCase(input) {
        input.value = input.value.toUpperCase();
      }
    </script>
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
                      <p><a href="tel:1378902167">+6281355619225</a></p>
                    </li>
                    <li>
                      <div class="icon">
                        <span class="icon-email"></span>
                      </div>
                      <p>
                        <a href="mailto:info@saluttoraja.com"
                          >info@saluttoraja.com</a
                        >
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
                    <a href="../index.html">
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
                            <li><a href="../index.html">Home</a></li>
                            <li class="menu-item-has-children">
                              <a href="#">Aplikasi UT</a>
                              <ul class="sub-menu">
                                <li>
                                  <a href="https://elearning.ut.ac.id"
                                    >Elearning/Tuton</a
                                  >
                                </li>
                                <li>
                                  <a href="https://tmk.ut.ac.id"
                                    >Tugas Mata Kuliah (TMK)</a
                                  >
                                </li>
                                <li>
                                  <a href="https://silayar.ut.ac.id"
                                    >SILAYAR UT</a
                                  >
                                </li>
                                <li>
                                  <a href="https://aksi.ut.ac.id">AKSI UT</a>
                                </li>
                                <li>
                                  <a href="https://the.ut.ac.id"
                                    >Take Home Exam (THE)</a
                                  >
                                </li>
                              </ul>
                            </li>
                            <li class="menu-item-has-children">
                              <a href="#">Layanan</a>
                              <ul class="sub-menu">
                                <li><a href="informasi.php">Informasi Akademik</a></li>
                                <li><a href="./administrasi/">Administrasi Akademik</a></li>
                                <li><a href="kegiatan.php">Kegiatan Akademik</a></li>
                                <li><a href="./modul/">Pengambilan Modul</a></li>
                              </ul>
                            </li>
                            <li><a href="./galeri/">Galeri</a></li>
                            <li class="menu-item-has-children">
                              <a href="#">Tentang</a>
                              <ul class="sub-menu">
                                <li><a href="./tentang/tentangut.php">Universitas Terbuka</a></li>
                                <li><a href="./tentang/tentangsalut.php/">SALUT</a></li>
                                <li><a href="./tentang/saluttator.php">SALUT Tana Toraja</a></li>
                                <li><a href="./tentang/kepalasalut.php">Pesan Kepala SALUT</a></li>
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
              <a href="index.html">
                <img
                  src="assets/img/resource/mobile-menu-logo.png"
                  alt="Logo"
                />
              </a>
            </div>
            <div class="menu-outer">
              <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
            </div>
            <div class="contact-info">
              <div class="icon-box"><span class="icon-phone-call"></span></div>
              <p><a href="tel:+6281355619225">+6281355619225</a></p>
            </div>
            <div class="social-links">
              <ul class="clearfix list-wrap">
                <li>
                  <a href="https://www.facebook.com/uttoraja"
                    ><i class="fab fa-facebook-f"></i
                  ></a>
                </li>
                <li>
                  <a href="#"><i class="fab fa-twitter"></i></a>
                </li>
                <li>
                  <a href="https://www.instagram.com/uttoraja/"
                    ><i class="fab fa-instagram"></i
                  ></a>
                </li>
                <li>
                  <a href="https://www.youtube.com/@SALUTTanaToraja"
                    ><i class="fab fa-youtube"></i
                  ></a>
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
            <h2>Pendaftaran Mahasiswa Baru</h2>
            <ul class="thm-breadcrumb">
              <li>
                <a href="index.html"><span class="fa fa-home"></span> Home</a>
              </li>
              <li><i class="icon-right-arrow-angle"></i></li>
              <li class="color-base">Pendaftaran</li>
            </ul>
          </div>
        </div>
      </section>
      <!--End Page Header-->

      <!--Start Contact Page-->
      <section
        id="contact"
        class="contact-area contact-bg pt-120 pb-100 p-relative fix"
      >
        <div class="container jarakcontainer">
          <div class="row justify-content-center">
            <div class="col-lg-8">
              <div class="contact-bg02">
                <div class="section-title center-align">
                  <h3 style="margin-bottom: 20px;">Formulir Pendaftaran</h3>
                </div>

                <form
                  action="pendaftaran.php"
                  method="post"
                  class="contact-form mt-30"
                >
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="contact-field position-relative c-name mb-4">
                        <input
                          type="text"
                          id="firstn"
                          name="firstn"
                          placeholder="Nama Lengkap*"
                          required
                          oninput="toUpperCase(this)"
                        />
                      </div>
                    </div>

                    <div class="col-lg-12">
                      <div class="contact-field position-relative c-name mb-4">
                        <input
                          type="text"
                          id="phone"
                          name="phone"
                          placeholder="Nomor HP*"
                          required
                          oninput="toUpperCase(this)"
                        />
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="contact-field position-relative c-name mb-4">
                        <input
                          type="text"
                          id="tempat_lahir"
                          name="tempat_lahir"
                          placeholder="Tempat Lahir*"
                          required
                          oninput="toUpperCase(this)"
                        />
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="contact-field position-relative c-name mb-4">
                        <input
                          type="date"
                          id="tanggal_lahir"
                          name="tanggal_lahir"
                          placeholder="Tanggal Lahir*"
                          required
                        />
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="contact-field position-relative c-name mb-4">
                        <input
                          type="text"
                          id="ibu_kandung"
                          name="ibu_kandung"
                          placeholder="Nama Ibu Kandung*"
                          required
                          oninput="toUpperCase(this)"
                        />
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="contact-field position-relative c-name mb-4">
                        <input
                          type="text"
                          id="nik"
                          name="nik"
                          placeholder="Nomor Induk Kependudukan*"
                          required
                        />
                      </div>
                    </div>
                    <div class="col-lg-12">
                    <div class="contact-field position-relative c-name mb-4 select-container">
                        <select id="jurusan" name="jurusan" required>
                          <option value="" disabled selected>Pilih Jurusan*</option>
                          <?php
                          foreach ($jurusanOptions as $jurusan) {
                            echo "<option value=\"$jurusan\">$jurusan</option>";
                          }
                          ?>
                        </select>
                        <span class="dropdown-icon">&#9660;</span> 
                      </div>
                    </div>

                    <div class="col-lg-12">
                      <div class="contact-field position-relative c-name mb-4 select-container">
                        <select id="agama" name="agama" required>
                          <option value="" disabled selected>Pilih Agama*</option>
                          <option value="Islam">ISLAM</option>
                          <option value="Protestan">PROTESTAN</option>
                          <option value="Katolik">KATOLIK</option>
                          <option value="Hindu">HINDU</option>
                          <option value="Buddha">BUDDHA</option>
                          <option value="Konghucu">KONGHUCU</option>
                        </select>
                        <span class="dropdown-icon">&#9660;</span> 
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="contact-field radio-group mb-4">
                        <label for="laki-laki">Laki-laki</label>
                        <input type="radio" id="laki-laki" name="jenis_kelamin" value="laki-laki" required>

                        <label for="perempuan">Perempuan</label>
                        <input type="radio" id="perempuan" name="jenis_kelamin" value="perempuan" required>
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="contact-field position-relative c-name mb-4">
                        <textarea
                          name="pertanyaan"
                          id="pertanyaan"
                          cols="30"
                          rows="10"
                          placeholder="Pertanyaan"
                        ></textarea>
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="slider-btn">
                        <button type="submit" name="submit" class="pnd-btn" data-animation="fadeInRight" data-delay=".8s">Daftar</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!--End Contact Page-->

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
                    Copyright © 2024 Diligent by
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
    <!-- <script src="assets/js/07-jquery.nice-select.min.js"></script> -->
    <script src="../assets/js/08-slick.min.js"></script>
    <script src="../assets/js/09-wow.min.js"></script>
    <script src="../assets/js/10-jquery.circleType.js"></script>
    <script src="../assets/js/11-jquery.lettering.min.js"></script>
    <script src="../assets/js/12-TweenMax.min.js"></script>
    <script src="../assets/vendor/jarallax/jarallax.min.js"></script>
    <script src="../assets/vendor/marquee/marquee.min.js"></script>
    <script src="../assets/vendor/odometer/odometer.min.js"></script>

    <script src="../assets/js/main.js"></script>
    <script>
      // 1. Input Wrapping untuk Nomor HP
      const phoneInput = document.getElementById('phone');
      phoneInput.addEventListener('input', function() {
        let phoneNumber = this.value.replace(/\D/g, ''); // Hapus karakter non-digit
        if (phoneNumber.startsWith('08')) {
            phoneNumber = '+62' + phoneNumber.substring(1);
          if (phoneNumber.length > 15) {
              phoneNumber = phoneNumber.substring(0, 15);
          }
        } else {
          showError('phone', 'Nomor HP harus diawali dengan 08');
        }
        this.value = phoneNumber;
          if(phoneNumber.length < 11 || phoneNumber.length > 15) {
              showError('phone', 'Nomor HP harus 11-13 angka (08xxxxxxxxxx)');
          } else {
            clearError('phone');
          }

      });


      // 2. Input NIK Hanya Angka dan 16 Digit
      const nikInput = document.getElementById('nik');
      nikInput.addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '').substring(0, 16); // Hanya angka dan maksimal 16 digit
        if (this.value.length !== 16) {
          showError('nik', 'NIK harus 16 angka');
        } else {
          clearError('nik');
        }
      });


      // Fungsi untuk menampilkan pesan error
      function showError(inputId, message) {
        const errorSpan = document.getElementById(`${inputId}-error`);
        if (!errorSpan) {
          const inputDiv = document.getElementById(inputId).parentElement;
          const newErrorSpan = document.createElement('span');
          newErrorSpan.id = `${inputId}-error`;
          newErrorSpan.style.color = 'red';
          newErrorSpan.textContent = message;
          inputDiv.appendChild(newErrorSpan);
        } else {
          errorSpan.textContent = message;
        }
          
      }


      // Fungsi untuk menghapus pesan error
      function clearError(inputId) {
          const errorSpan = document.getElementById(`${inputId}-error`);
          if (errorSpan) {
              errorSpan.remove();
          }
      }


      // uppercase for text input
      function toUpperCase(element) {
        element.value = element.value.toUpperCase();
      }
    </script>
  </body>
</html>
