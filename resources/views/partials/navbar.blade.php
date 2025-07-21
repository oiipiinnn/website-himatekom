<header id="header" class="header">
    <div class="container">
        <div class="row">
            <div class="col-lg-2 d-flex align-items-center">
                <div class="header__logo">
                    <a href="/">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo">
                        <div class="header__text d-flex align-items-center">
                            <span>Himpunan Mahasiswa</span>
                            <span>Teknik Komputer</span>
                        </div>
                    </a>
                </div>

            </div>
            <div class="col-lg-10">
                <div class="header__nav__option">
                    <nav class="header__nav__menu mobile-menu">
                        <ul>
                            <li class="{{ Request::is('/') ? 'active' : '' }}"><a href="/">Home</a></li>
                            <li class="{{ Request::is('core3d') ? 'active' : '' }}"><a href="/core3d">CORE3D</a></li>
                            <li class="{{ Request::is('tentang-kami') ? 'active' : '' }}"><a
                                    href="/tentang-kami">Tentang
                                    Kami</a></li>
                            <li class="{{ Request::is('pengurus') ? 'active' : '' }}"><a href="/pengurus">Pengurus</a>
                            </li>
                            <li class="{{ Request::is('data-mahasiswa') ? 'active' : '' }}"><a
                                    href="/data-mahasiswa">Data Mahasiswa</a></li>
                            <li
                                class="{{ Request::is('ruang-aspirasi') || Request::is('blog') || Request::is('galeri') ? 'active' : '' }}">
                                <a href="#">Informasi</a>
                                <ul class="dropdown">
                                    <li class="{{ Request::is('ruang-aspirasi') ? 'active' : '' }}"><a
                                            href="/ruang-aspirasi">Ruang Aspirasi</a></li>
                                    <li class="{{ Request::is('blog') ? 'active' : '' }}"><a href="/blog">Blog</a>
                                    </li>
                                    <li class="{{ Request::is('galeri') ? 'active' : '' }}"><a
                                            href="/galeri">Gallery</a></li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div id="mobile-menu-wrap"></div>
    </div>
</header>
