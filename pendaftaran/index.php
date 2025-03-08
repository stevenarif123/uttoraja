<?php
session_start();
require_once '../koneksi.php';

// Initialize error array
$errors = [];

try {
    // Ambil data jurusan dan fakultas dari tabel prodi_admisi
    $sql = "SELECT nama_program_studi, nama_fakultas FROM prodi_admisi";
    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception("Error executing query: " . $conn->error);
    }

    $jurusanData = array();
    while ($row = $result->fetch_assoc()) {
        $jurusanData[$row["nama_program_studi"]] = $row["nama_fakultas"];
        $jurusanOptions[] = $row["nama_program_studi"];
    }
    // Encode jurusanData untuk digunakan di JavaScript
    $jurusanDataJSON = json_encode($jurusanData);

} catch (Exception $e) {
    $errors[] = $e->getMessage();
}

// Close connection
if (isset($conn)) {
    $conn->close();
}

// Display errors if any
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<div class='alert alert-danger'>$error</div>";
    }
}

// Get any session messages
if (isset($_SESSION['success'])) {
    echo "<div class='alert alert-success'>" . $_SESSION['success'] . "</div>";
    unset($_SESSION['success']);
}
if (isset($_SESSION['error'])) {
    echo "<div class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
    unset($_SESSION['error']);
}
?>

<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>PENDAFTARAN MAHASISWA BARU SALUT TANA TORAJA</title>
  <meta name="description" content="" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.png" />
  <!-- Place favicon.ico in the root directory -->

  <link
    href="https://fonts.googleapis.com/css2?family=Inter+Tight:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet" />

  <!-- CSS here -->
  <link rel="stylesheet" href="../assets/css/01-bootstrap.min.css" />
  <link rel="stylesheet" href="../assets/css/02-all.min.css" />
  <link rel="stylesheet" href="../assets/css/03-jquery.magnific-popup.css" />
  <!-- <link rel="stylesheet" href="../assets/css/04-nice-select.css" /> -->
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
  <link rel="stylesheet" href="../assets/css/costumstyles.css" />
  <link rel="stylesheet" href="pendaftaran.css" />

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
                    <p><a href="tel:+6281355619225">+6281355619225</a></p>
                  </li>
                  <li>
                    <div class="icon">
                      <span class="icon-email"></span>
                    </div>
                    <p>
                      <a href="mailto:info@saluttoraja.com">info@saluttoraja.com</a>
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
                  <a href="../index.php">
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
                              <li><a href="../informasi">Informasi Akademik</a></li>
                              <li><a href="../administrasi/">Administrasi Akademik</a></li>
                              <li><a href="../kegiatan">Kegiatan Akademik</a></li>
                              <li><a href="../modul/">Pengambilan Modul</a></li>
                              <li><a href="../legalisir/">Legalisir Ijazah</a></li>
                              <li><a href="../suratketerangan/">Surat Keterangan</a></li>
                            </ul>
                          </li>
                          <li><a href="./galeri/">Galeri</a></li>
                          <li class="menu-item-has-children">
                            <a href="#">Tentang</a>
                            <ul class="sub-menu">
                              <li><a href="../tentang/tentangut">Universitas Terbuka</a></li>
                              <li><a href="../tentang/tentangsalut/">SALUT</a></li>
                              <li><a href="../tentang/saluttator">SALUT Tana Toraja</a></li>
                              <li><a href="../tentang/kepalasalut">Pesan Kepala SALUT</a></li>
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
                alt="Logo" />
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
      class="contact-area contact-bg pt-120 pb-100 p-relative fix">
      <div class="container jarakcontainer">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <div class="contact-bg02">
              <div class="section-title center-align">
                <h3 style="margin-bottom: 20px;">Formulir Pendaftaran Mahasiswa Baru</h3>
              </div>

              <!-- Form Start -->
              <form
                id="pendaftaranForm"
                method="post"
                action="pendaftaran.php"
                class="contact-form">
                <div class="form-progress">
                  <div class="progress-line"></div>
                  <div class="progress-step active" data-step="1">1</div>
                  <div class="progress-step" data-step="2">2</div>
                  <div class="progress-step" data-step="3">3</div>
                </div>

                <!-- Step 1 -->
                <div class="form-step active" data-step="1">
                  <h4 class="mb-4">Informasi Dasar</h4>
                  <div class="row"></div>
                  <div class="col-lg-12">
                    <label for="jalur_program">
                      Jalur Program 
                      <button type="button" class="help-icon" data-toggle="popover" data-trigger="hover" 
                              title="Reguler: Untuk lulusan SMA/SMK yang baru mendaftar.
                                          Transfer Nilai: Untuk mahasiswa pindahan atau yang ingin melanjutkan kuliah." 
                              data-content="Reguler: Untuk lulusan SMA/SMK yang baru mendaftar.
                                          Transfer Nilai: Untuk mahasiswa pindahan atau yang ingin melanjutkan kuliah.">?</button>
                    </label>
                    <div class="radio-field">
                        <div class="radio-group">
                            <label class="radio-option">
                                <input type="radio" id="reguler" name="jalur_program" value="Reguler" required>
                                <span class="radio-checkmark"></span>
                                <span class="radio-option-label">Reguler/Biasa</span>
                            </label>
                            
                            <label class="radio-option">
                                <input type="radio" id="transfer" name="jalur_program" value="Transfer Nilai" required>
                                <span class="radio-checkmark"></span>
                                <span class="radio-option-label">Transfer Nilai</span>
                            </label>
                        </div>
                    </div>
                  </div>

                  <div class="col-lg-12">
                    <div class="contact-field">
                      <label for="jurusan">Pilih Jurusan</label>
                      <div class="field-container">
                        <div class="input-wrapper select-container">
                          <select id="jurusan" name="jurusan" required>
                            <option value="" disabled selected>Pilih Jurusan*</option>
                            <?php foreach ($jurusanOptions as $jurusan): ?>
                                <option value="<?php echo $jurusan; ?>"><?php echo $jurusan; ?></option>
                            <?php endforeach; ?>
                          </select>
                          <span class="dropdown-icon">&#9660;</span>
                        </div>
                        <span class="input-description">Silahkan memilih jurusan yang sesuai dengan minat anda.</span>
                      </div>
                    </div>
                  </div>

                  <div class="col-lg-12">
                    <label for="fakultas">Fakultas</label>
                    <div class="contact-field position-relative c-name mb-4">
                      <input type="text" id="fakultas" name="fakultas" placeholder="Fakultas akan terisi otomatis" readonly>
                    </div>
                  </div>

                  <div class="col-lg-12">
                  <label for="jurusan">Nama Lengkap</label>
                    <div class="contact-field position-relative c-name mb-4">
                      <input
                        type="text"
                        id="firstn"
                        name="firstn"
                        placeholder="Nama Lengkap*"
                        required
                        oninput="toUpperCase(this)" />
                        <span class="input-description">Isi nama lengkap anda sesuai dengan KTP.</span>
                    </div>
                  </div>

                  <div class="form-buttons">
                    <button type="button" class="pnd-btn next-step">Lanjut</button>
                  </div>
                </div>

                <!-- Step 2 -->
                <div class="form-step" data-step="2">
                  <h4 class="mb-4">Data Pribadi</h4>
                  <!-- Nomor HP -->
                  <div class="col-lg-12">
                  <label for="phone">Nomor HP/WA</label><br>
                    <div class="contact-field position-relative c-name mb-4">
                      <input
                        type="text"
                        id="phone"
                        name="phone"
                        placeholder="Nomor HP*"
                        required
                        oninput="toUpperCase(this)" />
                      <span class="input-description">Isi dengan nomor HP anda. Contoh: 081234567890 (Nomor aktif WhatsApp)</span>
                    </div>
                  </div>

                  <!-- Tempat Lahir -->
                  <div class="col-lg-12">
                  <label for="tempat_lahir">Tempat Lahir</label><br>
                    <div class="contact-field position-relative c-name mb-4">
                      <input
                        type="text"
                        id="tempat_lahir"
                        name="tempat_lahir"
                        placeholder="Tempat Lahir*"
                        required
                        oninput="toUpperCase(this)" />
                      <span class="input-description">Isi tempat lahir anda sesuai dengan yang tertera di KTP</span>
                    </div>
                  </div>

                  <!-- Tanggal Lahir -->
                  <div class="col-lg-12">
                  <label for="tanggal_lahir">Tanggal Lahir</label>
                    <div class="contact-field">
                        <div class="input-wrapper date-picker-wrapper">
                            <input
                              type="date"
                              id="tanggal_lahir"
                              name="tanggal_lahir"
                              required
                              class="form-control date-input"
                              min="1940-01-01"
                              max="<?php echo date('Y-m-d', strtotime('-15 years')); ?>"
                              value=""
                            />
                            <i class="fas fa-calendar-alt calendar-icon"></i>
                          <span class="input-description">Isi tanggal lahir anda sesuai dengan yang tertera di KTP</span>
                        </div>
                      </div>
                  </div>

                  <!-- Jenis Kelamin -->
                  <div class="col-lg-12">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <div class="radio-field">
                        <div class="radio-group">
                            <label class="radio-option">
                                <input type="radio" id="laki-laki" name="jenis_kelamin" value="laki-laki" required>
                                <span class="radio-checkmark"></span>
                                <span class="radio-option-label">Laki-laki</span>
                            </label>
                            
                            <label class="radio-option">
                                <input type="radio" id="perempuan" name="jenis_kelamin" value="perempuan" required>
                                <span class="radio-checkmark"></span>
                                <span class="radio-option-label">Perempuan</span>
                            </label>
                        </div>
                    </div>
                  </div>

                  <!-- Nama Ibu Kandung -->
                  <div class="col-lg-12">
                  <label for="ibu_kandung">Nama Ibu Kandung</label><br>
                    <div class="contact-field position-relative c-name mb-4">
                      <input
                        type="text"
                        id="ibu_kandung"
                        name="ibu_kandung"
                        placeholder="Nama Ibu Kandung*"
                        required
                        oninput="toUpperCase(this)" />
                        <span class="input-description">Isi nama lengkap ibu kandung anda.</span>
                    </div>
                  </div>

                  <!-- NIK -->
                  <div class="col-lg-12">
                  <label for="nik">Nomor Induk Kependudukan</label><br>
                    <div class="contact-field position-relative c-name mb-4">
                      <input
                        type="text"
                        id="nik"
                        name="nik"
                        placeholder="Nomor Induk Kependudukan (NIK)*"
                        required />
                      <span class="input-description">Masukkan 16 digit NIK sesuai dengan yang tertera di KTP anda.</span>
                    </div>
                  </div>

                  <div class="form-buttons">
                    <button type="button" class="pnd-btn prev-step">Kembali</button>
                    <button type="button" class="pnd-btn next-step">Lanjut</button>
                  </div>
                </div>

                <!-- Step 3 -->
                <div class="form-step" data-step="3">
                  <h4 class="mb-4">Informasi Tambahan</h4>
                  <!-- Alamat -->
                  <div class="col-lg-12">
                  <label for="alamat">Alamat Lengkap</label><br>
                    <div class="contact-field position-relative c-name mb-4">
                      <input
                        type="text"
                        id="alamat"
                        name="alamat"
                        placeholder="Alamat*"
                        required
                        oninput="toUpperCase(this)" />
                      <span class="input-description">Tuliskan alamat lengkap termasuk RT/RW dan kode pos</span>
                    </div>
                  </div>

                  <!-- Ukuran Baju -->
                  <div class="col-lg-12">
                  <label for="ukuran_baju">Ukuran Baju</label><br>
                    <div class="contact-field position-relative c-name mb-4 select-container">
                      <select id="ukuran_baju" name="ukuran_baju" required>
                        <option value="" disabled selected>Pilih Ukuran Baju*</option>
                        <option value="S">S</option>
                        <option value="M">M</option>
                        <option value="L">L</option>
                        <option value="XL">XL</option>
                        <option value="XLL">XLL</option>
                      </select>
                      <span class="dropdown-icon">&#9660;</span>
                      <span class="input-description">Ukuran baju akan digunakan sebagai ukuran baju almamater yang anda pesan.</span>
                    </div>
                  </div>

                  <!-- Sedang Bekerja? -->
                  <div class="col-lg-12">
                    <label for="bekerja">Sedang Bekerja?</label>
                    <div class="radio-field">
                        <div class="radio-group">
                            <label class="radio-option">
                                <input type="radio" id="bekerja_ya" name="bekerja" value="Ya">
                                <span class="radio-checkmark"></span>
                                <span class="radio-option-label">Ya</span>
                            </label>
                            
                            <label class="radio-option">
                                <input type="radio" id="bekerja_tidak" name="bekerja" value="Tidak" checked>
                                <span class="radio-checkmark"></span>
                                <span class="radio-option-label">Tidak</span>
                            </label>
                        </div>
                    </div>
                    <span class="input-description">Silahkan mengisi jika anda sdang atau tidak bekerja saat ini</span>
                  </div>

                  <!-- Tempat Kerja -->
                  
                  <div class="col-lg-12" id="tempat_kerja_container" style="display: none;">
                  <label for="tempat_kerja">Nama Tempat Bekerja</label><br>
                    <div class="contact-field position-relative c-name mb-4">
                      <input
                        type="text"
                        id="tempat_kerja"
                        name="tempat_kerja"
                        placeholder="Tuliskan nama tempat kerja"
                        oninput="toUpperCase(this)" />
                        <span class="input-description">Isi nama tempat bekerja anda yang sesuai.</span>
                    </div>
                  </div>

                  <!-- Agama -->
                  <div class="col-lg-12">
                    <label for="agama">Agama</label><br>
                    <div class="contact-field position-relative c-name mb-4">
                      <select id="agama" name="agama" required>
                        <option value="" disabled selected>Pilih Agama*</option>
                        <option value="Islam">Islam</option>
                        <option value="Protestan">Protestan</option>
                        <option value="Katolik">Katolik</option>
                        <option value="Hindu">Hindu</option>
                        <option value="Buddha">Buddha</option>
                        <option value="Konghucu">Konghucu</option>
                        <option value="Lainnya">Lainnya</option>
                      </select>
                      <span class="dropdown-icon">&#9660;</span>
                      <span class="input-description">Isi pilihan agama yang sesuai di KTP anda, jika telah pindah agama atau kesalahan cetak KTP maka dapat melampirkan surat keterangan pindah agama atau dapat mencetak ulang KTP.</span>
                    </div>
                  </div>

                  <!-- Pertanyaan -->
                  <div class="col-lg-12">
                  <label for="pertanyaan">Pertanyaan</label><br>
                    <div class="contact-field position-relative c-name mb-4">
                      <textarea
                        name="pertanyaan"
                        id="pertanyaan"
                        cols="30"
                        rows="10"
                        placeholder="Tuliskan pertanyaan jika ada"></textarea>
                        <span class="input-description">Isi jika ada pertanyaan atau pesan yang ingin diajukan.</span>
                    </div>
                  </div>

                  <div class="form-buttons">
                    <button type="button" class="pnd-btn prev-step">Kembali</button>
                    <button type="submit" class="pnd-btn">Daftar</button>
                  </div>
                </div>
              </form>
              <!-- Form End -->
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Modal Petunjuk -->
    <div id="petunjukModal" class="modal">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Petunjuk Pendaftaran</h5>
          <span class="close-modal" id="closeModal">&times;</span>
        </div>
        <div class="modal-body">
          <p>Ini adalah petunjuk pendaftaran. Silakan ikuti langkah-langkah berikut:</p>
          <ol>
            <li>Isi semua kolom yang tersedia.</li>
            <li>Pastikan data yang diisi benar.</li>
            <li>Jalur Program:</li>
            <li>1. Reguler/Umum merupakan pendaftaran mahasiswa secara umum menggunakan ijazah SMA</li>
            <li>2. Transfer Nilai merupakan pilihan bagi yang ingin pindah Jurusan atau Transfer Nilai dari kampus sebelumnya</li>
            <br>
            <li>Klik tombol Daftar untuk menyelesaikan pendaftaran.</li>
          </ol>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" id="closeModalBtn">Tutup</button>
        </div>
      </div>
    </div>
    <!-- /Modal Petunjuk -->
    <div class="modal fade" id="petunjukModal" tabindex="-1" role="dialog" aria-labelledby="petunjukModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="petunjukModalLabel">Petunjuk Pendaftaran</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            xxxxxxx
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          </div>
        </div>
      </div>
    </div>

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
                          <a href="tel:+6281355619225">+62 813-5561-9225</a>
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
                        <p><a href="../tentang/tentangut.php">Tentang UT</a></p>
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
              <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInUp;">
                <div class="single-footer-widget single-footer-widget-style2 ml50">
                  <div class="title">
                    <h3>Layanan Kami</h3>
                  </div>
                  <div class="single-footer-widget-box single-footer-widget__links single-footer-widget__links-style2">
                    <ul class="clearfix">
                      <li><p><a href="../informasi.php">Informasi Akademik</a></p></li>
                      <li><p><a href="../modul/">Pengambilan Modul</a></p></li>
                      <li><p><a href="../legalisir/">Legalisir Ijazah</a></p></li>
                      <li><p><a href="../suratketerangan/">Surat Keterangan</a></p></li>
                    </ul>
                  </div>
                </div>
              </div>
              <!--End Single Footer Widget-->
            </div>
          </div>
        </div>
      </div>
      <!-- End Footer Main -->
    </footer>
    <!--End Footer Three-->

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
    <!-- Alert Container (tempat pesan sukses/error) -->
    <div id="alert-container"></div>

    <script>
        // Make jurusanData available to JavaScript
        const jurusanData = <?php echo $jurusanDataJSON; ?>;
    </script>
    <!-- JS here -->
    <script src="../assets/js/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/01-ajax-form.js"></script>
    <script src="../assets/js/02-bootstrap.min.js"></script>
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

    <script src="../assets/js/main.js"></script>
    <script src="pendaftaran.js"></script>
  </body>
</html>
