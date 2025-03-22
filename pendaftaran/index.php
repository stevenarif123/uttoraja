<?php
session_start();
require_once '../koneksi.php';
require_once '../koneksi_datadaerah.php'; // Add new connection

// Initialize arrays
$errors = [];
$jurusanData = array();
$jurusanOptions = array();
$kelurahanData = array();

try {
  // Check primary connection
  if (!$conn) {
    throw new Exception("Database connection failed");
  }

  // Query prodi_admisi table from main database
  $sql = "SELECT nama_program_studi, nama_fakultas FROM prodi_admisi ORDER BY nama_program_studi";
  $result = $conn->query($sql);

  if (!$result) {
    throw new Exception("Error executing query: " . $conn->error);
  }

  while ($row = $result->fetch_assoc()) {
    $jurusanData[$row["nama_program_studi"]] = $row["nama_fakultas"];
    $jurusanOptions[] = $row["nama_program_studi"];
  }

  // Query kelurahan data from data_daerah database
  if (!$conn_daerah) {
    throw new Exception("Data daerah database connection failed");
  }

  $kelurahanQuery = "SELECT area_name FROM kelurahan_lembang ORDER BY area_name";
  $kelurahanResult = $conn_daerah->query($kelurahanQuery);

  if (!$kelurahanResult) {
    throw new Exception("Error fetching kelurahan data: " . $conn_daerah->error);
  }

  while ($row = $kelurahanResult->fetch_assoc()) {
    $kelurahanData[] = $row;
  }

  // Encode data for JavaScript
  $jurusanDataJSON = json_encode($jurusanData);
  $kelurahanDataJSON = json_encode($kelurahanData);
} catch (Exception $e) {
  $errors[] = $e->getMessage();
} finally {
  // Close both connections
  if (isset($conn)) $conn->close();
  if (isset($conn_daerah)) $conn_daerah->close();
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
  <meta name="description" content="Pendaftaran mahasiswa baru Universitas Terbuka SALUT Tana Toraja" />
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

  <link rel="stylesheet" href="../assets/css/style.css" />
  <link rel="stylesheet" href="../assets/css/color1.css" />
  <link rel="stylesheet" href="../assets/css/responsive.css" />
  <link rel="stylesheet" href="../assets/css/costumstyles.css" />
  <link rel="stylesheet" href="pendaftaran.css" />

  <style>
    /* Enhanced Preloader */
    #preloader {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 9999;
      background-color: #fff;
    }

    #loading-center {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }

    .loader {
      position: relative;
      width: 80px;
      height: 80px;
    }

    .loader-outter {
      position: absolute;
      border: 4px solid #006aac;
      border-left-color: transparent;
      border-bottom: 0;
      width: 100%;
      height: 100%;
      border-radius: 50%;
      animation: loader-1-outter 1s cubic-bezier(.42, .61, .58, .41) infinite;
    }

    .loader-inner {
      position: absolute;
      border: 4px solid #0085d4;
      border-radius: 50%;
      width: 60px;
      height: 60px;
      left: 50%;
      top: 50%;
      transform: translate(-50%, -50%);
      border-right: 0;
      border-top-color: transparent;
      animation: loader-1-inner 1s cubic-bezier(.42, .61, .58, .41) infinite;
    }

    @keyframes loader-1-outter {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }

    @keyframes loader-1-inner {
      0% {
        transform: translate(-50%, -50%) rotate(0deg);
      }

      100% {
        transform: translate(-50%, -50%) rotate(-360deg);
      }
    }
    
    /* Modal Styles */
    #petunjukModal .modal-content {
      max-width: 600px;
      margin: 30px auto;
      border-radius: 10px;
      overflow: hidden;
    }
    
    #petunjukModal .modal-header {
      background-color: #007bff;
      color: white;
      padding: 15px 20px;
    }
    
    #petunjukModal .modal-title {
      font-weight: 600;
      margin: 0;
    }
    
    #petunjukModal .close-modal {
      color: white;
      font-size: 28px;
      font-weight: bold;
      cursor: pointer;
      opacity: 0.8;
      transition: opacity 0.2s;
    }
    
    #petunjukModal .close-modal:hover {
      opacity: 1;
    }
    
    #petunjukModal .modal-body {
      padding: 20px;
    }
    
    #petunjukModal .steps-container {
      margin-bottom: 20px;
    }
    
    #petunjukModal .step-item {
      display: flex;
      margin-bottom: 20px;
    }
    
    #petunjukModal .step-number {
      width: 30px;
      height: 30px;
      background-color: #007bff;
      color: white;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
      margin-right: 15px;
      flex-shrink: 0;
    }
    
    #petunjukModal .step-content {
      flex: 1;
    }
    
    #petunjukModal .step-content h6 {
      margin-top: 0;
      margin-bottom: 8px;
      color: #333;
      font-weight: 600;
    }
    
    #petunjukModal .step-content p {
      margin-bottom: 5px;
      color: #666;
    }
    
    #petunjukModal .modal-footer {
      padding: 15px 20px;
      border-top: 1px solid #eee;
      display: flex;
      justify-content: flex-end;
      gap: 10px;
    }
    
    /* Enhanced Preloader with animation */
    #preloader {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 9999;
      background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      transition: opacity 0.5s ease-in-out;
    }

    #loading-center {
      position: relative;
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    
    #loading-text {
      margin-top: 20px;
      font-family: 'Inter Tight', sans-serif;
      font-weight: 500;
      color: #2563eb;
      letter-spacing: 2px;
      animation: pulse 1.5s infinite;
    }

    .loader {
      position: relative;
      width: 100px;
      height: 100px;
    }

    .loader-outter {
      position: absolute;
      border: 4px solid #3b82f6;
      border-left-color: transparent;
      border-bottom: 0;
      width: 100%;
      height: 100%;
      border-radius: 50%;
      animation: loader-spinner 1.2s cubic-bezier(.42, .61, .58, .41) infinite;
    }

    .loader-inner {
      position: absolute;
      border: 4px solid #0ea5e9;
      border-radius: 50%;
      width: 70px;
      height: 70px;
      left: 50%;
      top: 50%;
      transform: translate(-50%, -50%);
      border-right: 0;
      border-top-color: transparent;
      animation: loader-spinner 1.2s cubic-bezier(.42, .61, .58, .41) infinite reverse;
    }
    
    .loader-center {
      position: absolute;
      background: #2563eb;
      width: 30px;
      height: 30px;
      border-radius: 50%;
      left: 50%;
      top: 50%;
      transform: translate(-50%, -50%);
      animation: pulse 1.5s infinite;
    }

    @keyframes loader-spinner {
      0% {
        transform: rotate(0deg);
      }
      100% {
        transform: rotate(360deg);
      }
    }
    
    @keyframes pulse {
      0% {
        opacity: 0.6;
        transform: translate(-50%, -50%) scale(0.9);
      }
      50% {
        opacity: 1;
        transform: translate(-50%, -50%) scale(1);
      }
      100% {
        opacity: 0.6;
        transform: translate(-50%, -50%) scale(0.9);
      }
    }
    
    /* Background decorations */
    .bg-decoration {
      position: fixed;
      pointer-events: none;
      z-index: -1;
      opacity: 0.4;
      animation: float 10s ease-in-out infinite;
    }
    
    .bg-decoration:nth-child(1) {
      top: 10%;
      left: 5%;
      width: 300px;
      height: 300px;
      background: radial-gradient(circle, rgba(59, 130, 246, 0.2) 0%, rgba(59, 130, 246, 0) 70%);
      animation-delay: 0s;
    }
    
    .bg-decoration:nth-child(2) {
      bottom: 10%;
      right: 5%;
      width: 250px;
      height: 250px;
      background: radial-gradient(circle, rgba(14, 165, 233, 0.2) 0%, rgba(14, 165, 233, 0) 70%);
      animation-delay: -3s;
    }
    
    .bg-decoration:nth-child(3) {
      top: 60%;
      left: 15%;
      width: 200px;
      height: 200px;
      background: radial-gradient(circle, rgba(249, 115, 22, 0.2) 0%, rgba(249, 115, 22, 0) 70%);
      animation-delay: -6s;
    }
    
    @keyframes float {
      0% {
        transform: translateY(0) rotate(0deg) scale(1);
      }
      50% {
        transform: translateY(-20px) rotate(5deg) scale(1.05);
      }
      100% {
        transform: translateY(0) rotate(0deg) scale(1);
      }
    }
    
    /* Enhanced step styles */
    .form-step h4 {
      position: relative;
      display: inline-block;
      color: #2563eb;
      margin-bottom: 25px;
      font-weight: 600;
      font-size: 22px;
    }
    
    .form-step h4::after {
      content: '';
      position: absolute;
      bottom: -8px;
      left: 0;
      width: 60px;
      height: 3px;
      background: linear-gradient(90deg, #2563eb 0%, #0ea5e9 100%);
      border-radius: 3px;
    }
    
    /* Custom checkbox styling */
    .select-container {
      position: relative;
    }
    
    .select-container select {
      appearance: none;
      -webkit-appearance: none;
      width: 100%;
      padding: 14px 18px;
      padding-right: 40px;
      border: 2px solid #e2e8f0;
      border-radius: 12px;
      background-color: #fcfcfc;
      font-size: 15px;
      transition: all 0.3s ease;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
      cursor: pointer;
    }
    
    .select-container:focus-within select {
      border-color: #2563eb;
      box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    }
    
    .select-container .dropdown-icon {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: #94a3b8;
      pointer-events: none;
      transition: all 0.3s ease;
    }
    
    .select-container:focus-within .dropdown-icon {
      color: #2563eb;
      transform: translateY(-50%) rotate(180deg);
    }
    
    /* Page header enhancements */
    .page-header {
      background: linear-gradient(135deg, #2563eb 0%, #0ea5e9 100%);
      overflow: hidden;
      position: relative;
    }
    
    .page-header::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-image: url('../assets/img/shape/page-header-shape1.png');
      background-repeat: repeat;
      background-size: 300px;
      opacity: 0.1;
      animation: backgroundMove 30s linear infinite;
    }
    
    @keyframes backgroundMove {
      0% {
        background-position: 0 0;
      }
      100% {
        background-position: 300px 300px;
      }
    }
    
    .page-header__inner {
      position: relative;
      z-index: 1;
    }
    
    /* Modal tutorial styles */
    #petunjukModal .step-item {
      background: white;
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
      margin-bottom: 20px;
      border-left: 4px solid #2563eb;
      transition: all 0.3s ease;
    }
    
    #petunjukModal .step-item:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    
    #petunjukModal .step-number {
      width: 35px;
      height: 35px;
      background: linear-gradient(135deg, #2563eb 0%, #0ea5e9 100%);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: bold;
      margin-right: 15px;
    }
    
    /* Button style enhancements */
    #showPetunjukBtn {
      background-color: white;
      color: #2563eb;
      border: 2px solid #2563eb;
      padding: 12px 20px;
      border-radius: 12px;
      font-weight: 500;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    
    #showPetunjukBtn:hover {
      background-color: #f0f7ff;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);
    }
    
    #startRegistrationBtn, #closeModalBtn {
      border-radius: 10px;
      padding: 10px 20px;
      font-weight: 500;
      transition: all 0.3s ease;
    }
    
    #startRegistrationBtn {
      background: linear-gradient(135deg, #2563eb 0%, #0ea5e9 100%);
      border: none;
    }
    
    #startRegistrationBtn:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
    }
  </style>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Add data-title attributes to progress steps
      document.querySelector('.progress-step[data-step="1"]').setAttribute('data-title', 'Informasi Dasar');
      document.querySelector('.progress-step[data-step="2"]').setAttribute('data-title', 'Data Pribadi');
      document.querySelector('.progress-step[data-step="3"]').setAttribute('data-title', 'Informasi Tambahan');
      
      // Page loaded, remove preloader with animation
      setTimeout(() => {
        const preloader = document.getElementById('preloader');
        if (preloader) {
          preloader.style.opacity = '0';
          setTimeout(() => {
            preloader.style.display = 'none';
          }, 500);
        }
      }, 1500);
      
      // Initialize exciting form elements
      initializeAnimations();
    });
    
    function initializeAnimations() {
      // Add staggered animation to form elements
      const formElements = document.querySelectorAll('.contact-field, .field-container');
      formElements.forEach((el, index) => {
        el.style.opacity = '0';
        setTimeout(() => {
          el.style.opacity = '1';
          el.classList.add('slide-in-up');
        }, 100 * index);
      });
      
      // Add hover effects to buttons
      const buttons = document.querySelectorAll('.pnd-btn, .btn');
      buttons.forEach(btn => {
        btn.addEventListener('mouseover', function() {
          this.classList.add('animate__pulse');
        });
        
        btn.addEventListener('mouseout', function() {
          this.classList.remove('animate__pulse');
        });
      });
    }
  </script>
</head>

<body class="body-gray-bg">
  <!-- Background decorations with enhanced positioning -->
  <div class="bg-decoration" style="width:400px; height:400px; top:5%; left:2%;"></div>
  <div class="bg-decoration" style="width:300px; height:300px; bottom:10%; right:5%;"></div>
  <div class="bg-decoration" style="width:200px; height:200px; top:40%; right:15%;"></div>
  
  <!-- Enhanced preloader with loading text -->
  <div id="preloader">
    <div id="loading-center">
      <div class="loader">
        <div class="loader-outter"></div>
        <div class="loader-inner"></div>
        <div class="loader-center"></div>
      </div>
      <div id="loading-text">MEMUAT...</div>
    </div>
  </div>
  <!-- preloader-end -->

  <div class="page-wrapper">
    <!--Start Main Header One -->
    <header class="main-header main-header-one">
      <div class="main-header-one__top">
        <div class="container">
        </div>
      </div>
      <nav class="main-menu main-menu-one">
        <div class="main-menu-one__wrapper">
          <div class="container">
            <div class="main-menu-one__wrapper-inner">
              <div class="main-menu-one__logo-box">
              </div>
              <div class="main-menu-one__menu-box">
              </div>
              <div class="main-menu-one__right">
              </div>
            </div>
          </div>
        </div>
      </nav>
    </header>

    <!--Start Mobile Menu -->
    <div class="mobile-menu">
      <nav class="menu-box">
        <div class="menu-outer">
          <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
        </div>
        <!--Social Links-->
        <div class="social-links">
        </div>
      </nav>
    </div>
    <!-- End Mobile Menu -->

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
          <h2>Pendaftaran Mahasiswa Baru</h2>
          <ul class="thm-breadcrumb">
            <li><a href="../index.php">Home</a></li>
            <li><i class="icon-right-arrow-angle"></i></li>
            <li>Pendaftaran</li>
          </ul>
        </div>
      </div>
    </section>
    <!--End Page Header-->

    <!--Start Contact Page-->
    <section id="contact" class="contact-area contact-bg pt-120 pb-100 p-relative fix">
      <div class="container jarakcontainer">
        <div class="row justify-content-center">
          <div class="col-xl-12 col-lg-12">
            <div class="contact-bg02 mt-90">
              <div class="section-title text-center mb-50">
                <h2>Pendaftaran Mahasiswa Baru</h2>
                <span class="mt-2 d-inline-block">SALUT Tana Toraja</span>
              </div>
              
              <!-- Form Progress Steps -->
              <div class="form-progress">
                <div class="progress-line"></div>
                <div class="progress-step active" data-step="1">1</div>
                <div class="progress-step" data-step="2">2</div>
                <div class="progress-step" data-step="3">3</div>
              </div>

              <!-- Registration Form -->
              <form id="pendaftaranForm" class="contact-form">
                <!-- Step 1: Informasi Dasar -->
                <div class="form-step active" data-step="1">
                  <h4 class="mb-4">Informasi Dasar</h4>
                  
                  <!-- Jalur Program -->
                  <div class="col-lg-12">
                    <div class="field-container">
                      <label>Jalur Program</label>
                      <div class="radio-field">
                        <div class="radio-group">
                          <label class="radio-option">
                            <input type="radio" id="reguler" name="jalur_program" value="Reguler" required>
                            <span class="radio-checkmark"></span>
                            <span class="radio-option-label">Reguler/Umum</span>
                          </label>
                          
                          <label class="radio-option">
                            <input type="radio" id="transfer" name="jalur_program" value="Transfer Nilai" required>
                            <span class="radio-checkmark"></span>
                            <span class="radio-option-label">Transfer Nilai</span>
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <!-- Fakultas -->
                  <div class="col-lg-12">
                    <label for="fakultas">Fakultas</label>
                    <div class="contact-field position-relative c-name mb-4">
                      <input type="text" id="fakultas" name="fakultas" placeholder="Fakultas akan terisi otomatis" readonly>
                    </div>
                  </div>
                  
                  <!-- Nama Lengkap -->
                  <div class="col-lg-12">
                    <label for="nama">Nama Lengkap</label>
                    <div class="contact-field position-relative c-name mb-4">
                      <input
                        type="text"
                        id="firstn"
                        name="firstn"
                        placeholder="Nama Lengkap*"
                        required
                        oninput="this.value = this.value.toUpperCase();" />
                    </div>
                  </div>
                  
                  <!-- Step 1: Informasi Dasar - Jurusan dropdown -->
                  <div class="col-lg-12">
                    <label for="jurusan">Pilih Jurusan</label>
                    <div class="contact-field">
                      <div class="field-container">
                        <div class="searchable-dropdown">
                          <input type="text" class="dropdown-search" placeholder="Cari jurusan..." autocomplete="off">
                          <input type="hidden" id="jurusan" name="jurusan" required>
                          <div class="dropdown-list">
                            <?php if (!empty($jurusanOptions)): ?>
                              <?php foreach ($jurusanOptions as $jurusan): ?>
                              <div class="dropdown-item" data-value="<?php echo htmlspecialchars($jurusan); ?>">
                                <?php echo htmlspecialchars($jurusan); ?>
                              </div>
                              <?php endforeach; ?>
                            <?php else: ?>
                              <div class="dropdown-item">No options available</div>
                            <?php endif; ?>
                          </div>
                          <span class="dropdown-icon">&#9660;</span>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-buttons">
                    <button type="button" id="showPetunjukBtn" class="btn btn-outline-primary me-2">
                      <i class="fas fa-info-circle me-1"></i> Petunjuk Pendaftaran
                    </button>
                    <button type="button" class="pnd-btn next-step">Lanjut</button>
                  </div>
                </div>
                
                <!-- Step 2: Data Pribadi -->
                <div class="form-step" data-step="2">
                  <h4 class="mb-4">Data Pribadi</h4>
                  
                  <!-- Nomor HP -->
                  <div class="col-lg-12">
                    <label for="phone">Nomor HP/WA</label>
                    <div class="contact-field position-relative c-name mb-4">
                      <input
                        type="text"
                        id="phone"
                        name="phone"
                        placeholder="Nomor HP/WA*"
                        required
                        oninput="validatePhone(this)" />
                    </div>
                  </div>

                  <!-- Tempat Lahir -->
                  <div class="col-lg-12">
                    <label for="tempat_lahir">Tempat Lahir</label>
                    <div class="contact-field position-relative c-name mb-4">
                      <input
                        type="text"
                        id="tempat_lahir"
                        name="tempat_lahir"
                        placeholder="Tempat Lahir*" 
                        required
                        oninput="this.value = this.value.toUpperCase();" />
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
                          max="<?php echo date('Y-m-d', strtotime('-15 years')); ?>"
                          min="1940-01-01"
                          pattern="\d{4}-\d{2}-\d{2}"
                          value="" />
                        <i class="fas fa-calendar-alt calendar-icon"></i>
                      </div>
                    </div>
                  </div>

                  <!-- Jenis Kelamin -->
                  <div class="col-lg-12 spasi">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <div class="radio-field">
                      <div class="radio-group">
                        <label class="radio-option">
                          <input type="radio" id="laki" name="jenis_kelamin" value="laki-laki" required>
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
                    <label for="ibu_kandung">Nama Ibu Kandung</label>
                    <div class="contact-field position-relative c-name mb-4">
                      <input
                        type="text"
                        id="ibu_kandung"
                        name="ibu_kandung"
                        placeholder="Nama Ibu Kandung*"
                        required
                        oninput="this.value = this.value.toUpperCase();" />
                    </div>
                  </div>

                  <!-- NIK -->
                  <div class="col-lg-12">
                    <label for="nik">Nomor Induk Kependudukan</label>
                    <div class="contact-field position-relative c-name mb-4">
                      <input
                        type="text"
                        id="nik"
                        name="nik"
                        placeholder="Nomor Induk Kependudukan (NIK)*"
                        required
                        maxlength="16"
                        oninput="validateNIK(this)" />
                    </div>
                  </div>

                  <div class="form-buttons">
                    <button type="button" class="pnd-btn prev-step">Kembali</button>
                    <button type="button" class="pnd-btn next-step">Lanjut</button>
                  </div>
                </div>

                <!-- Step 3: Informasi Tambahan -->
                <div class="form-step" data-step="3">
                  <h4 class="mb-4">Informasi Tambahan</h4>
                  
                  <!-- Status Perkawinan -->
                  <div class="col-lg-12 spasi">
                    <label for="kawin">Status Perkawinan</label>
                    <div class="radio-field">
                      <div class="radio-group">
                        <label class="radio-option">
                          <input type="radio" id="belum_kawin" name="kawin" value="Belum Kawin" required>
                          <span class="radio-checkmark"></span>
                          <span class="radio-option-label">Belum Kawin</span>
                        </label>
                        
                        <label class="radio-option">
                          <input type="radio" id="kawin" name="kawin" value="Kawin">
                          <span class="radio-checkmark"></span>
                          <span class="radio-option-label">Kawin</span>
                        </label>
                        
                        <label class="radio-option">
                          <input type="radio" id="cerai_hidup" name="kawin" value="Cerai Hidup">
                          <span class="radio-checkmark"></span>
                          <span class="radio-option-label">Cerai Hidup</span>
                        </label>
                        
                        <label class="radio-option">
                          <input type="radio" id="cerai_mati" name="kawin" value="Cerai Mati">
                          <span class="radio-checkmark"></span>
                          <span class="radio-option-label">Cerai Mati</span>
                        </label>
                      </div>
                    </div>
                  </div>

                  <!-- Alamat -->
                  <div class="col-lg-12">
                    <label for="alamat">Alamat Lengkap</label>
                    <div class="contact-field position-relative c-name mb-4">
                      <input
                        type="text"
                        id="alamat"
                        name="alamat"
                        placeholder="Alamat Lengkap*"
                        required
                        oninput="this.value = this.value.toUpperCase();" />
                    </div>
                  </div>

                  <!-- Domisili -->
                  <div class="col-lg-12 spasi">
                    <label for="domisili">Domisili</label>
                    <div class="radio-field">
                      <div class="radio-group">
                        <label class="radio-option">
                          <input type="radio" id="toraja" name="domisili" value="toraja" required>
                          <span class="radio-checkmark"></span>
                          <span class="radio-option-label">Toraja (Tana Toraja/Toraja Utara)</span>
                        </label>
                        
                        <label class="radio-option">
                          <input type="radio" id="luar_toraja" name="domisili" value="luar_toraja" required>
                          <span class="radio-checkmark"></span>
                          <span class="radio-option-label">Luar Toraja</span>
                        </label>
                      </div>
                    </div>
                  </div>

                  <!-- Toraja Fields -->
                  <div id="toraja_fields" style="display: none;">
                    <div class="kelurahan-group">
                      <div class="kelurahan-group-header">Data Wilayah Toraja</div>
                      
                      <!-- Step 3: Kelurahan/Lembang dropdown -->
                      <div class="field-container">
                        <label for="kelurahan">Kelurahan/Lembang</label>
                        <div class="searchable-dropdown">
                          <input type="text" class="dropdown-search" placeholder="Cari Kelurahan/Lembang..." autocomplete="off">
                          <input type="hidden" id="kelurahan" name="kelurahan">
                          <div class="dropdown-list">
                            <div class="dropdown-item dropdown-placeholder">Pilih Kelurahan/Lembang</div>
                          </div>
                          <span class="dropdown-icon">&#9660;</span>
                        </div>
                      </div>
          
                      <div class="field-container">
                        <label for="kecamatan">Kecamatan</label>
                        <input type="text" id="kecamatan" name="kecamatan" placeholder="Kecamatan akan terisi otomatis" readonly>
                      </div>
          
                      <div class="field-container">
                        <label for="kabupaten">Kabupaten</label>
                        <input type="text" id="kabupaten" name="kabupaten" placeholder="Kabupaten akan terisi otomatis" readonly>
                      </div>
                    </div>
                  </div>

                  <!-- Non-Toraja Fields -->
                  <div id="luar_toraja_fields" style="display: none;">
                    <div class="col-lg-12">
                      <label for="domisili_manual">Domisili Lengkap</label>
                      <div class="contact-field position-relative c-name mb-4">
                        <input
                          type="text"
                          id="domisili_manual"
                          name="domisili_manual"
                          placeholder="Masukkan domisili lengkap"
                          oninput="this.value = this.value.toUpperCase();">
                      </div>
                    </div>
                  </div>

                  <!-- Ukuran Baju -->
                  <div class="col-lg-12">
                    <label for="ukuran_baju">Ukuran Baju</label>
                    <div class="contact-field position-relative c-name mb-4 select-container">
                      <div class="field-container">
                        <select id="ukuran_baju" name="ukuran_baju" required>
                          <option value="" disabled selected>Pilih Ukuran Baju*</option>
                          <option value="S">S</option>
                          <option value="M">M</option>
                          <option value="L">L</option>
                          <option value="XL">XL</option>
                          <option value="XXL">XXL</option>
                          <option value="XXXL">XXXL</option>
                        </select>
                        <span class="dropdown-icon">&#9660;</span>
                      </div>
                    </div>
                  </div>

                  <!-- Bekerja -->
                  <div class="col-lg-12 spasi">
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
                  </div>
                  
                  <!-- Tempat Kerja -->
                  <div class="col-lg-12" id="tempat_kerja_container" style="display: none;">
                    <label for="tempat_kerja">Nama Tempat Bekerja</label>
                    <div class="contact-field position-relative c-name mb-4">
                      <input
                        type="text"
                        id="tempat_kerja"
                        name="tempat_kerja"
                        placeholder="Tuliskan nama tempat kerja"
                        oninput="this.value = this.value.toUpperCase();" />
                    </div>
                  </div>

                  <!-- Agama -->
                  <div class="col-lg-12">
                    <label for="agama">Agama</label>
                    <div class="contact-field position-relative c-name mb-4">
                      <div class="field-container">
                        <select id="agama" name="agama" required>
                          <option value="" disabled selected>Pilih Agama*</option>
                          <option value="Islam">Islam</option>
                          <option value="Protestan">Protestan</option>
                          <option value="Katolik">Katolik</option>
                          <option value="Hindu">Hindu</option>
                          <option value="Buddha">Buddha</option>
                          <option value="Konghucu">Konghucu</option>
                        </select>
                        <span class="dropdown-icon">&#9660;</span>
                      </div>
                    </div>
                  </div>

                  <!-- Pertanyaan -->
                  <div class="col-lg-12">
                    <label for="pertanyaan">Pertanyaan/Pesan</label>
                    <div class="contact-field position-relative c-name mb-4">
                      <textarea
                        id="pertanyaan"
                        name="pertanyaan"
                        rows="5"
                        placeholder="Tuliskan pertanyaan atau pesan jika ada"></textarea>
                    </div>
                  </div>

                  <div class="form-buttons">
                    <button type="button" class="pnd-btn prev-step">Kembali</button>
                    <button type="submit" class="pnd-btn">Daftar Sekarang</button>
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
          <h5 class="modal-title"><i class="fas fa-info-circle me-2"></i>Petunjuk Pendaftaran</h5>
          <span id="closeModal" class="close-modal">&times;</span>
        </div>
        <div class="modal-body">
          <div class="steps-container">
            <h5>Langkah-langkah Pendaftaran:</h5>
            
            <div class="step-item">
              <div class="step-number">1</div>
              <div class="step-content">
                <h6>Pilih Jalur Program</h6>
                <p><strong>Reguler/Umum:</strong> Untuk pendaftaran mahasiswa baru menggunakan ijazah SMA/SMK</p>
                <p><strong>Transfer Nilai:</strong> Untuk pindahan jurusan atau transfer nilai dari kampus sebelumnya</p>
              </div>
            </div>
            
            <div class="step-item">
              <div class="step-number">2</div>
              <div class="step-content">
                <h6>Isi Data Pribadi</h6>
                <p>Pastikan data Anda sesuai dengan KTP atau dokumen resmi</p>
                <p>Nomor HP harus aktif dan terhubung dengan WhatsApp</p>
              </div>
            </div>
            
            <div class="step-item">
              <div class="step-number">3</div>
              <div class="step-content">
                <h6>Lengkapi Informasi Tambahan</h6>
                <p>Isi domisili dan informasi tambahan lainnya</p>
                <p>Setelah mengirim pendaftaran, Anda akan dihubungi via WhatsApp</p>
              </div>
            </div>
          </div>
          
          <div class="mt-4 info-box">
            <h6 class="mb-3"><i class="fas fa-headset me-2"></i>Butuh bantuan?</h6>
            <p>Tim kami siap membantu Anda selama proses pendaftaran:</p>
            <ul class="contact-list">
              <li>
                <div class="d-flex align-items-center mb-2">
                  <div class="icon me-2">
                    <span class="icon-phone-call"></span>
                  </div>
                  <p class="mb-0">+62 813-5561-9225 <small>(WhatsApp)</small></p>
                </div>
              </li>
              <li>
                <div class="d-flex align-items-center">
                  <div class="icon me-2">
                    <span class="icon-mail"></span>
                  </div>
                  <p class="mb-0">
                    <a href="mailto:saluttanatoraja@gmail.com">saluttanatoraja@gmail.com</a>
                  </p>
                </div>
              </li>
            </ul>
          </div>
        </div>
        <div class="modal-footer">
          <button id="closeModalBtn" class="btn btn-secondary">
            <i class="fas fa-times me-1"></i> Tutup
          </button>
          <button id="startRegistrationBtn" class="btn btn-primary">
            <i class="fas fa-check-circle me-1"></i> Mulai Pendaftaran
          </button>
        </div>
      </div>
    </div>

    <!-- Alert Container -->
    <div id="alert-container"></div>

    <!--Start Footer Three-->
    <footer class="footer-three">
      <!-- Start Footer Main -->
      <div class="footer-main footer-main__three">
        <div class="footer-three__shape1">
          <img src="../assets/img/shape/footer-v3-img1.jpg" alt="" />
        </div>
        <div class="footer-three__shape2">
          <img src="../assets/img/shape/footer-v3-img2.jpg" alt="" />
        </div>
        <div class="container">
          <div class="row">
            <!--Start Single Footer Widget-->
            <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".3s">
              <div class="single-footer-widget single-footer-widget-style2 ml50">
                <div class="title">
                  <h3>Kontak</h3>
                </div>
                <div class="single-footer-widget-box single-footer-widget__links single-footer-widget__links-style2">
                  <ul class="clearfix">
                    <li>
                      <div class="icon">
                        <span class="icon-phone-call"></span>
                      </div>
                      <p>+62 813-5561-9225</p>
                    </li>
                    <li>
                      <div class="icon">
                        <span class="icon-mail"></span>
                      </div>
                      <p>
                        <a href="mailto:saluttanatoraja@gmail.com">saluttanatoraja@gmail.com</a>
                      </p>
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
            <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".3s">
              <div class="single-footer-widget single-footer-widget-style2 ml50">
                <div class="title">
                  <h3>Administrasi</h3>
                </div>
                <div class="single-footer-widget-box single-footer-widget__links single-footer-widget__links-style2">
                  <ul class="clearfix">
                    <li>
                      <p><a href="../administrasi/registrasi.php">Registrasi</a></p>
                    </li>
                    <li>
                      <p><a href="../administrasi/pemesananModul.php">Pemesanan Modul</a></p>
                    </li>
                    <li>
                      <p><a href="../administrasi/alihKredit.php">Alih Kredit</a></p>
                    </li>
                    <li>
                      <p><a href="../administrasi/legalisir.php">Legalisir Ijazah</a></p>
                    </li>
                    <li>
                      <p><a href="../administrasi/suratKeterangan.php">Surat Keterangan</a></p>
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
    </footer>
    <!--End Footer Three-->

    <!-- Scroll-top -->
    <button class="scroll-top scroll-to-target" data-target="html">
      <i class="icon-down-arrow"></i>
    </button>
    <!-- Scroll-top-end-->

    <script>
      // Make jurusanData available to JavaScript
      const jurusanData = <?php echo $jurusanDataJSON; ?>;
      const kelurahanData = <?php echo $kelurahanDataJSON; ?>;
      
      // Modal handling
      document.addEventListener('DOMContentLoaded', function() {
        const petunjukModal = document.getElementById('petunjukModal');
        const showPetunjukBtn = document.getElementById('showPetunjukBtn');
        const closeModal = document.getElementById('closeModal');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const startRegistrationBtn = document.getElementById('startRegistrationBtn');
        
        if (showPetunjukBtn && petunjukModal) {
          showPetunjukBtn.addEventListener('click', function() {
            petunjukModal.style.display = 'block';
          });
        }
        
        if (closeModal) {
          closeModal.addEventListener('click', function() {
            petunjukModal.style.display = 'none';
          });
        }
        
        if (closeModalBtn) {
          closeModalBtn.addEventListener('click', function() {
            petunjukModal.style.display = 'none';
          });
        }
        
        if (startRegistrationBtn) {
          startRegistrationBtn.addEventListener('click', function() {
            petunjukModal.style.display = 'none';
            document.querySelector('input[name="jalur_program"]').focus();
          });
        }
        
        // Close modal when clicking outside
        window.addEventListener('click', function(event) {
          if (event.target === petunjukModal) {
            petunjukModal.style.display = 'none';
          }
        });
        
        // Show instructions modal automatically after short delay
        setTimeout(() => {
          if (petunjukModal && !sessionStorage.getItem('instructionsShown')) {
            petunjukModal.style.display = 'block';
            sessionStorage.setItem('instructionsShown', 'true');
          }
        }, 1500);
      });
    </script>

    <script src="../assets/js/jquery-3.6.0.min.js"></script>
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
    <script src="../assets/js/15-jquery.countdown.min.js"></script>
    <script src="../assets/js/16-progress-bar.min.js"></script>
    <script src="../assets/js/18-jquery.nice-select.min.js"></script>
    <script src="../assets/vendor/jarallax/jarallax.min.js"></script>
    <script src="../assets/vendor/jarallax/jarallax-video.min.js"></script>
    <script src="../assets/vendor/marquee/marquee.min.js"></script>
    <script src="../assets/vendor/odometer/odometer.min.js"></script>
    <script src="../assets/vendor/appear/appear.min.js"></script>

    <script src="../assets/js/main.js"></script>
    <script src="pendaftaran.js"></script>
  </body>
</html>