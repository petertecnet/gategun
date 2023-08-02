<!-- Sidebar Start -->
<div class="sidebar pe-4 pb-3 bg-dark " style="opacity: 0.5">
   <nav class="navbar">
       <div class="d-flex align-items-center ms-4 mb-4">
           <!-- Add any content you want to display at the top of the sidebar -->
       </div>
       <div class="navbar-nav w-100">
           <a href="/" class="navbar-brand mx-4 mb-3">
               <img src="{{ asset('darkpan/img/writelogo.png') }}" alt="logo da gategun" class="logomobile">
           </a>
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
       </div>
   </nav>
</div>
<!-- Sidebar End -->
