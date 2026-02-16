<div>
    <div class="app-menu navbar-menu">
        <div class="navbar-brand-box">
            <a href="{{ route('user.dashboard') }}" class="logo logo-dark">
                <span class="logo-sm">
                    <img src="{{ asset('user/assets/images/logo.png') }}" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="{{ asset('user/assets/images/logo-light.png') }}" alt="" height="50">
                </span>
            </a>
            <a href="{{ route('user.dashboard') }}" class="logo logo-light">
                <span class="logo-sm">
                    <img src="{{ asset('user/assets/images/logo.png') }}" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="{{ asset('user/assets/images/logo-light.png') }}" alt="" height="50">
                </span>
            </a>
            <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                <i class="ri-record-circle-line"></i>
            </button>
        </div>
        @livewire('user.partials.sidebar')
        <div class="sidebar-background"></div>
    </div>
    <div class="vertical-overlay"></div>
</div>
