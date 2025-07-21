<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Videograph Template">
    <meta name="keywords" content="Videograph, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Himatekom | Unand</title>
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Play:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="icon" href="{{ asset('img/logo.png') }}">
    <!-- Css Styles -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}" type="text/css">
    <!-- Font Awesome 6 for better social media icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/elegant-icons.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/slicknav.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" type="text/css">

    @stack('styles')
</head>
<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>
    @include('partials.navbar')
    @yield('content')
    <footer class="footer">
        <div class="container">
            <div class="footer__option">
                <div class="row">
                    <!-- Tentang Kami Section -->
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="footer__option__item">
                            <h5>Tentang Kami</h5>
                            <p>Himpunan Mahasiswa Teknik Komputer (HIMATEKOM) adalah Himpunan di bawah naungan
                                Departemen Teknik Komputer Fakultas Teknologi Informasi Universitas Andalas</p>
                            <a href="/tentang-kami" class="read__more">Read more <span class="arrow_right"></span></a>
                        </div>
                    </div>
                    <!-- Social Media Section -->
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="footer__option__item">
                            <h5>Connect With Us</h5>
                            <p>Ikuti media sosial kami untuk mendapatkan update terbaru tentang kegiatan dan event
                                menarik dari Himatekom!</p>
                            <div class="footer__social" style="margin-top: 20px;">
                                <a href="https://www.instagram.com/himatekom_unand/" class="social-icon"
                                    title="Instagram">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="https://www.linkedin.com/company/himatekom/" class="social-icon"
                                    title="LinkedIn">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                                <a href="https://www.youtube.com/@himatekomunand4/" class="social-icon" title="YouTube">
                                    <i class="fab fa-youtube"></i>
                                </a>
                                <a href="#" class="social-icon" title="TikTok">
                                    <i class="fab fa-tiktok"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- Logo Section -->
                    <div class="col-lg-4 col-md-12">
                        <div class="footer__option__item text-center">
                            <div class="footer__logo" style="margin-bottom: 20px;">
                                <img src="{{ asset('img/logo.png') }}" alt="Himatekom Logo"
                                    style="width: 120px; height: auto; margin-bottom: 15px;">
                            </div>
                            <h5 style="color: #ffffff; margin-bottom: 10px;">HIMATEKOM UNAND</h5>
                            <p style="color: #adadad; font-size: 14px;">
                                Himpunan Mahasiswa<br>
                                Teknik Komputer<br>
                                Universitas Andalas
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Copyright Section -->
            <div class="footer__copyright">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <p class="footer__copyright__text">
                            Copyright &copy;
                            <script>
                                document.write(new Date().getFullYear());
                            </script>
                            Himatekom UNAND. All rights reserved.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->
    <!-- Js Plugins -->
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('js/mixitup.min.js') }}"></script>
    <script src="{{ asset('js/masonry.pkgd.min.js') }}"></script>
    <script src="{{ asset('js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script>
        // Detect scroll event to change navbar background
        window.onscroll = function() {
            var navbar = document.getElementById("header");
            if (window.scrollY > 50) { // You can change 50 to the scroll distance you want
                navbar.classList.add("scrolled");
            } else {
                navbar.classList.remove("scrolled");
            }
        };
        // Add hover effects for social media icons - Updated for new design
        document.querySelectorAll('.social-icon').forEach(function(link) {
            link.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });
            link.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    </script>
    <style>
        /* Additional styles for better footer appearance */
        .footer__social {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }
        .social-icon {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff !important;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        .social-icon:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            text-decoration: none;
        }
        .social-icon[title="Instagram"]:hover {
            background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);
            color: white !important;
        }
        .social-icon[title="LinkedIn"]:hover {
            background: #0077b5;
            color: white !important;
        }
        .social-icon[title="YouTube"]:hover {
            background: #ff0000;
            color: white !important;
        }
        .social-icon[title="TikTok"]:hover {
            background: #000000;
            color: white !important;
        }
        .footer__logo img {
            transition: transform 0.3s ease;
        }
        .footer__logo img:hover {
            transform: scale(1.1);
        }
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .footer__option__item {
                margin-bottom: 30px;
                text-align: center;
            }
            .footer__social {
                text-align: center;
            }
            .footer__social a {
                margin: 0 10px;
            }
        }
    </style>

    @stack('scripts')
</body>
</html>
