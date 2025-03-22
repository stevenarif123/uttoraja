<?php
session_start();

// Initialize success message if not set
if (!isset($_SESSION['registration_success'])) {
    $_SESSION['registration_success'] = "Selamat! Pendaftaran Anda telah berhasil dikirim.";
}
?>

<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>Pendaftaran Berhasil - SALUT TANA TORAJA</title>
  <meta name="description" content="Pendaftaran mahasiswa baru Universitas Terbuka SALUT Tana Toraja berhasil" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.png" />

  <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />

  <!-- CSS here -->
  <link rel="stylesheet" href="../assets/css/01-bootstrap.min.css" />
  <link rel="stylesheet" href="../assets/css/02-all.min.css" />
  <link rel="stylesheet" href="../assets/css/style.css" />
  <link rel="stylesheet" href="../assets/css/color1.css" />
  <link rel="stylesheet" href="../assets/css/responsive.css" />
  <link rel="stylesheet" href="../assets/css/costumstyles.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <link rel="stylesheet" href="pendaftaran_sukses.css" />
</head>

<body class="body-gray-bg">
  <!-- Background Decorations -->
  <div class="bg-decoration"></div>
  <div class="bg-decoration"></div>
  <div class="bg-decoration"></div>

  <!-- Confetti Animation -->
  <div class="confetti-container" id="confetti-container"></div>

  <div class="page-wrapper">
    <!--Start Main Header One -->
    <header class="main-header main-header-one">
      <!-- Header content remains the same as in index.php -->
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
          <h2>Pendaftaran Berhasil</h2>
          <ul class="thm-breadcrumb">
            <li>
              <a href="../index.php"><span class="fa fa-home"></span> Home</a>
            </li>
            <li><i class="icon-right-arrow-angle"></i></li>
            <li><a href="index.php">Pendaftaran</a></li>
            <li><i class="icon-right-arrow-angle"></i></li>
            <li class="color-base">Berhasil</li>
          </ul>
        </div>
      </div>
    </section>
    <!--End Page Header-->

    <!-- Success Section -->
    <section class="success-container">
      <div class="container">
        <div class="success-card">
          <!-- Success Icon with Animation -->
          <div class="success-icon">
            <i class="fas fa-check"></i>
          </div>
          
          <!-- Success Message -->
          <h1 class="success-title">
            <span class="animate-wave">👋</span> Pendaftaran Berhasil! <span class="animate-bounce">🎓</span>
          </h1>
          
          <p class="success-message">
            <?php echo $_SESSION['registration_success']; ?>
            <br/>Selamat bergabung dengan keluarga besar Universitas Terbuka SALUT Tana Toraja!
          </p>
          
          <!-- Next Steps Information -->
          <div class="info-box">
            <h5><i class="fas fa-clipboard-list"></i> Langkah Selanjutnya</h5>
            <ul>
              <li>Tim kami akan <strong>memverifikasi data pendaftaran</strong> Anda dalam 1-3 hari kerja.</li>
              <li>Anda akan <strong>dihubungi melalui WhatsApp</strong> yang telah didaftarkan untuk konfirmasi dan informasi selanjutnya.</li>
              <li>Siapkan <strong>dokumen pendukung</strong> seperti ijazah terakhir dan KTP untuk proses verifikasi.</li>
              <li>Apabila dalam 3 hari kerja belum ada konfirmasi, silakan hubungi kami di nomor <strong>+62813-5561-9225</strong>.</li>
            </ul>
          </div>
          
          <!-- Timeline Progress -->
          <div class="registration-timeline">
            <div class="timeline-item active">
              <div class="timeline-icon"><i class="fas fa-check"></i></div>
              <div class="timeline-content">
                <h6>Pendaftaran</h6>
                <p>Form berhasil dikirim</p>
              </div>
            </div>
            <div class="timeline-item">
              <div class="timeline-icon"><i class="fas fa-search"></i></div>
              <div class="timeline-content">
                <h6>Verifikasi</h6>
                <p>Dalam proses</p>
              </div>
            </div>
            <div class="timeline-item">
              <div class="timeline-icon"><i class="fas fa-phone"></i></div>
              <div class="timeline-content">
                <h6>Konfirmasi</h6>
                <p>Via WhatsApp</p>
              </div>
            </div>
            <div class="timeline-item">
              <div class="timeline-icon"><i class="fas fa-user-graduate"></i></div>
              <div class="timeline-content">
                <h6>Mahasiswa Aktif</h6>
                <p>Selamat datang!</p>
              </div>
            </div>
          </div>
          
          <!-- Action Buttons -->
          <div class="action-buttons">
            <a href="../index.php" class="btn-action btn btn-primary">
              <i class="fas fa-home"></i> Kembali ke Beranda
            </a>
            <a href="../informasi.php" class="btn-action btn btn-outline-primary">
              <i class="fas fa-info-circle"></i> Informasi Akademik
            </a>
            <a href="https://wa.me/6281355619225" target="_blank" class="btn-action btn btn-success">
              <i class="fab fa-whatsapp"></i> Hubungi via WhatsApp
            </a>
          </div>
        </div>
      </div>
    </section>

    <!--Start Footer Three-->
    <footer class="footer-three">
      <!-- Footer content remains the same as in index.php -->
    </footer>
    <!--End Footer Three-->
  </div>

  <!-- JS here -->
  <script src="../assets/js/jquery-3.6.0.min.js"></script>
  <script src="../assets/js/02-bootstrap.min.js"></script>
  <script>
    // Enhanced confetti animation
    document.addEventListener('DOMContentLoaded', function() {
      // Create confetti colors
      const confettiColors = [
        '#2563eb', '#0ea5e9', '#10b981', '#f97316', '#f59e0b', '#8b5cf6', '#ec4899'
      ];
      
      // Create shapes
      const shapes = ['circle', 'square', 'triangle'];
      
      // Generate confetti
      for (let i = 0; i < 100; i++) {
        setTimeout(() => createConfetti(), i * 50);
      }
      
      // Confetti creation function
      function createConfetti() {
        const confetti = document.createElement('div');
        confetti.classList.add('confetti');
        
        // Random positioning
        const left = Math.random() * 100;
        confetti.style.left = left + 'vw';
        
        // Random color
        const randomColor = confettiColors[Math.floor(Math.random() * confettiColors.length)];
        confetti.style.backgroundColor = randomColor;
        
        // Random size
        const size = Math.random() * 10 + 5;
        confetti.style.width = size + 'px';
        confetti.style.height = size + 'px';
        
        // Random shape
        const shape = shapes[Math.floor(Math.random() * shapes.length)];
        if (shape === 'circle') {
          confetti.style.borderRadius = '50%';
        } else if (shape === 'triangle') {
          confetti.style.width = '0';
          confetti.style.height = '0';
          confetti.style.backgroundColor = 'transparent';
          confetti.style.borderLeft = `${size/2}px solid transparent`;
          confetti.style.borderRight = `${size/2}px solid transparent`;
          confetti.style.borderBottom = `${size}px solid ${randomColor}`;
        }
        
        // Random rotation
        const rotation = Math.random() * 360;
        confetti.style.transform = `rotate(${rotation}deg)`;
        
        // Random animation duration and delay
        const duration = Math.random() * 3 + 2;
        const delay = Math.random() * 5;
        confetti.style.animationDuration = duration + 's';
        confetti.style.animationDelay = delay + 's';
        
        // Add to container
        document.getElementById('confetti-container').appendChild(confetti);
        
        // Remove after animation
        setTimeout(() => {
          confetti.remove();
          if (Math.random() > 0.3) { // 70% chance to create a new one
            createConfetti();
          }
        }, (duration + delay) * 1000);
      }
      
      // Celebration animation for success elements
      const successElements = document.querySelectorAll('.success-title, .success-icon, .success-message');
      successElements.forEach((el, index) => {
        el.classList.add('animate__animated');
        el.classList.add(index % 2 === 0 ? 'animate__bounceIn' : 'animate__fadeInUp');
        el.style.animationDelay = `${index * 0.2}s`;
      });
    });
    
    // Clear session data after page is loaded
    window.onload = function() {
      setTimeout(() => {
        fetch('clear_session.php', {
          method: 'POST'
        });
      }, 2000);
    };
  </script>
</body>
</html>
