<div>
    <div class="sidebar-wrapper" data-layout="stroke-svg">
        <div>
            <div class="logo-wrapper">
                <a href="{{ route('dashboard') }}">
                    <img class="img-fluid for-light" src="{{ asset('assets/images/logo/logo.png') }}" alt="">
                    <img class="img-fluid for-dark" src="{{ asset('assets/images/logo/logo_dark.png') }}" alt="" >
                </a>
                <div class="toggle-sidebar">
                    <svg class="sidebar-toggle">
                        <use href="{{ asset('assets/svg/icon-sprite.svg') }}#toggle-icon"></use>
                    </svg>
                </div>
            </div>
            <div class="logo-icon-wrapper">
                <a href="{{ route('dashboard') }}">
                    <img class="img-fluid" src="{{ asset('assets/images/logo/logo-icon.png') }}" alt="">
                </a>
            </div>
            <nav class="sidebar-main">
                <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
                <div id="sidebar-menu">
                    <ul class="sidebar-links" id="simple-bar">
                        <li class="back-btn">
                            <a href="{{ route('dashboard') }}">
                                <img class="img-fluid" src="{{ asset('assets/images/logo/logo-icon.png') }}" alt="">
                            </a>
                            <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                        </li>
                        <li class="pin-title sidebar-main-title">
                            <div>
                                <h6>Pinned</h6>
                            </div>
                        </li>
                        <li class="sidebar-main-title">
                            <div>
                                <h6 class="lan-1">General</h6>
                            </div>
                        </li>
                        <li class="sidebar-list">
                            <i class="fa fa-thumb-tack"></i>
                            <a class="sidebar-link sidebar-title link-nav" href="#">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg') }}#stroke-home"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg') }}#fill-home"></use>
                                </svg>
                                <span class="lan-3">Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-list">
                            <i class="fa fa-thumb-tack"></i>
                            <a class="sidebar-link sidebar-title" href="#">
                                <svg class="stroke-icon">
                                    <use href="../assets/svg/icon-sprite.svg#stroke-widget"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="../assets/svg/icon-sprite.svg#fill-widget"></use>
                                </svg>
                                <span class="lan-6">Widgets</span>
                            </a>
                            <ul class="sidebar-submenu">
                                <li><a href="general-widget.html">General</a></li>
                                <li> <a href="chart-widget.html">Chart</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
            </nav>
        </div>
    </div>
</div>
