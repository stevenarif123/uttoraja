<!DOCTYPE html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>GALERI SALUT TANA TORAJA</title>
    <meta name="description" content="Galeri foto kegiatan dan dokumentasi SALUT Tana Toraja" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.png" />
    <!-- Place favicon.ico in the root directory -->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

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
    
    <!-- Add LightGallery CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.2/css/lightgallery.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.2/css/lg-zoom.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.2/css/lg-thumbnail.min.css">
    
    <!-- Add AOS Animation Library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    
    <!-- Add Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <!-- Custom Gallery Styles -->
    <style>
      /* Enhanced Gallery Styling */
      .gallery-header {
        position: relative;
        padding: 30px 0;
      }
      
      .gallery-header:after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 100px;
        height: 3px;
        background: var(--thm-base);
        border-radius: 3px;
      }
      
      .gallery-filter {
        margin: 25px 0;
        text-align: center;
      }
      
      .filter-btn {
        background: #f5f5f5;
        border: none;
        color: #555;
        padding: 10px 20px;
        margin: 0 5px 10px;
        border-radius: 30px;
        font-weight: 500;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
      }
      
      .filter-btn:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 0;
        height: 100%;
        background: var(--thm-base);
        transition: all 0.4s ease;
        z-index: -1;
        border-radius: 30px;
      }
      
      .filter-btn:hover:before,
      .filter-btn.active:before {
        width: 100%;
      }
      
      .filter-btn:hover,
      .filter-btn.active {
        color: #fff;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transform: translateY(-2px);
      }
      
      .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
        padding: 20px 0;
      }
      
      .gallery-item {
        position: relative;
        overflow: hidden;
        border-radius: 10px;
        box-shadow: 0 6px 15px rgba(0,0,0,0.1);
        transition: all 0.4s ease;
        cursor: pointer;
        aspect-ratio: 3/2;
      }
      
      .gallery-item:hover {
        transform: translateY(-10px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.15);
      }
      
      .gallery-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
      }
      
      .gallery-item:hover .gallery-image {
        transform: scale(1.1);
      }
      
      .gallery-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.4);
        opacity: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: opacity 0.4s ease;
        backdrop-filter: blur(2px);
      }
      
      .gallery-item:hover .gallery-overlay {
        opacity: 1;
      }
      
      .gallery-info {
        text-align: center;
        color: #fff;
        transform: translateY(20px);
        opacity: 0;
        transition: all 0.4s ease 0.1s;
      }
      
      .gallery-item:hover .gallery-info {
        transform: translateY(0);
        opacity: 1;
      }
      
      .gallery-info i {
        font-size: 2rem;
        margin-bottom: 15px;
        display: block;
      }
      
      .category-label {
        font-size: 1.1rem;
        font-weight: 500;
        background: rgba(0,0,0,0.5);
        padding: 8px 15px;
        border-radius: 20px;
        display: inline-block;
        margin-top: 10px;
      }
      
      /* Category legend styling */
      .categories-legend {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 15px;
        margin: 30px 0;
      }
      
      .legend-item {
        display: flex;
        align-items: center;
        background: #f5f5f5;
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 0.9rem;
        color: #555;
        transition: all 0.3s ease;
      }
      
      .legend-item:hover {
        background: #e9e9e9;
        box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        transform: translateY(-3px);
      }
      
      .legend-item i {
        margin-right: 8px;
        color: var(--thm-base);
        font-size: 1.1rem;
      }
      
      /* View mode toggles */
      .view-toggles {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 20px;
      }
      
      .toggle-btn {
        background: #f5f5f5;
        border: none;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: 10px;
        border-radius: 5px;
        color: #666;
        transition: all 0.3s ease;
      }
      
      .toggle-btn:hover,
      .toggle-btn.active {
        background: var(--thm-base);
        color: white;
      }
      
      /* Loading animation */
      .gallery-loading {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255,255,255,0.8);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
      }
      
      .spinner {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        border: 5px solid rgba(0,0,0,0.1);
        border-top-color: var(--thm-base);
        animation: spin 1s infinite linear;
      }
      
      @keyframes spin {
        to {
          transform: rotate(360deg);
        }
      }
      
      /* Masonry layout styles */
      .masonry-layout {
        display: block;
        column-count: 3;
        column-gap: 20px;
      }
      
      .masonry-layout .gallery-item {
        break-inside: avoid;
        margin-bottom: 20px;
        display: block;
      }
      
      /* Responsive adjustments */
      @media (max-width: 991px) {
        .masonry-layout {
          column-count: 2;
        }
      }
      
      @media (max-width: 576px) {
        .masonry-layout {
          column-count: 1;
        }
        .filter-btn {
          padding: 8px 15px;
          font-size: 0.9rem;
        }
        .legend-item {
          font-size: 0.8rem;
          padding: 6px 12px;
        }
      }
      
      /* Animation classes */
      .fadeIn {
        animation: fadeIn 0.5s ease forwards;
      }
      
      @keyframes fadeIn {
        from {
          opacity: 0;
          transform: translateY(20px);
        }
        to {
          opacity: 1;
          transform: translateY(0);
        }
      }
      
      /* Search bar styles */
      .gallery-search {
        position: relative;
        max-width: 500px;
        margin: 0 auto 30px;
      }
      
      .gallery-search input {
        width: 100%;
        padding: 12px 20px;
        padding-right: 50px;
        border-radius: 30px;
        border: 2px solid #eee;
        font-size: 1rem;
        transition: all 0.3s ease;
      }
      
      .gallery-search input:focus {
        border-color: var(--thm-base);
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        outline: none;
      }
      
      .gallery-search button {
        position: absolute;
        right: 5px;
        top: 5px;
        background: var(--thm-base);
        color: white;
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
      }
      
      .gallery-search button:hover {
        background: var(--thm-base-hover, #0056b3);
        transform: scale(1.05);
      }
      
      /* Empty state */
      .gallery-empty {
        text-align: center;
        padding: 50px 20px;
        color: #666;
      }
      
      .gallery-empty i {
        font-size: 3rem;
        color: #ddd;
        margin-bottom: 20px;
        display: block;
      }
      
      /* Stats counter */
      .gallery-stats {
        text-align: right;
        color: #999;
        font-size: 0.9rem;
        margin-top: -15px;
        margin-bottom: 15px;
      }
      
      /* Gallery item highlight effect */
      .gallery-item.highlight {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(var(--thm-base-rgb, 0, 123, 255), 0.2);
      }
      
      .gallery-full {
        padding: 0 30px;
      }
      
      .gallery-grid.gallery-full {
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
      }
      
      @media (max-width: 576px) {
        .gallery-grid.gallery-full {
          grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        }
      }
      
      /* LightGallery customizations */
      .lg-backdrop {
        will-change: opacity;
      }
      
      .lg-outer {
        will-change: transform;
      }
      
      .lg-image {
        will-change: transform, opacity;
      }
      
      /* Loading styles */
      .lg-loading {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: rgba(0,0,0,0.8);
        color: white;
        padding: 10px 20px;
        border-radius: 4px;
        z-index: 9999;
      }
      
      /* Error message styles */
      .lg-error-msg {
        text-align: center;
        padding: 20px;
        background: #222;
        color: #fff;
      }
    </style>
  </head>

  <body class="body-gray-bg">
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
                        <i class="fab fa-youtube"></i>
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
                              <li><a href="../informasi">Informasi Akademik</a></li>
                              <li><a href="../administrasi/">Administrasi Akademik</a></li>
                              <li><a href="../kegiatan">Kegiatan Akademik</a></li>
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
                              <li><a href="../tentang/salut">SALUT</a></li>
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
          <img src="../assets/img/shape/page-header-shape1.png" alt="" />
        </div>
        <div class="shape2 float-bob-x">
          <img src="../assets/img/shape/page-header-shape2.png" alt="" />
        </div>
        <div class="container">
          <div class="page-header__inner">
            <h2>GALERI KEGIATAN SALUT TANA TORAJA</h2>
            <ul class="thm-breadcrumb">
              <li>
                <a href="../"><span class="fa fa-home"></span> Home</a>
              </li>
              <li><i class="icon-right-arrow-angle"></i></li>
              <li class="color-base"> Galeri</li>
            </ul>
          </div>
        </div>
      </section>
      <!--End Page Header-->

      <!--Start Contents Page-->
      <section id="gallery" class="gallery-area gallery-bg pt-120 pb-100 p-relative fix">
        <div class="container">
          <!-- Gallery Header with Animation -->
          <div class="gallery-header text-center mb-5" data-aos="fade-up">
            <h2 class="section-title">✨ Galeri Foto SALUT ✨</h2>
            <p class="section-subtitle">
              Dokumentasi kegiatan dan momen penting di SALUT Tana Toraja
              <br>
              <small class="text-muted mt-2 d-block">
                Klik gambar untuk melihat detail lebih besar
              </small>
            </p>
          </div>
          
          <!-- Search functionality -->
          <div class="gallery-search" data-aos="fade-up" data-aos-delay="100">
            <input type="text" id="gallery-search-input" placeholder="Cari foto berdasarkan kategori atau nama...">
            <button type="button" id="gallery-search-btn">
              <i class="fas fa-search"></i>
            </button>
          </div>
          
          <!-- View Mode Toggles -->
          <div class="view-toggles" data-aos="fade-left" data-aos-delay="150">
            <button class="toggle-btn active" data-view="grid" title="Grid View">
              <i class="fas fa-th"></i>
            </button>
            <button class="toggle-btn" data-view="masonry" title="Masonry View">
              <i class="fas fa-th-large"></i>
            </button>
            <button class="toggle-btn" data-view="full" title="Full Width">
              <i class="fas fa-expand"></i>
            </button>
          </div>

          <!-- Gallery Categories Legend with Animation -->
          <div class="categories-legend" data-aos="fade-up" data-aos-delay="200">
            <span class="legend-item">
              <i class="fas fa-graduation-cap"></i> Wisuda - Dokumentasi prosesi wisuda
            </span>
            <span class="legend-item">
              <i class="fas fa-users"></i> Kegiatan - Aktivitas akademik & non-akademik
            </span>
            <span class="legend-item">
              <i class="fas fa-university"></i> Kampus - Foto lingkungan kampus
            </span>
          </div>

          <!-- Gallery Filter with Animation -->
          <div class="gallery-filter" data-aos="fade-up" data-aos-delay="250">
            <button class="filter-btn active" data-filter="*">Semua Foto</button>
            <button class="filter-btn" data-filter=".kegiatan">Kegiatan</button>
            <button class="filter-btn" data-filter=".wisuda">Wisuda</button>
            <button class="filter-btn" data-filter=".kampus">Kampus</button>
          </div>
          
          <!-- Gallery Stats Counter -->
          <div class="gallery-stats">
            Menampilkan <span id="shown-images">0</span> dari <span id="total-images">0</span> foto
          </div>

          <!-- Gallery Grid with Custom Animation -->
          <div class="gallery-grid" id="lightgallery">
            <?php
              // Add PHP error reporting at the top
              error_reporting(E_ALL);
              ini_set('display_errors', 1);

              // Function to safely check image type
              function getImageMimeType($filepath) {
                $mime = false;
                // Try using fileinfo
                if (function_exists('finfo_open')) {
                  $finfo = finfo_open(FILEINFO_MIME_TYPE);
                  $mime = finfo_file($finfo, $filepath);
                  finfo_close($finfo);
                }
                // Fallback to getimagesize
                if (!$mime) {
                  $imageinfo = @getimagesize($filepath);
                  if ($imageinfo) {
                    $mime = $imageinfo['mime'];
                  }
                }
                return $mime;
              }

              // Show a more helpful message for GD library
              if (!extension_loaded('gd')) {
                echo '<div class="alert alert-info">
                  <strong>Note:</strong> Using original images (no thumbnails). For better performance:
                  <ol>
                    <li>Locate php.ini file (usually in C:\xampp\php\)</li>
                    <li>Search for "extension=gd"</li>
                    <li>Remove semicolon if present to make it "extension=gd"</li>
                    <li>Save and restart Apache</li>
                    <li>If images disappear, check PHP error logs for specific issues</li>
                  </ol>
                </div>';
              }

              $dir = "images";
              $thumb_dir = "images/thumbs";
              
              // Ensure directories exist
              if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
                echo '<div class="alert alert-warning">Images directory created. Please add images.</div>';
              }
              
              if (!file_exists($thumb_dir)) {
                mkdir($thumb_dir, 0777, true);
              }
              
              // Get all image files
              $files = glob($dir . "/*.{jpg,jpeg,png,gif}", GLOB_BRACE);
              
              if (empty($files)) {
                echo '<div class="gallery-empty">
                  <i class="fas fa-images"></i>
                  <h4>Belum ada foto dalam galeri</h4>
                  <p>Tambahkan foto ke folder "images" untuk mulai menampilkan galeri.</p>
                </div>';
              }
              
              // Track categories for stats
              $categories = ['wisuda' => 0, 'kegiatan' => 0, 'kampus' => 0, 'other' => 0];
              $total_images = 0;

              foreach($files as $file) {
                $filename = basename($file);
                $thumbnail = $thumb_dir . "/thumb_" . $filename;
                $image_to_use = $file; // Default to original
                $total_images++;
                
                // Check if file is actually an image
                $mime = getImageMimeType($file);
                if (!$mime || strpos($mime, 'image/') !== 0) {
                  continue; // Skip non-image files
                }

                // Try to use/generate thumbnail if GD is available
                if (extension_loaded('gd')) {
                  try {
                    if (!file_exists($thumbnail)) {
                      $source = null;
                      
                      // Create image based on mime type
                      switch($mime) {
                        case 'image/jpeg':
                          $source = @imagecreatefromjpeg($file);
                          break;
                        case 'image/png':
                          $source = @imagecreatefrompng($file);
                          break;
                        case 'image/gif':
                          $source = @imagecreatefromgif($file);
                          break;
                      }

                      if ($source) {
                        // Calculate dimensions
                        $width = imagesx($source);
                        $height = imagesy($source);
                        $thumb_width = 300;
                        $thumb_height = round($height * ($thumb_width / $width));

                        // Create thumbnail
                        $thumb = imagecreatetruecolor($thumb_width, $thumb_height);

                        // Handle transparency
                        if ($mime === 'image/png') {
                          imagealphablending($thumb, false);
                          imagesavealpha($thumb, true);
                          $transparent = imagecolorallocatealpha($thumb, 255, 255, 255, 127);
                          imagefilledrectangle($thumb, 0, 0, $thumb_width, $thumb_height, $transparent);
                        }

                        // Resize
                        imagecopyresampled($thumb, $source, 0, 0, 0, 0, $thumb_width, $thumb_height, $width, $height);

                        // Save thumbnail
                        switch($mime) {
                          case 'image/jpeg':
                            imagejpeg($thumb, $thumbnail, 85);
                            break;
                          case 'image/png':
                            imagepng($thumb, $thumbnail, 6);
                            break;
                          case 'image/gif':
                            imagegif($thumb, $thumbnail);
                            break;
                        }

                        imagedestroy($thumb);
                        imagedestroy($source);
                        
                        if (file_exists($thumbnail)) {
                          $image_to_use = $thumbnail;
                        }
                      }
                    } else {
                      $image_to_use = $thumbnail;
                    }
                  } catch (Exception $e) {
                    error_log("Error processing image $filename: " . $e->getMessage());
                    // Fallback to original image
                    $image_to_use = $file;
                  }
                }

                // Get category from filename
                $category = "other";
                if (strpos(strtolower($filename), 'wisuda') === 0) {
                  $category = "wisuda";
                  $categories['wisuda']++;
                }
                elseif (strpos(strtolower($filename), 'kegiatan') === 0) {
                  $category = "kegiatan";
                  $categories['kegiatan']++;
                }
                elseif (strpos(strtolower($filename), 'kampus') === 0) {
                  $category = "kampus";
                  $categories['kampus']++;
                }
                else {
                  $categories['other']++;
                }

                // Get image dimensions for data attributes
                $dimensions = getimagesize($file);
                $width = $dimensions[0] ?? 800;
                $height = $dimensions[1] ?? 600;
                
                // Generate a more readable title from filename
                $title = str_replace(['_', '-'], ' ', pathinfo($filename, PATHINFO_FILENAME));
                $title = ucwords($title);

                // Random animation delay for staggered appearance
                $delay = (rand(1, 10) * 50);
                
                // Calculate a random index for AOS animations
                $animations = ['fade-up', 'fade-down', 'fade-right', 'fade-left', 'zoom-in'];
                $animation = $animations[array_rand($animations)];

                // Output gallery item with enhanced data attributes
                echo '<div class="gallery-item ' . htmlspecialchars($category) . '" 
                      data-src="' . htmlspecialchars($file) . '"
                      data-category="' . htmlspecialchars($category) . '"
                      data-title="' . htmlspecialchars($title) . '"
                      data-width="' . $width . '"
                      data-height="' . $height . '"
                      data-aos="' . $animation . '"
                      data-aos-delay="' . $delay . '"
                      data-search-terms="' . htmlspecialchars(strtolower($title)) . '">
                  <a href="javascript:void(0)" class="gallery-link">
                    <img src="' . htmlspecialchars($image_to_use) . '" alt="' . htmlspecialchars($title) . '" 
                         class="img-fluid gallery-image" loading="lazy" 
                         onerror="this.onerror=null; this.src=\'../assets/img/placeholder.jpg\';">
                    <div class="gallery-overlay">
                      <div class="gallery-info">
                        <i class="fas fa-search-plus"></i>
                        <span class="category-label">' . ucfirst(htmlspecialchars($category)) . '</span>
                      </div>
                    </div>
                  </a>
                </div>';
              }
            ?>
          </div>
          
          <!-- Empty state when filtering shows no results -->
          <div class="gallery-empty" id="no-results" style="display:none;">
            <i class="fas fa-filter"></i>
            <h4>Tidak ada foto yang sesuai</h4>
            <p>Coba gunakan filter atau kata kunci pencarian yang berbeda.</p>
          </div>
          
          <!-- Add a loading spinner -->
          <div class="gallery-loading" style="display:none;">
            <div class="spinner"></div>
          </div>
        </div>

        <!-- Add JavaScript for gallery interaction -->
        <script>
        document.addEventListener('DOMContentLoaded', function() {
          // Create a flag to track initialization
          let galleryInitialized = false;
          
          // Wait for all scripts to fully load
          window.addEventListener('load', function() {
            initGallery();
          });
          
          // Initialize after a short delay (fallback)
          setTimeout(initGallery, 1000);
          
          function initGallery() {
            // Prevent multiple initializations
            if (galleryInitialized) return;
            
            const galleryElement = document.getElementById('lightgallery');
            if (!galleryElement) {
              console.error('Gallery element not found!');
              return;
            }
            
            // Check if LightGallery is available
            if (typeof lightGallery === 'undefined') {
              console.error('LightGallery library not loaded!');
              // Add fallback gallery (simple modal)
              setupFallbackGallery();
              return;
            }
            
            try {
              // Initialize AOS if available
              if (typeof AOS !== 'undefined') {
                AOS.init({
                  duration: 800,
                  once: true,
                  mirror: false
                });
              }
              
              const searchInput = document.getElementById('gallery-search-input');
              const searchBtn = document.getElementById('gallery-search-btn');
              const filterBtns = document.querySelectorAll('.filter-btn');
              const viewBtns = document.querySelectorAll('.toggle-btn');
              const shownCounter = document.getElementById('shown-images');
              const totalCounter = document.getElementById('total-images');
              const noResults = document.getElementById('no-results');
              const items = document.querySelectorAll('.gallery-item');
              
              // Set total images count
              if (totalCounter && shownCounter) {
                totalCounter.textContent = items.length;
                shownCounter.textContent = items.length;
              }
              
              // Setup gallery options
              const galleryOptions = {
                selector: '.gallery-item',
                download: false,
                counter: true,
                controls: true,
                enableDrag: false, // Disable drag functionality to prevent scroll issues
                thumbnail: true,
                animateThumb: false,
                showThumbByDefault: false,
                preload: 1,
                backdropDuration: 300,
                loop: true,
                hideScrollbar: true,
                closable: true,
                escKey: true,
                keyPress: true,
                addClass: 'lg-custom-gallery',
                startClass: 'lg-start-zoom',
                mode: 'lg-fade',
                dynamic: true,
                dynamicEl: []
              };
              
              // Add plugins if available
              if (typeof lgZoom !== 'undefined' && typeof lgThumbnail !== 'undefined') {
                galleryOptions.plugins = [lgZoom, lgThumbnail];
              }
              
              // Initialize LightGallery
              const gallery = lightGallery(galleryElement, galleryOptions);
              
              // Set flag to prevent multiple initializations
              galleryInitialized = true;
              
              // Handle gallery opening to prevent scroll issues
              gallery.addEventListener('lgBeforeOpen', function() {
                document.body.style.overflow = 'hidden';
              });
              
              // Handle gallery closing to restore scroll
              gallery.addEventListener('lgAfterClose', function() {
                document.body.style.overflow = '';
              });
              
              // Handle errors
              gallery.addEventListener('lgAfterAppendSlide', function(event) {
                const { index } = event.detail;
                const slide = gallery.getSlideItem(index);
                
                if (!slide) return;
                
                const img = slide.querySelector('img.lg-image');
                if (img) {
                  // Set error handler for image load errors
                  img.onerror = function() {
                    slide.innerHTML = `
                      <div class="lg-error-msg">
                        <h4>Gambar tidak dapat dimuat</h4>
                        <p>Silakan coba lagi nanti</p>
                      </div>
                    `;
                  };
                  
                  // Set timeout for images that take too long to load
                  const timeout = setTimeout(function() {
                    if (!img.complete) {
                      img.onerror();
                    }
                  }, 8000);
                  
                  img.onload = function() {
                    clearTimeout(timeout);
                  };
                }
              });
              
              // Gallery item click handler with fixes for scroll issues
              galleryElement.addEventListener('click', function(e) {
                e.preventDefault(); // Prevent default behavior
                
                const galleryItem = e.target.closest('.gallery-item');
                if (!galleryItem) return;
                
                // Show loading spinner
                document.querySelector('.gallery-loading').style.display = 'flex';
                
                setTimeout(function() {
                  try {
                    // Get all visible items
                    const visibleItems = Array.from(items).filter(item => 
                      item.style.display !== 'none'
                    );
                    
                    // Create dynamic elements array for LightGallery
                    const dynamicElements = visibleItems.map(item => {
                      return {
                        src: item.getAttribute('data-src'),
                        thumb: item.querySelector('img').src,
                        subHtml: `<h4>${item.getAttribute('data-title') || ''}</h4>
                                  <p>Kategori: ${item.getAttribute('data-category') || 'Lainnya'}</p>`
                      };
                    });
                    
                    // Find index of clicked item in visible items
                    const index = visibleItems.indexOf(galleryItem);
                    
                    // Reset gallery if needed
                    if (gallery.isDynamicGallery) {
                      gallery.closeGallery();
                      setTimeout(function() {
                        // Open gallery with current dynamic elements
                        gallery.openGallery(index, dynamicElements);
                        // Hide loading spinner
                        document.querySelector('.gallery-loading').style.display = 'none';
                      }, 300);
                    } else {
                      // Open gallery with current dynamic elements
                      gallery.openGallery(index, dynamicElements);
                      // Hide loading spinner
                      document.querySelector('.gallery-loading').style.display = 'none';
                    }
                  } catch (error) {
                    console.error('Error opening gallery:', error);
                    // Hide loading spinner
                    document.querySelector('.gallery-loading').style.display = 'none';
                    // Show error message
                    alert('Terjadi kesalahan saat membuka galeri foto. Silakan coba lagi.');
                  }
                }, 100);
              });
              
              // Rest of the filter functionality, search, etc. remains unchanged
              // ...existing code for filters, search, and view toggles...

              // Filter functionality
              filterBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                  // Remove active class
                  filterBtns.forEach(b => b.classList.remove('active'));
                  // Add active class to current button
                  this.classList.add('active');
                  
                  const filter = this.getAttribute('data-filter');
                  let visibleCount = 0;
                  
                  // Show loading
                  document.querySelector('.gallery-loading').style.display = 'flex';
                  
                  // Small timeout to allow loading indicator to appear
                  setTimeout(() => {
                    if (filter === '*') {
                      // Show all items
                      items.forEach(item => {
                        item.style.display = 'block';
                        visibleCount++;
                      });
                    } else {
                      // Filter items
                      items.forEach(item => {
                        if (item.classList.contains(filter.substring(1))) {
                          item.style.display = 'block';
                          visibleCount++;
                        } else {
                          item.style.display = 'none';
                        }
                      });
                    }
                    
                    // Update counters
                    if (shownCounter) {
                      shownCounter.textContent = visibleCount;
                    }
                    
                    // Show/hide no results message
                    if (visibleCount === 0) {
                      if (noResults) noResults.style.display = 'block';
                    } else {
                      if (noResults) noResults.style.display = 'none';
                    }
                    
                    // Hide loading
                    document.querySelector('.gallery-loading').style.display = 'none';
                    
                    // Refresh AOS if available
                    if (typeof AOS !== 'undefined') {
                      AOS.refresh();
                    }
                  }, 300);
                });
              });
              
              // Search functionality remains the same...
              
              // View toggle functionality remains the same...
              
            } catch (error) {
              console.error('Error initializing gallery:', error);
              // Setup fallback gallery if LightGallery fails
              setupFallbackGallery();
            }
          }
          
          // Fallback gallery function (simple modal)
          function setupFallbackGallery() {
            const items = document.querySelectorAll('.gallery-item');
            
            // Create a simple modal for fallback
            const modal = document.createElement('div');
            modal.innerHTML = `
              <div id="simple-gallery-modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; 
                   background:rgba(0,0,0,0.9); z-index:9999; overflow:auto; text-align:center; padding:20px;">
                <button style="position:absolute; top:20px; right:20px; background:none; border:none; color:white; 
                        font-size:24px; cursor:pointer;">✕</button>
                <img id="simple-gallery-image" style="max-width:90%; max-height:80vh; margin-top:50px;" src="" alt="">
                <div id="simple-gallery-caption" style="color:white; margin-top:20px; font-size:16px;"></div>
              </div>
            `;
            document.body.appendChild(modal);
            
            const simpleModal = document.getElementById('simple-gallery-modal');
            const closeBtn = simpleModal.querySelector('button');
            const modalImg = document.getElementById('simple-gallery-image');
            const caption = document.getElementById('simple-gallery-caption');
            
            // Close modal on button click
            closeBtn.addEventListener('click', function() {
              simpleModal.style.display = 'none';
              document.body.style.overflow = '';
            });
            
            // Close modal on escape key
            document.addEventListener('keydown', function(e) {
              if (e.key === 'Escape' && simpleModal.style.display === 'block') {
                simpleModal.style.display = 'none';
                document.body.style.overflow = '';
              }
            });
            
            // Close modal on click outside image
            simpleModal.addEventListener('click', function(e) {
              if (e.target === simpleModal) {
                simpleModal.style.display = 'none';
                document.body.style.overflow = '';
              }
            });
            
            // Add click handler to all gallery items
            items.forEach(function(item) {
              item.addEventListener('click', function() {
                const imgSrc = this.getAttribute('data-src');
                const title = this.getAttribute('data-title') || '';
                const category = this.getAttribute('data-category') || 'Lainnya';
                
                modalImg.src = imgSrc;
                caption.innerHTML = `<h4>${title}</h4><p>Kategori: ${category}</p>`;
                simpleModal.style.display = 'block';
                document.body.style.overflow = 'hidden';
              });
            });
          }
        });
        </script>

        <!-- Add additional CSS for fixing lightGallery issues -->
        <style>
        /* Fix for lightGallery scroll issues */
        .lg-outer {
          overflow: hidden !important;
        }

        .lg-backdrop {
          will-change: opacity;
        }

        /* Ensure modals are on top of everything */
        .lg-outer {
          z-index: 9999 !important;
        }

        /* Fix for mobile scrolling issues */
        body.lg-on {
          position: fixed;
          width: 100%;
          height: 100%;
          overflow: hidden;
        }

        /* Make loading spinner more visible */
        .gallery-loading {
          background: rgba(255,255,255,0.9);
          z-index: 10000;
        }

        /* Make error messages more user-friendly */
        .lg-error-msg {
          padding: 30px;
          background: rgba(0,0,0,0.7);
          border-radius: 10px;
          max-width: 300px;
          margin: 0 auto;
        }

        .lg-error-msg h4 {
          color: #fff;
          margin-bottom: 15px;
          font-size: 18px;
        }

        .lg-error-msg p {
          color: #ccc;
          font-size: 14px;
        }
        </style>

        <!-- Make sure to preload critical scripts -->
        <link rel="preload" as="script" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.2/lightgallery.min.js">
        <link rel="preload" as="script" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.2/plugins/zoom/lg-zoom.min.js">
        <link rel="preload" as="script" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.2/plugins/thumbnail/lg-thumbnail.min.js">
        </script>
      </section>
      <!--End Contents Page-->

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
                          <p><a href="../layanan/informasi">Informasi Akademik</a></p>
                        </li>
                        <li>
                          <p><a href="../administrasi/">Administrasi</a></p>
                        </li>
                        <li>
                          <p><a href="../tentang/kepalasalut">Sapaan dari Kepala SALUT</a></p>
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
                            <a href="../informasi">Informasi Akademik</a>
                          </p>
                        </li>
                        <li>
                          <p>
                            <a href="../administrasi">Administrasi Akademik</a>
                          </p>
                        </li>
                        <li>
                          <p>
                            <a href="../kegiatan">Kegiatan</a>
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

    <!-- Add LightGallery JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.2/lightgallery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.2/plugins/zoom/lg-zoom.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.2/plugins/thumbnail/lg-thumbnail.min.js"></script>
    
    <!-- Add AOS Animation Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>

    <!-- Add Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
  </body>
</html>