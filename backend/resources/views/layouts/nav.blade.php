<!-- Navbar Start -->
    <nav class="navbar navbar-expand bg-dark  sticky-top px-4 py-0" >
        <a href="/" class="navbar-brand d-flex d-lg-none me-4">
            <h2 class="text-primary mb-0">
                <img src="{{ asset('darkpan/img/logo.png') }}" alt="logo da gategun" class="logomobile">
            </h2>
        </a>
        <a href="#" class="sidebar-toggler flex-shrink-0">
            <i class="fa fa-bars"></i>
        </a>
        <form class="d-none d-md-flex ms-4">
            <input class="form-control bg-dark border-0" type="search" placeholder="Search">
        </form>
        <div class="navbar-nav align-items-center ms-auto">
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fa fa-shopping-cart me-lg-2"></i>
                    <span id="cartIcon" class="d-none d-lg-inline-flex"></span>
                </a>
                <div id="cartItems" class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                    <!-- Itens do carrinho serão adicionados aqui dinamicamente -->
                </div>
            </div>
            <button class="btn btn-secondary nav-link" id="scanQrCodeBtn">
                <i class="fa fa-qrcode me-lg-2"></i> 
            </button>
            <!-- Elemento de vídeo para exibir a câmera e escanear o QR Code -->
            <video id="qrCodeVideo" style="display: none;"></video>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fa fa-user me-lg-2"></i>
                    <span class="d-none d-lg-inline-flex">{{ Auth::user()->name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                    <a href="#" class="dropdown-item">My Profile</a>
                    <a href="#" class="dropdown-item">Settings</a>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->