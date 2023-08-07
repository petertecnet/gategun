<!-- Navbar Start -->
    <nav class="navbar navbar-expand bg-dark  sticky-top px-4 py-0" >
    
    
        <div class="dropdown-gategun">
            <a href="#" class="dropdown-toggle-gategun bg-dark" onclick="toggleDropdown()">
            <img src="{{ asset('darkpan/img/logo.png') }}"   class="logonav"> </a>
            <div class="dropdown-menu-gategun" id="myDropdown">
              <!-- Itens do dropdown -->
              <a href="/" class="nav-item nav-link {{ Request::is('/') ? 'active' : '' }}"><i class="fa fa-tachometer-alt me-2"></i>Eventos</a>
           <a href="/productions/all" class="nav-item nav-link {{ Request::is('productions/all') ? 'active' : '' }}"><i class="fa fa-square me-2"></i>Produção</a>
           <a href="/tickets" class="nav-item nav-link {{ Request::is('tickets') ? 'active' : '' }}"><i class="fa fa-th me-2"></i>Meu ingressos</a>
           <!-- Add more sidebar items as needed -->
           <a href="/profile" class="nav-item nav-link {{ Request::is('profile') ? 'active' : '' }}"><i class="fa fa-user me-2"></i>Meu Perfil</a>
           <a href="/settings" class="nav-item nav-link {{ Request::is('settings') ? 'active' : '' }}"><i class="fa fa-cog me-2"></i>Configurações</a>
           <a href="/notifications" class="nav-item nav-link {{ Request::is('notifications') ? 'active' : '' }}"><i class="fa fa-bell me-2"></i>Notificações</a>
           <a href="/help" class="nav-item nav-link {{ Request::is('help') ? 'active' : '' }}"><i class="fa fa-question-circle me-2"></i>Ajuda</a>
           <a href="/contact" class="nav-item nav-link {{ Request::is('contact') ? 'active' : '' }}"><i class="fa fa-envelope me-2"></i>Contato</a>
           <a href="{{ route('logout') }}" class="nav-item nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
               <i class="fa fa-sign-out-alt me-2"></i>Logout
           </a>
           <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
               @csrf
           </form>
              <!-- Adicione mais itens conforme necessário -->
            </div>
          </div>
          
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