<!DOCTYPE html>
<html lang="en">
<head>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
 <!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

   <!-- Vendor CSS Files -->
<link href="/assets/vendor/animate.css/animate.min.css" rel="stylesheet">
<link href="/assets/vendor/aos/aos.css" rel="stylesheet">
<link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
<link href="/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
<link href="/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
<link href="/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
@yield('head-section')

<!-- Template Main CSS File -->
<link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>
    <header id="header" class="fixed-top">
        <div class="container d-flex align-items-center">
    
          <h1 class="logo me-auto"><a href="/">Wakil Sathi</a></h1>
          <!-- Uncomment below if you prefer to use an image logo -->
          <!-- <a href="index.html" class="logo me-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
    
          <nav id="navbar" class="navbar order-last order-lg-0">
            <ul>
              <li><a class="active" href="/">Home</a></li>
              <li><a href="/lawyer">Lawyer</a></li>
              <li><a href="contact.html">Contact</a></li>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
          </nav><!-- .navbar -->
    
          <div style="margin-left:15px" >
                @if (Route::has('login'))
                    <div >
                        @auth

                            @if (Auth::user()->role == 'lawyer')
                            <a href="{{ url('/lawyer-dashboard') }}" class="get-started-btn">Lawyer Dashboard</a>
                            @endif
                            @if (Auth::user()->role == 'admin')
                            <a href="{{ url('/admin-dashboard') }}" class="get-started-btn">Admin Dashboard</a>
                            @endif
                            @if (Auth::user()->role == 'client')
                            <a href="{{ url('/lawyer-appointment') }}" class="get-started-btn">Appointments</a>
                            @endif
                            
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                              @csrf
                          </form>
                          
                          <a onclick="document.getElementById('logout-form').submit();" class="get-started-btn" style="cursor: pointer;">Logout</a>
                        @else
                            <a href="{{ route('login') }}" class="">Log in</a>
    
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="">Register</a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
    
        </div>
    </header>

    <main>
        @yield('client')
    </main>
</body>
</html>