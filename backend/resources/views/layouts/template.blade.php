<!DOCTYPE html>
<html lang="pt-BR">
   @include('layouts.head')
   <body>
      <div class="container-fluid position-relative d-flex p-0" >
         <!-- Spinner Start -->
         <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-dark" style="width: 200px; height: auto;" role="status">
               <img src="{{ asset('darkpan/img/logo.png') }}" alt="logo da gategun') }}" class="logoimgspping">
            </div>
         </div>
         <!-- Spinner End -->

         <!-- Sidebar Start -->
         @include('layouts.sidebar')
         <!-- Sidebar End -->

         <!-- Content Start -->
         <div class="content close" >
            @include('layouts.nav')
            @include('layouts.erros')
            @yield('content')
         </div>
         <!-- Content End -->

         <!-- Back to Top -->
         <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
      </div>

      @include('layouts.footer')
      @include('layouts.scripts')
      <script>
         // Código JavaScript para controlar o estado do sidebar
         $(document).ready(function () {
            // Feche o sidebar no início
            $('#sidebar').addClass('closed');

            // Evento de clique para abrir ou fechar o sidebar
            $('#toggleSidebar').on('click', function () {
               $('#sidebar').toggleClass('closed');
            });
         });
      </script>
   </body>
</html>
