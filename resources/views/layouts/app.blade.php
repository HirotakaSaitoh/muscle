<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> 

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title font color="#3f729b">{{ config('app.name', '筋肉満') }}</title>
    <!--<title>筋肉満</title>-->

    <!-- Styles -->
    <link href="{{ asset('css/app.css',true) }}" rel="stylesheet">
    
    <!--faviconの埋め込み-->
    <link rel="shortcut icon" href="{{ asset('/favicon.ico') }}">
    
    <!--Font Awesomeのアイコンを埋め込む準備-->
    <script src="https://kit.fontawesome.com/b7d8a8cbdb.js" crossorigin="anonymous"></script>
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>  

<!--<script src="{{ asset('js/app.js') }}" defer></script>-->

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top" style="background-color: #000000;">
            <!--2A3132   003B46 021C1E CDCDC0 1E1F26 f4f4f4-->
        <!--<nav class="navbar navbar-default navbar-static-top navbar-dark bg-dark"> -->
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                         <img src="/upload/image/iconP2.png"></img>
                    </a>
                    <img src="/upload/image/pankchii.jpg"></img>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <div class="dropdown">
                               
                                <button type = "button" id="dropdownMenuButton" class="btn btn-success" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                </button>

                               
                                 <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    
                                        <a href="{{ ('/logout') }}" class="dropdown-item" 
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>
                                        <form id="logout-form" action="{{ ('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                       
                                </div>   
                                
                                
                                
                                
                            </div>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js',true) }}"></script>
    
</body>
</html>
