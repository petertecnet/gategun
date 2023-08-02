<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>
       
        @if(Route::currentRouteName() === 'events.show')  {{ $event->name }} - {{ $event->date }} - @endif
        @if(Route::currentRouteName() === 'productions.show')  {{ $production->name }} - @endif
      
        Gategun:  A solução perfeita para gerenciamento de eventos
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="
     @if(Route::currentRouteName() === 'events.show')  {{ $event->description }} - @endif
    @if(Route::currentRouteName() === 'productions.show')  {{ $production->name }} - @endif 
    Gategun é uma solução de gerenciamento de eventos poderosa e fácil de usar que permite criar e gerenciar eventos, vender ingressos, coletar pagamentos e se comunicar com os participantes."
  
    >

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet"> 
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="darkpan/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="darkpan/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="darkpan/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="darkpan/css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-dark" style="width: 200px; height: auto;" role="status">
                <img src="{{ asset('darkpan/img/logo.png') }}" alt="logo da gategun') }}" class="logoimgspping">
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sign In Start -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class=" col-md-6 ">
                    <div class="bg-secondary rounded p-4 p-sm-5 my-4 mx-3 auth-form-gategun text-white">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <a href="/" class="">
                                <img src="darkpan/img/logo.png" alt="logo da gategun" class="logoimg">
                            </a>
                        </div>  <form method="POST" action="{{ route('register') }}">
                            @csrf
    
                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Nome') }}</label>
    
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
    
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email ') }}</label>
    
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
    
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Senha') }}</label>
    
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
    
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="row mb-3">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirmar senha') }}</label>
    
                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>
    
                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                    <hr>
                                <a class="btn btn-link" href="{{ route('login') }}">
                                    {{ __('Jà tem cadastro?') }}
                                </a>
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Esqueceu a senha?') }}
                                    </a>
                                @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sign In End -->
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="darkpan/lib/chart/chart.min.js"></script>
    <script src="darkpan/lib/easing/easing.min.js"></script>
    <script src="darkpan/lib/waypoints/waypoints.min.js"></script>
    <script src="darkpan/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="darkpan/lib/tempusdominus/js/moment.min.js"></script>
    <script src="darkpan/lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="darkpan/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="darkpan/js/main.js"></script>
</body>

</html>
