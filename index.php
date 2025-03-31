<!DOCTYPE html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Sentra Layanan Universitas Terbuka Tana Toraja</title>
    <meta name="description" content="Sentra Layanan Universitas Terbuka (SALUT) Tana Toraja - Kuliah online di PTN terbaik Indonesia" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link
      rel="shortcut icon"
      type="image/x-icon"
      href="serve-image.php?img=assets/img/favicon.png"
    />
    <!-- Place favicon.ico in the root directory -->

    <link
      href="https://fonts.googleapis.com/css2?family=Inter+Tight:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet"
    />

    <!-- CSS here -->
    <link rel="stylesheet" href="assets/css/01-bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/02-all.min.css" />
    <link rel="stylesheet" href="assets/css/03-jquery.magnific-popup.css" />
    <link rel="stylesheet" href="assets/css/04-nice-select.css" />
    <link rel="stylesheet" href="assets/css/05-odometer.css" />
    <link rel="stylesheet" href="assets/css/06-swiper.min.css" />
    <link rel="stylesheet" href="assets/css/07-animate.min.css" />
    <link rel="stylesheet" href="assets/css/08-custom-animate.css" />
    <link rel="stylesheet" href="assets/css/09-slick.css" />
    <link rel="stylesheet" href="assets/css/10-icomoon.css">
    <link
      rel="stylesheet"
      href="assets/vendor/custom-animate/custom-animate.css"
    />
    <link rel="stylesheet" href="assets/vendor/jarallax/jarallax.css" />
    <link rel="stylesheet" href="assets/vendor/odometer/odometer.min.css" />
    <link rel="stylesheet" href="assets/fonts/gilroy/stylesheet.css" />

    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="stylesheet" href="assets/css/responsive.css" />
    <link rel="stylesheet" href="assets/css/customstyles.css"/>

    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    />
    <style>
      /* Enhanced Banner Styling */
      .banner-one {
        position: relative;
        overflow: hidden;
        margin-bottom: -20px; /* Reduce gap after banner */
      }
      
      .banner-one__inner {
        position: relative;
        z-index: 10;
      }
      
      .banner-one__content {
        position: relative;
      }
      
      .banner-one__content .big-title h2 {
        margin-bottom: 25px;
        text-shadow: 1px 1px 1px rgba(0,0,0,0.1);
      }
      
      .banner-one__content .text p {
        margin-bottom: 30px;
      }
      
      .banner-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-top: 30px;
      }
      
      .banner-buttons .thm-btn,
      .banner-buttons .thm-btn2 {
        position: relative;
        overflow: hidden;
      }
      
      .banner-buttons .thm-btn::before,
      .banner-buttons .thm-btn2::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: rgba(255,255,255,0.2);
        transform: skewX(-25deg);
        transition: all 0.5s;
      }
      
      .banner-buttons .thm-btn:hover::before,
      .banner-buttons .thm-btn2:hover::before {
        left: 100%;
      }
      
      .benefits-list {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 15px;
      }
      
      .benefits-list span {
        background: rgba(0,98,204,0.1);
        border-radius: 30px;
        padding: 8px 15px;
        font-size: 14px;
        color: #0062cc;
        font-weight: 500;
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
      }
      
      .benefits-list span:hover {
        background: rgba(0,98,204,0.2);
        transform: translateY(-3px);
      }
      
      .benefits-list span::before {
        margin-right: 8px;
        color: #0062cc;
        font-size: 12px;
      }
      
      /* Schedule Section Enhancements */
      .service-three__single {
        overflow: hidden;
        border-radius: 15px;
        position: relative;
        transition: all 0.5s ease;
      }
      
      .service-three__single::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(to right, #0062cc, #0097e6);
        transform: scaleX(0);
        transition: transform 0.5s ease;
        transform-origin: left;
      }
      
      .service-three__single:hover::before {
        transform: scaleX(1);
      }
      
      .service-three__single:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
      }
      
      .service-three__single-content .title h3 {
        font-size: 22px;
        margin-bottom: 15px;
        transition: all 0.3s ease;
      }
      
      .service-three__single-content .title h3 a:hover {
        color: #0062cc;
      }
      
      /* Faculty & Program Section */
      .faculty-section {
        padding: 60px 0; /* Reduced from 80px */
        background-color: #f8f9fa;
        position: relative;
        overflow: hidden;
      }
      
      .faculty-section::before {
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(0,98,204,0.05), rgba(0,151,230,0.08));
        top: -50px;
        left: -100px;
        z-index: 0;
      }
      
      .faculty-section::after {
        content: '';
        position: absolute;
        width: 250px;
        height: 250px;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(0,98,204,0.05), rgba(0,151,230,0.08));
        bottom: -50px;
        right: -50px;
        z-index: 0;
      }
      
      .faculty-tabs {
        position: relative;
        z-index: 1;
        border-radius: 15px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        margin-top: 30px;
        padding: 30px;
      }
      
      .faculty-tabs .nav-pills .nav-link {
        font-weight: 600;
        padding: 12px 25px;
        border-radius: 8px;
        color: #505050;
        transition: all 0.3s ease;
      }
      
      .faculty-tabs .nav-pills .nav-link.active {
        background: linear-gradient(135deg, #0062cc, #0097e6);
        color: #fff;
        box-shadow: 0 5px 15px rgba(0, 98, 204, 0.2);
      }
      
      .faculty-tabs .tab-content {
        margin-top: 30px;
        padding: 20px;
      }
      
      .faculty-tabs h4 {
        font-size: 20px;
        margin-bottom: 20px;
        color: #333;
        position: relative;
        padding-left: 20px;
      }
      
      .faculty-tabs h4::before {
        content: '';
        position: absolute;
        left: 0;
        top: 8px;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #0062cc;
      }
      
      .faculty-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 10px;
      }
      
      .faculty-list li {
        position: relative;
        padding-left: 20px;
        margin-bottom: 12px;
        transition: all 0.3s ease;
      }
      
      .faculty-list li::before {
        content: "\f054";
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        position: absolute;
        left: 0;
        top: 2px;
        font-size: 10px;
        color: #0062cc;
      }
      
      .faculty-list li:hover {
        transform: translateX(5px);
        color: #0062cc;
      }
      
      /* FAQ Section Enhancements */
      .faq-section {
        padding: 60px 0; /* Reduced from 80px */
        background-color: #fff;
        position: relative;
      }
      
      .faq-wrap {
        display: flex;
        flex-wrap: wrap;
        gap: 25px; /* Reduced from 30px */
        margin-top: 25px; /* Reduced from 40px */
      }
      
      .accordion-section {
        flex: 1;
        min-width: 300px;
      }
      
      .image-section {
        flex: 0 0 400px;
        display: flex;
        align-items: center;
        justify-content: center;
      }
      
      .fixed-size-image {
        max-width: 100%;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: all 0.5s ease;
      }
      
      .fixed-size-image:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
      }
      
      .accordion-item {
        border: none;
        background-color: #fff;
        margin-bottom: 15px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        transition: all 0.3s ease;
      }
      
      .accordion-item:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
      }
      
      .accordion-button {
        font-size: 17px;
        font-weight: 600;
        padding: 20px;
        background-color: #fff;
        color: #333;
        transition: all 0.3s ease;
      }
      
      .accordion-button:not(.collapsed) {
        background-color: #f0f7ff;
        color: #0062cc;
        box-shadow: none;
      }
      
      .accordion-button::after {
        background-size: 16px;
        transition: all 0.3s ease;
      }
      
      .accordion-body {
        padding: 20px;
        color: #505050;
        line-height: 1.7;
      }
      
      /* About Section Enhancements */
      .about-section {
        padding: 60px 0; /* Reduced from 80px */
        background-color: #f8f9fa;
        position: relative;
        overflow: hidden;
      }
      
      .about-title h2 {
        font-size: 32px;
        margin-bottom: 10px;
        position: relative;
        display: inline-block;
      }
      
      .about-title h2::after {
        content: '';
        position: absolute;
        left: 50%;
        bottom: -10px;
        width: 80px;
        height: 3px;
        background: linear-gradient(135deg, #0062cc, #0097e6);
        transform: translateX(-50%);
      }
      
      .s-about-img2 {
        position: relative;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
      }
      
      .s-about-img2 img {
        width: 100%;
        border-radius: 15px;
        transition: all 0.5s ease;
      }
      
      .s-about-img2:hover img {
        transform: scale(1.05);
      }
      
      .about-content p {
        margin-bottom: 20px;
        color: #505050;
        line-height: 1.8;
      }
      
      /* CTA Section Enhancement */
      .cta-one {
        position: relative;
        padding: 60px 0; /* Reduced from 80px */
        overflow: hidden;
      }
      
      .cta-one__inner {
        background: linear-gradient(135deg, #0062cc, #0097e6);
        border-radius: 20px;
        padding: 60px 40px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 50px rgba(0, 98, 204, 0.2);
      }
      
      .cta-one__inner::before {
        content: '';
        position: absolute;
        top: -50px;
        left: -50px;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
      }
      
      .cta-one__inner::after {
        content: '';
        position: absolute;
        bottom: -80px;
        right: -80px;
        width: 300px;
        height: 300px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.06);
      }
      
      .cta-one__inner-title-box h2 {
        font-size: 36px;
        color: #fff;
        margin-bottom: 20px;
      }
      
      .cta-one__inner-text-box p {
        color: rgba(255, 255, 255, 0.9);
        font-size: 18px;
        margin-bottom: 30px;
      }
      
      /* Enhanced Testimonials Section - 3.0 version */
      .testimonials-three {
        position: relative;
        padding: 60px 0 60px; /* Reduced padding */
        background-color: #f8f9fa;
        overflow: hidden;
      }
      
      .testimonials-three::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(0,98,204,0.05) 0%, rgba(0,151,230,0) 70%);
        border-radius: 50%;
      }
      
      .testimonials-three::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(0,98,204,0.05) 0%, rgba(0,151,230,0) 70%);
        border-radius: 50%;
      }
      
      .testimonials-carousel-wrapper {
        padding: 40px 0;
        position: relative;
      }
      
      /* Enhanced Circle Image Layout */
      .testimonial-image-circle {
        position: relative;
        height: 200px;  /* Reduced from 260px */
        margin-bottom: 15px; /* Reduced from 30px */
      }
      
      .circle-container {
        position: relative;
        width: 100%;
        height: 100%;
      }
      
      .circle-center {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 25px;  /* Slightly bigger center point */
        height: 25px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0062cc, #0097e6);
        z-index: 1;
        box-shadow: 0 0 20px rgba(0, 98, 204, 0.3);
      }
      
      .pulse {
        position: absolute;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background-color: rgba(0, 98, 204, 0.3);
        animation: pulse-animation 2s infinite;
      }
      
      @keyframes pulse-animation {
        0% {
          transform: scale(1);
          opacity: 1;
        }
        100% {
          transform: scale(3);
          opacity: 0;
        }
      }
      
      /* Bigger circle items */
      .circle-item {
        position: absolute;
        width: 100px;  /* Increased from 80px */
        height: 100px;  /* Increased from 80px */
        transition: all 0.5s ease;
        opacity: 0.7;
        transform: scale(0.85);
        z-index: 2;
      }
      
      /* Adjusted positions for better spacing */
      .circle-item:nth-child(1) {
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) translate(0px, -90px) scale(0.85);  /* Reduced vertical distance */
      }
      
      .circle-item:nth-child(2) {
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) translate(90px, 45px) scale(0.85);  /* Adjusted position */
      }
      
      .circle-item:nth-child(3) {
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) translate(-90px, 45px) scale(0.85);  /* Adjusted position */
      }
      
      .circle-item.active {
        opacity: 1;
        transform: scale(1.1);  /* Bigger scale for active items */
        z-index: 3;  /* Higher z-index for active */
      }
      
      .circle-item:nth-child(1).active {
        transform: translate(-50%, -50%) translate(0px, -90px) scale(1.1);
      }
      
      .circle-item:nth-child(2).active {
        transform: translate(-50%, -50%) translate(90px, 45px) scale(1.1);
      }
      
      .circle-item:nth-child(3).active {
        transform: translate(-50%, -50%) translate(-90px, 45px) scale(1.1);
      }
      
      /* Dynamic positioning for when more testimonials are added */
      .circle-item:nth-child(4) {
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) translate(0px, 90px) scale(0.85);
      }
      
      .circle-item:nth-child(5) {
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) translate(-90px, -45px) scale(0.85);
      }
      
      .circle-item:nth-child(6) {
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) translate(90px, -45px) scale(0.85);
      }
      
      .circle-item:nth-child(4).active {
        transform: translate(-50%, -50%) translate(0px, 90px) scale(1.1);
      }
      
      .circle-item:nth-child(5).active {
        transform: translate(-50%, -50%) translate(-90px, -45px) scale(1.1);
      }
      
      .circle-item:nth-child(6).active {
        transform: translate(-50%, -50%) translate(90px, -45px) scale(1.1);
      }
      
      .circle-img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        overflow: hidden;
        border: 4px solid #fff;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        transition: all 0.3s ease;
      }
      
      .circle-img:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        border: 4px solid rgba(0, 98, 204, 0.3);
      }
      
      .circle-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
      }
      
      /* Enhanced Testimonial Card - more compact */
      .testimonial-card {
        background: #fff;
        padding: 25px; /* Reduced from 35px */
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        position: relative;
        transition: all 0.3s ease;
        margin-bottom: 15px; /* Reduced from 30px */
      }
      
      .testimonial-card::after {
        content: '';
        position: absolute;
        bottom: -15px;
        left: 50%;
        transform: translateX(-50%);
        width: 30px;
        height: 15px;
        background-color: #fff;
        clip-path: polygon(0 0, 100% 0, 50% 100%);
        box-shadow: 0 6px 10px -8px rgba(0, 0, 0, 0.1);
      }
      
      .testimonial-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
      }
      
      .testimonial-rating {
        margin-bottom: 20px;
        display: flex;
        align-items: center;
      }
      
      .testimonial-rating i {
        color: #FFC107;
        margin-right: 3px;
        font-size: 18px;
      }
      
      .testimonial-text {
        margin-bottom: 15px; /* Reduced from 25px */
      }
      
      .testimonial-text p {
        font-size: 16px;
        line-height: 1.8;
        color: #505050;
        font-style: italic;
        position: relative;
        padding-left: 25px;
      }
      
      .testimonial-text p::before {
        content: '"';
        position: absolute;
        left: 0;
        top: 0;
        font-size: 40px;
        line-height: 1;
        color: rgba(0, 98, 204, 0.2);
        font-family: Georgia, serif;
      }
      
      .testimonial-author {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 20px;
        border-top: 1px solid #f0f0f0;
      }
      
      .author-info h4 {
        font-size: 18px;
        margin-bottom: 5px;
        color: #0062cc;
        font-weight: 600;
      }
      
      .author-info p {
        font-size: 14px;
        color: #6c757d;
        margin: 0;
      }
      
      .quote-icon {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #0062cc, #0097e6);
        border-radius: 50%;
        box-shadow: 0 5px 15px rgba(0, 98, 204, 0.2);
      }
      
      .quote-icon i {
        color: #fff;
        font-size: 20px;
      }
      
      /* Navigation Controls - moved up */
      .testimonial-navigation {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 15px; /* Reduced from 40px */
      }
      
      .testimonial-prev, 
      .testimonial-next {
        width: 50px;
        height: 50px;
        background: #fff;
        border-radius: 50%;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        z-index: 5;
      }
      
      .testimonial-prev:hover, 
      .testimonial-next:hover {
        background: linear-gradient(135deg, #0062cc, #0097e6);
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 98, 204, 0.2);
      }
      
      .testimonial-prev:hover i, 
      .testimonial-next:hover i {
        color: #fff;
      }
      
      .testimonial-prev i, 
      .testimonial-next i {
        color: #0062cc;
        font-size: 20px;
        transition: all 0.3s ease;
      }
      
      .testimonial-pagination {
        margin: 0 25px;
        z-index: 5;
      }
      
      .testimonial-pagination .swiper-pagination-bullet {
        width: 12px;
        height: 12px;
        background: #ccc;
        opacity: 1;
        margin: 0 5px;
        transition: all 0.3s ease;
      }
      
      .testimonial-pagination .swiper-pagination-bullet-active {
        background: #0062cc;
        width: 30px;
        border-radius: 6px;
      }
      
      /* Responsive Styles */
      @media (max-width: 1199px) {
        .faq-wrap {
          flex-direction: column;
        }
        
        .image-section {
          flex: 0 0 100%;
          max-width: 500px;
          margin: 0 auto;
        }
        
        .fixed-size-image {
          width: 100%;
        }
      }
      
      @media (max-width: 991px) {
        .testimonial-image-circle {
          height: 180px;  /* Reduced from 220px */
        }
        
        .circle-item {
          width: 85px;
          height: 85px;
        }
        
        .testimonial-card {
          padding: 20px; /* Reduced from 30px */
        }
        
        .faculty-list {
          grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        }

        .testimonials-three,
        .faculty-section,
        .faq-section,
        .about-section,
        .cta-one {
          padding: 50px 0;
        }
      }
      
      @media (max-width: 767px) {
        .testimonial-image-circle {
          height: 160px;  /* Reduced from 200px */
        }
        
        .circle-item {
          width: 75px;
          height: 75px;
        }
        
        .testimonial-text p {
          font-size: 15px;
        }
        
        .author-info h4 {
          font-size: 16px;
        }
        
        .author-info p {
          font-size: 13px;
        }
        
        .cta-one__inner {
          padding: 40px 20px;
        }
        
        .cta-one__inner-title-box h2 {
          font-size: 28px;
        }
        
        .faculty-list {
          grid-template-columns: 1fr;
        }

        .testimonials-three,
        .faculty-section,
        .faq-section,
        .about-section,
        .cta-one {
          padding: 40px 0;
        }
      }
      
      @media (max-width: 575px) {
        .testimonial-image-circle {
          height: 150px; /* Reduced from 180px */
        }
        
        .circle-item {
          width: 60px; /* Reduced from 65px */
          height: 60px; /* Reduced from 65px */
        }
        
        .testimonial-prev, 
        .testimonial-next {
          width: 40px;
          height: 40px;
        }
        
        .testimonial-prev i, 
        .testimonial-next i {
          font-size: 16px;
        }
      }
    </style>
  </head>

  <body class="body-gray-bg">
    <!--Start Preloader -->
    <div id="preloader" class="alt">
      <div id="loading-center">
        <div class="loader">
          <div class="loader-outter"></div>
          <div class="loader-inner"></div>
        </div>
      </div>
    </div>
    <!--End Preloader-->

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
                        <a href="mailto:info@uttoraja.com"
                          >info@uttoraja.com</a
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
                    <a href="./">
                      <img src="serve-image.php?img=assets/img/resource/logo.png" alt="Logo" />
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
                              <a href="#">Akademik</a>
                              <ul class="sub-menu">
                                <li><a href="./informasi">Informasi Akademik</a></li>
                                <li><a href="./kalender">Kalender Akademik</a></li>
                                <li><a href="./jurusan.php">Program Studi</a></li>
                                <li><a href="./biaya.php">Biaya Kuliah</a></li>
                              </ul>
                            </li>
                            <li class="menu-item-has-children">
                              <a href="#">Program</a>
                              <ul class="sub-menu">
                                <li><a href="./rpl.php">Rekognisi Pembelajaran Lampau (RPL)</a></li>
                                <li><a href="./reguler.php">Program Reguler</a></li>
                                <li><a href="./pasca.php">Program Pascasarjana</a></li>
                              </ul>
                            </li>
                            <li class="menu-item-has-children">
                              <a href="#">Layanan</a>
                              <ul class="sub-menu">
                                <li><a href="./administrasi/">Administrasi Akademik</a></li>
                                <li><a href="./kegiatan">Kegiatan Akademik</a></li>
                                <li><a href="./modul/">Pengambilan Modul</a></li>
                                <li><a href="./legalisir/">Legalisir Ijazah</a></li>
                                <li><a href="./suratketerangan/">Surat Keterangan</a></li>
                              </ul>
                            </li>
                            <li class="menu-item-has-children">
                              <a href="#">Tentang</a>
                              <ul class="sub-menu">
                                <li><a href="./tentang/">Universitas Terbuka</a></li>
                                <li><a href="./tentang/salut/">SALUT</a></li>
                                <li><a href="./tentang/saluttator">SALUT Tana Toraja</a></li>
                                <li><a href="./tentang/kepalasalut">Pesan Kepala SALUT</a></li>
                              </ul>
                            </li>
                            <li><a href="./galeri/">Galeri</a></li>
                            <li><a href="./kontak">Kontak</a></li>
                          </ul>
                        </div>
                      </nav>
                    </div>
                  </div>
                </div>

                <div class="main-header-one__bottom-right">
                  <div class="header-btn-box-one">
                    <a class="thm-btn" href="./pendaftaran/">
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
              <a href="./">
                <img
                  src="serve-image.php?img=assets/img/resource/mobile-menu-logo.png"
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

      <!--Start Banner One-->
      <section class="banner-one">
        <div class="banner-one__shape1 float-bob-x">
          <img src="serve-image.php?img=assets/img/shape/banner-one__shape1.png" alt="#" />
        </div>
        <div class="banner-one__shape2 rotate-me">
          <img src="assets/img/shape/banner-one__shape2.png" alt="#" />
        </div>
        <div class="banner-one__shape3 float-bob-y">
          <img src="assets/img/shape/banner-one__shape3.png" alt="#" />
        </div>
        <div class="container">
          <div class="banner-one__inner">
            <div
              class="banner-one__content wow fadeInLeft"
              data-wow-delay="0ms"
              data-wow-duration="1500ms"
            >
              <div class="big-title">
                <h2>
                  <span class="warnabiru">Kuliah Online</span><br/>
                  di PTN <span class="warnakuning">Online</span><br/><span
                    class="warnakuning"
                    >Terbaik</span
                  >
                  Indonesia
                </h2>
              </div>
              <div class="text">
                <p>
                    UT, perguruan tinggi negeri online dengan akreditasi "A" yang keren! 😊<br />
                    Kuliah bisa kapan aja & di mana aja, terbuka untuk semua usia, <br />
                    tanpa ribet ujian masuk, dan biayanya super terjangkau! 🎓✨<br />
                    Yuk, daftar sekarang dan wujudkan impian pendidikanmu! 🚀
                </p>
              </div>
              <div class="benefits-list">
                <span class="icon-check">Berkualitas</span>
                <span class="icon-check">Kampus Negeri</span>
                <span class="icon-check">Fleksibel</span>
                <span class="icon-check">Terjangkau</span>
              </div>
              <div class="banner-buttons">
                <a class="thm-btn" href="./pendaftaran/">
                  <span class="txt">
                    Pendaftaran
                    <i class="icon-next"></i>
                  </span>
                </a>
                <a class="thm-btn2" href="https://wa.me/6282293924242">
                  <i class="bi bi-whatsapp"></i>
                  <span class="txt"> Konsultasi Pendaftaran</span>
                </a>
              </div>
            </div>

            <div
              class="banner-one__img wow fadeInRight"
              data-wow-delay="0ms"
              data-wow-duration="1500ms"
            >
              <div class="inner">
                <img src="serve-image.php?img=assets/img/slider/banner.png" alt="banner" />
              </div>
              <div class="banner-one__img-bg"></div>
            </div>
          </div>
        </div>
      </section>
      <!--End Banner One-->

      <!-- Start Schedule One -->
      <section class="service-three service">
        <div class="service-three__shape1 float-bob-x">
          <img src="serve-image.php?img=assets/img/shape/service-three__shape4.png" alt="shapes" />
        </div>
        <div class="service-three__shape2">
          <img src="assets/img/shape/service-three__shape2.png" alt="shapes" />
        </div>
        <div class="service-three__shape3 float-bob-y">
          <img src="assets/img/shape/service-three__shape5.png" alt="shapes" />
        </div>
        <div class="container">
          <div class="sec-title-three text-center">
            <div class="sub-title">
              <h4>Jadwal Pendaftaran</h4>
            </div>
            <h2>Jangan Melewatkan Kesempatan!</h2>
          </div>
          <div class="row">
            <!--Start Single Service Three-->
            <div
              class="col-xl-4 col-lg-4 col-md-6 wow fadeInLeft"
              data-wow-delay="0ms"
              data-wow-duration="1500ms"
            >
              <div class="service-three__single">
                <div class="service-three__single-content">
                  <div class="title">
                    <h3>
                      <a href="./pendaftaran/">Transfer Nilai/RPL</a>
                    </h3>
                  </div>
                  <div class="text">
                    <p>Pendaftaran</p>
                    <p>18 November 2024 – 22 Januari 2025</p>
                  </div>
                </div>
              </div>
            </div>
            <!--End Single Service Three-->

            <!--Start Single Service Three-->
            <div
              class="col-xl-4 col-lg-4 col-md-6 wow fadeInLeft"
              data-wow-delay="100ms"
              data-wow-duration="1500ms"
            >
              <div class="service-three__single">
                <div class="service-three__single-content">
                  <div class="title">
                    <h3>
                      <a href="./pendaftaran/">Mahasiswa Reguler</a>
                    </h3>
                  </div>
                  <div class="text">
                    <p>Pendaftaran</p>
                    <p>17 Oktober 2024 – 12 Februari 2025</p>
                  </div>
                </div>
              </div>
            </div>
            <!--End Single Service Three-->

            <!--Start Single Service Three-->
            <div
              class="col-xl-4 col-lg-4 col-md-6 wow fadeInLeft"
              data-wow-delay="200ms"
              data-wow-duration="1500ms"
            >
              <div class="service-three__single">
                <div class="service-three__single-content">
                  <div class="title">
                    <h3><a href="#">Magister (S2)</a></h3>
                  </div>
                  <div class="text">
                    <p>Pendaftaran</p>
                    <p>-</p>
                  </div>
                </div>
              </div>
            </div>
            <!--End Single Service Three-->
          </div>

          <div class="tomboljadwal">
            <a class="thm-btn" href="./pendaftaran">
              <span class="txt">
                Pendaftaran
                <i class="icon-next"></i>
              </span>
            </a>
            <a class="thm-btn2" href="https://wa.me/6282293924242">
              <i class="bi bi-whatsapp"></i>
              <span class="txt"> Konsultasi </span>
            </a>
          </div>
        </div>
      </section>
      <!-- End Schedule One -->

      <!--Start Testimonials Three-->
      <section class="testimonials-three testimonials">
        <div class="testimonials-three__shape1 rotate-me">
          <img src="assets/img/shape/testimonials-three__shape1.png" alt="shapes">
        </div>
        <div class="testimonials-three__shape2 rotate-me">
          <img src="assets/img/shape/testimonials-three__shape2.png" alt="shapes">
        </div>
        <div class="testimonials-three__shape3 rotate-me">
          <img src="assets/img/shape/testimonials-three__shape3.png" alt="shapes">
        </div>
        <div class="container">
          <!-- Section Title -->
          <div class="sec-title-three text-center mb-5">
            <div class="sub-title">
              <h4>Testimoni Mahasiswa</h4>
            </div>
            <h2>Kisah Sukses Mahasiswa UT</h2>
            <p class="mt-3">Pengalaman nyata dari mahasiswa yang telah merasakan belajar di Universitas Terbuka</p>
          </div>
          
          <!-- Enhanced Testimonial Section -->
          <div class="row justify-content-center">
            <div class="col-lg-10">
              <div class="testimonials-carousel-wrapper position-relative">
                <!-- Testimonial Images Circle -->
                <div class="testimonial-image-circle wow fadeIn" data-wow-delay="0.2s">
                  <div class="circle-container">
                    <div class="circle-item active" data-index="0">
                      <div class="circle-img">
                        <img src="serve-image.php?img=assets/img/testimonial/monika.jpg" alt="Monica Sarina Rianti Baan">
                      </div>
                    </div>
                    <div class="circle-item" data-index="1">
                      <div class="circle-img">
                        <img src="serve-image.php?img=assets/img/testimonial/neny.jpg" alt="Neny Lasri Mallisa">
                      </div>
                    </div>
                    <div class="circle-item" data-index="2">
                      <div class="circle-img">
                        <img src="serve-image.php?img=assets/img/testimonial/notavian.jpg" alt="Notavian Masuang">
                      </div>
                    </div>
                    <!-- Placeholder slots for future testimonials -->
                    <div class="circle-center">
                      <div class="pulse"></div>
                    </div>
                  </div>
                </div>

                <!-- Testimonial Carousel -->
                <div class="testimonials-carousel wow fadeInUp" data-wow-delay="0.4s">
                  <div class="swiper-container testimonial-swiper">
                    <div class="swiper-wrapper">
                      <!-- Testimonial 1 -->
                      <div class="swiper-slide">
                        <div class="testimonial-card">
                          <div class="testimonial-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                          </div>
                          <div class="testimonial-text">
                            <p>"Belajar di Universitas Terbuka itu pas banget buat saya yang kerja sambil kuliah. Jadwalnya fleksibel dan materi pembelajarannya juga gampang diikuti, jadi bisa tetap fokus di dua-duanya tanpa stres."</p>
                          </div>
                          <div class="testimonial-author">
                            <div class="author-info">
                              <h4>Monica Sarina Rianti Baan</h4>
                              <p>Pendidikan Guru Sekolah Dasar</p>
                            </div>
                            <div class="quote-icon">
                              <i class="icon-quote"></i>
                            </div>
                          </div>
                        </div>
                      </div>
                      
                      <!-- Testimonial 2 -->
                      <div class="swiper-slide">
                        <div class="testimonial-card">
                          <div class="testimonial-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                          </div>
                          <div class="testimonial-text">
                            <p>"Saya sangat bersyukur telah memilih Universitas Terbuka sebagai tempat untuk melanjutkan pendidikan tinggi. UT memberikan fleksibilitas dalam hal waktu dan tempat untuk belajar, yang sangat membantu saya dalam menyeimbangkan antara study dan aktivitas sehari-hari."</p>
                          </div>
                          <div class="testimonial-author">
                            <div class="author-info">
                              <h4>Neny Lasri Mallisa'</h4>
                              <p>Ilmu Administrasi Bisnis</p>
                            </div>
                            <div class="quote-icon">
                              <i class="icon-quote"></i>
                            </div>
                          </div>
                        </div>
                      </div>
                      
                      <!-- Testimonial 3 -->
                      <div class="swiper-slide">
                        <div class="testimonial-card">
                          <div class="testimonial-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                          </div>
                          <div class="testimonial-text">
                            <p>"Belajar di Universitas Terbuka memberikan fleksibilitas yang saya butuhkan untuk tetap aktif dalam kegiatan sehari-hari sambil mengejar pendidikan. Dukungan dari dosen dan kualitas materi benar-benar membantu saya memahami pelajaran dengan baik."</p>
                          </div>
                          <div class="testimonial-author">
                            <div class="author-info">
                              <h4>Notavian Masuang</h4>
                              <p>Pendidikan Guru Sekolah Dasar</p>
                            </div>
                            <div class="quote-icon">
                              <i class="icon-quote"></i>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Navigation Controls -->
                <div class="testimonial-navigation">
                  <div class="swiper-button-prev testimonial-prev">
                    <i class="icon-left-arrow"></i>
                  </div>
                  <div class="swiper-pagination testimonial-pagination"></div>
                  <div class="swiper-button-next testimonial-next">
                    <i class="icon-right-arrow-angle"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!--End Testimonials Three-->

      <!-- Start Fakultas One -->
      <section class="faculty-section jarakcontainer">
        <div class="container">
          <div class="sec-title-three text-center">
            <div class="sub-title">
              <h4>Fakultas dan Jurusan</h4>
            </div>
            <h2>Kenali dan Pilih Jurusanmu!</h2>
          </div>
          <div class="faculty-tabs">
            <ul class="nav nav-pills nav-justified mb-4" id="pills-tab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-fkip-tab" data-bs-toggle="pill" 
                  data-bs-target="#pills-fkip" type="button" role="tab" 
                  aria-controls="pills-fkip" aria-selected="true">FKIP</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-fhisip-tab" data-bs-toggle="pill" 
                  data-bs-target="#pills-fhisip" type="button" role="tab" 
                  aria-controls="pills-fhisip" aria-selected="false">FHISIP</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-fst-tab" data-bs-toggle="pill" 
                  data-bs-target="#pills-fst" type="button" role="tab" 
                  aria-controls="pills-fst" aria-selected="false">FST</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-feb-tab" data-bs-toggle="pill" 
                  data-bs-target="#pills-feb" type="button" role="tab" 
                  aria-controls="pills-feb" aria-selected="false">FEB</button>
              </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
              <!-- FKIP Tab -->
              <div class="tab-pane fade show active" id="pills-fkip" role="tabpanel" aria-labelledby="pills-fkip-tab">
                <h4>Fakultas Keguruan dan Ilmu Pengetahuan</h4>
                <div class="faculty-content">
                  <p><strong>Daftar Jurusan:</strong></p>
                  <ul class="faculty-list">
                    <li>Pendidikan Bahasa dan Sastra Indonesia (S1)</li>
                    <li>Pendidikan Bahasa Inggris (S1)</li>
                    <li>Pendidikan Biologi (S1)</li>
                    <li>Pendidikan Fisika (S1)</li>
                    <li>Pendidikan Kimia (S1)</li>
                    <li>Pendidikan Matematika (S1)</li>
                    <li>Pendidikan Ekonomi (S1)</li>
                    <li>Pendidikan Pancasila dan Kewarganegaraan (S1)</li>
                    <li>Teknologi Pendidikan (S1)</li>
                    <li>Pendidikan Guru Sekolah Dasar (PGSD) (S1)</li>
                    <li>Pendidikan Guru Pendidikan Anak Usia Dini (PGPAUD) (S1)</li>
                  </ul>
                </div>
              </div>
              
              <!-- FHISIP Tab -->
              <div class="tab-pane fade" id="pills-fhisip" role="tabpanel" aria-labelledby="pills-fhisip-tab">
                <h4>Fakultas Hukum, Ilmu Sosial, dan Ilmu Politik</h4>
                <div class="faculty-content">
                  <p><strong>Daftar Jurusan:</strong></p>
                  <ul class="faculty-list">
                    <li>Ilmu Administrasi Negara (S1)</li>
                    <li>Ilmu Administrasi Bisnis (S1)</li>
                    <li>Ilmu Pemerintahan (S1)</li>
                    <li>Ilmu Hukum (S1)</li>
                    <li>Ilmu Komunikasi (S1)</li>
                    <li>Sosiologi (S1)</li>
                    <li>Sastra Inggris Bidang Minat Penerjemahan (S1)</li>
                    <li>Ilmu Perpustakaan (S1)</li>
                    <li>Administrasi Publik (D-IV)</li>
                    <li>Kearsipan (D-IV)</li>
                    <li>Perpajakan (D-III)</li>
                    <li>Perpustakaan (D-II)</li>
                  </ul>
                </div>
              </div>
              
              <!-- FST Tab -->
              <div class="tab-pane fade" id="pills-fst" role="tabpanel" aria-labelledby="pills-fst-tab">
                <h4>Fakultas Sains dan Teknologi</h4>
                <div class="faculty-content">
                  <p><strong>Daftar Jurusan:</strong></p>
                  <ul class="faculty-list">
                    <li>Statistika (S1)</li>
                    <li>Matematika (S1)</li>
                    <li>Biologi (S1)</li>
                    <li>Teknologi Pangan (S1)</li>
                    <li>Perencanaan Wilayah dan Kota (S1)</li>
                    <li>Sistem Informasi (S1)</li>
                    <li>Informatika (S1)</li>
                    <li>Agribisnis (S1)</li>
                    <li>Perencanaan Wilayah dan Kota (S1)</li>
                    <li>Teknik Industri (S1)</li>
                    <li>Teknik Elektro (S1)</li>
                    <li>Teknik Mesin (S1)</li>
                  </ul>
                </div>
              </div>
              
              <!-- FEB Tab -->
              <div class="tab-pane fade" id="pills-feb" role="tabpanel" aria-labelledby="pills-feb-tab">
                <h4>Fakultas Ekonomi dan Bisnis</h4>
                <div class="faculty-content">
                  <p><strong>Daftar Jurusan:</strong></p>
                  <ul class="faculty-list">
                    <li>Ekonomi Pembangunan (S1)</li>
                    <li>Ekonomi Syariah (S1)</li>
                    <li>Manajemen (S1)</li>
                    <li>Akuntansi (S1)</li>
                    <li>Akuntansi Keuangan Publik (S1)</li>
                    <li>Pariwisata (S1)</li>
                    <li>Manajemen Keuangan Sektor Publik (S1)</li>
                    <li>Manajemen (D-IV)</li>
                    <li>Akuntansi Keuangan Publik (D-IV)</li>
                    <li>Keuangan (D-III)</li>
                    <li>Manajemen (D-II)</li>
                  </ul>
                </div>
              </div>
            </div>

            <!-- View All Programs Button -->
            <div class="text-center mt-4">
              <a href="./jurusan.php" class="thm-btn">
                <span class="txt">Lihat Semua Program Studi <i class="bi bi-arrow-right"></i></span>
              </a>
            </div>
          </div>
        </div>
      </section>

      <!-- Start FAQ Section -->
      <section class="faq-section jarakcontainer">
        <div class="container">
          <div class="sec-title-three text-center mb-4">
            <div class="sub-title">
              <h4>FAQ</h4>
            </div>
            <h2>Frequently Asked Questions</h2>
          </div>
          <div class="faq-wrap">
            <div class="accordion-section">
              <div class="accordion" id="accordionExample">
                <!-- FAQ Item 1 -->
                <div class="accordion-item wow fadeInLeft" data-wow-delay="0.1s">
                  <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                      data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      <i class="bi bi-question-circle me-2"></i> Bagaimana cara mendaftar di Universitas Terbuka?
                    </button>
                  </h2>
                  <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                      Pendaftaran di UT dapat dilakukan melalui website resmi UT di <a href="https://www.ut.ac.id/pendaftaran-online">www.ut.ac.id/pendaftaran-online</a> atau melalui SALUT Tana Toraja. Anda perlu menyiapkan dokumen seperti ijazah terakhir, KTP, foto, dan membayar biaya pendaftaran. Kami di SALUT Tana Toraja siap membantu proses pendaftaran Anda dari awal hingga selesai.
                    </div>
                  </div>
                </div>
                
                <!-- FAQ Item 2 -->
                <div class="accordion-item wow fadeInLeft" data-wow-delay="0.2s">
                  <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                      data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                      <i class="bi bi-question-circle me-2"></i> Apakah ijazah UT diakui secara resmi?
                    </button>
                  </h2>
                  <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                      Ya, Universitas Terbuka (UT) adalah Perguruan Tinggi Negeri yang memiliki akreditasi "A" (Unggul) dari BAN-PT. Semua ijazah dan gelar yang diberikan oleh UT diakui secara resmi dan setara dengan universitas negeri konvensional lainnya di Indonesia, serta dapat digunakan untuk melamar pekerjaan atau melanjutkan pendidikan ke jenjang yang lebih tinggi.
                    </div>
                  </div>
                </div>
                
                <!-- FAQ Item 3 -->
                <div class="accordion-item wow fadeInLeft" data-wow-delay="0.3s">
                  <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                      data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                      <i class="bi bi-question-circle me-2"></i> Bagaimana sistem belajar di Universitas Terbuka?
                    </button>
                  </h2>
                  <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                      UT menerapkan sistem belajar jarak jauh dan terbuka. Mahasiswa dapat belajar secara mandiri menggunakan berbagai sumber belajar seperti modul cetak, modul digital, dan tutorial online. Selain itu, tersedia juga layanan tutorial tatap muka atas permintaan mahasiswa di lokasi-lokasi tertentu. Sistem ini memungkinkan mahasiswa untuk belajar kapan saja dan di mana saja sesuai dengan ketersediaan waktu dan tempat mereka.
                    </div>
                  </div>
                </div>
                
                <!-- FAQ Item 4 -->
                <div class="accordion-item wow fadeInLeft" data-wow-delay="0.4s">
                  <h2 class="accordion-header" id="headingFour">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                      data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                      <i class="bi bi-question-circle me-2"></i> Berapa biaya kuliah di Universitas Terbuka?
                    </button>
                  </h2>
                  <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                      Biaya kuliah di UT relatif terjangkau dibandingkan universitas konvensional. Biaya terdiri dari biaya registrasi pertama (sekitar Rp150.000) dan biaya per SKS yang bervariasi tergantung fakultas dan program studi (berkisar Rp50.000-Rp100.000 per SKS). Untuk informasi biaya lengkap dan terkini, silakan kunjungi <a href="./biaya.php">halaman biaya kuliah</a> atau konsultasikan langsung dengan staf SALUT Tana Toraja.
                    </div>
                  </div>
                </div>
                
                <!-- FAQ Item 5 -->
                <div class="accordion-item wow fadeInLeft" data-wow-delay="0.5s">
                  <h2 class="accordion-header" id="headingFive">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                      data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                      <i class="bi bi-question-circle me-2"></i> Apakah ada batasan usia untuk kuliah di UT?
                    </button>
                  </h2>
                  <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                      Tidak ada batasan usia untuk kuliah di Universitas Terbuka. Siapa pun yang telah lulus dari SMA/SMK/sederajat dapat mendaftar sebagai mahasiswa UT tanpa memandang usia. Hal ini sesuai dengan prinsip pembelajaran sepanjang hayat (lifelong learning) yang dianut oleh UT. Banyak mahasiswa UT yang berusia 30, 40, bahkan 50 tahun yang berhasil menyelesaikan pendidikan mereka.
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="image-section wow fadeInRight" data-wow-delay="0.5s">
              <img src="serve-image.php?img=assets/img/background/web2.png" alt="FAQ Image" class="fixed-size-image">
            </div>
          </div>
          
          <!-- View All FAQs Button -->
          <div class="text-center mt-4 wow fadeInUp" data-wow-delay="0.6s">
            <a href="./faq.php" class="thm-btn2">
              <span class="txt">Lihat Semua FAQ <i class="bi bi-arrow-right"></i></span>
            </a>
          </div>
        </div>
      </section>

      <!-- Start About Section -->
      <section class="about-section jarakcontainer">
        <div class="container">
          <div class="row align-items-center">
            <div class="about-title text-center mb-4 wow fadeInUp" data-wow-delay="0.1s">
              <h2>Kami Membantu Mahasiswa UT</h2>
              <p class="mt-3">SALUT Tana Toraja menyediakan dukungan penuh untuk perkuliahan online Anda</p>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12">
              <div class="s-about-img2 p-relative wow fadeInLeft" 
                data-wow-delay="0.4s">
                <img src="serve-image.php?img=assets/img/background/web.JPG" alt="Foto kampus" />
                
                <!-- Floating Stats -->
                <div class="about-stat-card" style="position: absolute; top: -20px; right: -20px; background: white; padding: 15px; border-radius: 10px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                  <div class="stat-icon" style="color: #0062cc; font-size: 24px; margin-bottom: 5px;">
                    <i class="bi bi-mortarboard-fill"></i>
                  </div>
                  <h4 style="margin-bottom: 0; font-size: 18px;">97%</h4>
                  <p style="margin: 0; font-size: 12px;">Tingkat Kelulusan</p>
                </div>
                
                <div class="about-stat-card" style="position: absolute; bottom: -15px; left: -15px; background: white; padding: 15px; border-radius: 10px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                  <div class="stat-icon" style="color: #0062cc; font-size: 24px; margin-bottom: 5px;">
                    <i class="bi bi-people-fill"></i>
                  </div>
                  <h4 style="margin-bottom: 0; font-size: 18px;">750+</h4>
                  <p style="margin: 0; font-size: 12px;">Mahasiswa Aktif</p>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12">
              <div class="about-content s-about-content wow fadeInRight"
                data-wow-delay="0.4s">
                <p>
                  <strong>Sentra Layanan Universitas Terbuka (SALUT) Tana Toraja</strong> adalah unit layanan yang didirikan untuk membantu mahasiswa UT di wilayah Tana Toraja dan sekitarnya dalam menjalani pendidikan jarak jauh dengan lebih mudah dan efektif.
                </p>
                <p>
                  SALUT Tana Toraja menyediakan layanan komprehensif, mulai dari informasi akademik, bantuan pendaftaran, konsultasi perkuliahan, pengambilan modul, hingga pelaksanaan tutorial tatap muka. Kami berkomitmen untuk memastikan mahasiswa UT di wilayah Tana Toraja mendapatkan pengalaman belajar yang berkualitas dan dukungan yang mereka butuhkan untuk sukses dalam perkuliahan.
                </p>

                <!-- Service List -->
                <div class="about-service-list" style="margin-top: 20px;">
                  <div class="row">
                    <div class="col-6">
                      <div class="service-item d-flex align-items-center mb-3">
                        <div class="icon" style="color: #0062cc; margin-right: 10px;">
                          <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <div class="text">Informasi Akademik</div>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="service-item d-flex align-items-center mb-3">
                        <div class="icon" style="color: #0062cc; margin-right: 10px;">
                          <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <div class="text">Tutorial Tatap Muka</div>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="service-item d-flex align-items-center mb-3">
                        <div class="icon" style="color: #0062cc; margin-right: 10px;">
                          <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <div class="text">Bantuan Pendaftaran</div>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="service-item d-flex align-items-center mb-3">
                        <div class="icon" style="color: #0062cc; margin-right: 10px;">
                          <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <div class="text">Konsultasi Akademik</div>
                      </div>
                    </div>
                  </div>
                </div>

                <a href="./tentang/" class="thm-btn mt-4">
                  <span class="txt">Pelajari Lebih Lanjut <i class="bi bi-arrow-right"></i></span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </section>
      
      <!--Start CTA Section-->
      <section class="cta-one">
        <!-- Animated background elements -->
        <div class="floating-shape" style="top: 15%; left: 10%; width: 80px; height: 80px; animation-delay: 0.5s;">
          <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
            <path fill="rgba(255, 255, 255, 0.1)" d="M39.9,-65.7C53.5,-59.6,67.3,-52.5,76.5,-40.9C85.8,-29.2,90.5,-13,89.2,2.4C87.8,17.8,80.5,32.3,70.5,44.4C60.5,56.5,47.9,66,34,73.7C20.1,81.3,5,87.1,-9.9,86.8C-24.9,86.5,-39.8,80.2,-50.4,69.9C-61,59.7,-67.4,45.5,-72.3,31.3C-77.1,17.1,-80.5,2.9,-79.4,-10.6C-78.2,-24.1,-72.7,-37,-63.9,-47C-55.1,-57,-43,-64.2,-30.4,-71C-17.9,-77.9,-4.8,-84.4,6.7,-81.4C18.3,-78.3,26.3,-71.8,39.9,-65.7Z" transform="translate(100 100)" />
          </svg>
        </div>
        <div class="floating-shape" style="bottom: 10%; right: 15%; width: 120px; height: 120px; animation-delay: 2s;">
          <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
            <path fill="rgba(255, 255, 255, 0.08)" d="M47.7,-73.2C59.5,-62.3,65.1,-44.5,71.5,-27C77.9,-9.6,85.1,7.5,82.1,22.7C79.1,37.9,66,51.2,51.1,60.8C36.2,70.4,19.5,76.2,2.1,74.4C-15.3,72.5,-31.4,62.8,-44.3,51C-57.2,39.1,-66.9,24.9,-72.1,8.7C-77.2,-7.4,-77.9,-25.6,-70.4,-40.1C-62.8,-54.5,-47,-65.2,-31.5,-73.8C-15.9,-82.3,-0.7,-88.7,14,-85.3C28.8,-81.9,35.9,-84.1,47.7,-73.2Z" transform="translate(100 100)" />
          </svg>
        </div>
        
        <div class="cta-one__shape1 float-bob-y">
          <img src="assets/img/shape/cta-one__shape1.png" alt="#" />
        </div>
        <div class="cta-one__shape2 float-bob-y">
          <img src="assets/img/shape/cta-one__shape2.png" alt="#" />
        </div>
        <div class="cta-one__shape3 rotate-me">
          <img src="assets/img/shape/cta-one__shape3.png" alt="#" />
        </div>
        <div class="cta-one__shape4 float-bob-x">
          <img src="assets/img/shape/cta-one__shape4.png" alt="#" />
        </div>
        <div class="cta-one__shape5 float-bob-x">
          <img src="assets/img/shape/cta-one__shape5.png" alt="#" />
        </div>
        <div class="cta-one__shape6 float-bob-y">
          <img src="assets/img/shape/cta-one__shape6.png" alt="#" />
        </div>
        <div class="container">
          <div class="cta-one__inner text-center wow fadeInUp" data-wow-delay="0.1s">
            <div class="cta-one__inner-title-box">
              <h2>Siap Melangkah Menuju Masa Depan Yang Lebih Baik?</h2>
            </div>
            <div class="cta-one__inner-text-box">
              <p>
                Daftar sekarang dan mulai perjalanan pendidikan Anda bersama Universitas Terbuka<br>
                Konsultasikan kebutuhan pendidikan Anda dengan tim kami di SALUT Tana Toraja.
              </p>
            </div>
            <div class="cta-one__inner-btn-box">
              <div class="row justify-content-center">
                <div class="col-auto">
                  <a class="thm-btn" href="./pendaftaran/">
                    <span class="txt">Daftar Sekarang <i class="bi bi-arrow-right-circle"></i></span>
                  </a>
                </div>
                <div class="col-auto">
                  <a class="thm-btn" href="https://wa.me/6282293924242" style="background-color: #25D366; border-color: #25D366;">
                    <span class="txt"><i class="bi bi-whatsapp"></i> Hubungi Kami</span>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!--End CTA Section-->

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
                          <p><a href="./tentang/">Tentang UT</a></p>
                        </li>
                        <li>
                          <p><a href="./informasi.php">Informasi Akademik</a></p>
                        </li>
                        <li>
                          <p><a href="./administrasi/">Administrasi</a></p>
                        </li>
                        <li>
                          <p><a href="./tentang/kepalasalut.php">Sapaan dari Kepala SALUT</a></p>
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
                            <a href="./informasi.php">Informasi Akademik</a>
                          </p>
                        </li>
                        <li>
                          <p>
                            <a href="./administrasi/">Administrasi Akademik</a>
                          </p>
                        </li>
                        <li>
                          <p>
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
                            <a href="./informasi.php">Informasi Akademik</a>
                          </p>
                        </li>
                        <li>
                          <p>
                            <a href="./administrasi/">Administrasi Akademik</a>
                          </p>
                        </li>
                        <li>
                          <p>
                            <a href="./kegiatan.php">Kegiatan</a>
                          </p>
                        </li>
                        <li>
                          <p>
                            <a href="./modul/">Pengambilan Modul</a>
                          </p>
                        </li>
                        <li>
                          <p>
                            <a href="./suratketerangan/">Surat Keterangan</a>
                          </p>
                        </li>
                        <li>
                          <p>
                            <a href="./legalisir/">Legalisir Ijazah</a>
                          </p>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <!--End Single Footer Widget-->
                
                <!--Start Single Footer Widget-->
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

    <!-- JS here -->
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/01-ajax-form.js"></script>
    <!-- <script src="assets/js/02-bootstrap.min.js"></script> -->
    <script src="assets/js/03-jquery.appear.js"></script>
    <script src="assets/js/04-swiper.min.js"></script>
    <script src="assets/js/05-jquery.odometer.min.js"></script>
    <script src="assets/js/06-jquery.magnific-popup.min.js"></script>
    <script src="assets/js/07-jquery.nice-select.min.js"></script>
    <script src="assets/js/08-slick.min.js"></script>
    <script src="assets/js/09-wow.min.js"></script>
    <script src="assets/js/10-jquery.circleType.js"></script>
    <script src="assets/js/11-jquery.lettering.min.js"></script>
    <script src="assets/js/12-TweenMax.min.js"></script>
    <script src="assets/vendor/jarallax/jarallax.min.js"></script>
    <script src="assets/vendor/marquee/marquee.min.js"></script>
    <script src="assets/vendor/odometer/odometer.min.js"></script>
    <script src="assets/vendor/progress-bar/knob.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        // Initialize Testimonial Swiper
        var testimonialSwiper = new Swiper('.testimonial-swiper', {
          effect: 'fade',
          fadeEffect: {
            crossFade: true
          },
          autoplay: {
            delay: 5000,
            disableOnInteraction: false,
          },
          speed: 800,
          loop: true,
          pagination: {
            el: '.testimonial-pagination',
            clickable: true,
          },
          navigation: {
            nextEl: '.testimonial-next',
            prevEl: '.testimonial-prev',
          },
          on: {
            slideChange: function() {
              updateCircleImages(this.realIndex);
            },
          }
        });
        
        // Function to update circle images
        function updateCircleImages(index) {
          const circleItems = document.querySelectorAll('.circle-item');
          circleItems.forEach(item => {
            item.classList.remove('active');
            if (parseInt(item.getAttribute('data-index')) === index) {
              item.classList.add('active');
            }
          });
        }
        
        // Click event for circle images
        const circleItems = document.querySelectorAll('.circle-item');
        circleItems.forEach(item => {
          item.addEventListener('click', function() {
            const index = parseInt(this.getAttribute('data-index'));
            testimonialSwiper.slideTo(index + 1);
          });
        });
        
        // Additional initialization for other sections
        // Add hover effects to service cards
        const serviceCards = document.querySelectorAll('.service-three__single');
        serviceCards.forEach(card => {
          card.addEventListener('mouseenter', function() {
            serviceCards.forEach(c => c.style.opacity = 0.7);
            this.style.opacity = 1;
          });
          card.addEventListener('mouseleave', function() {
            serviceCards.forEach(c => c.style.opacity = 1);
          });
        });
        
        // Add animation to FAQ image
        const faqImage = document.querySelector('.fixed-size-image');
        if(faqImage) {
          faqImage.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px) scale(1.02)';
          });
          faqImage.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
          });
        }
      });
    </script>
  </body>
</html>
