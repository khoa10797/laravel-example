<!DOCTYPE html>
<html lang="vi">

<head>
    <title>{{$title}}</title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <script>
        addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <!--// Meta tag Keywords -->

    <!-- Custom-Files -->
    <!-- Bootstrap-CSS -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
    <!-- Style-CSS -->
    <link rel="stylesheet" href="{{asset('css/style.css')}}" type="text/css" media="all"/>
    <!-- Font-Awesome-Icons-CSS -->
    <link href="{{asset('css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- Custom-Files -->
    <link href="{{asset('css/custom.css')}}" rel="stylesheet" type="text/css">

    <!-- Web-Fonts -->
    <link
        href="//fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i&amp;subset=latin-ext"
        rel="stylesheet">
    <link
        href="//fonts.googleapis.com/css?family=Barlow+Semi+Condensed:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- //Web-Fonts -->

    <script src="{{asset('js/jquery-3.4.1.min.js')}}" type="text/javascript"></script>

    <style>
        .logo-user {
            text-align: center;
            display: inline-block;
            height: 30px;
            width: 30px;
            color: white;
            background-color: #00aced;
        }
    </style>
</head>

<body>
<!-- header -->
<header id="home">
    <!-- top-bar -->
    <div class="top-bar py-2 border-bottom">
        <div class="container">
            <div class="row middle-flex">
                <div class="col-xl-7 col-md-5 top-social-agile mb-md-0 mb-1 text-lg-left text-center">
                    <div class="row">
                        <div class="col-xl-3 col-6 header-top_w3layouts">
                            <p class="text-da">
                                <span class="fa fa-map-marker mr-2"></span>Hà Nội, Việt Nam
                            </p>
                        </div>
                        <div class="col-xl-3 col-6 header-top_w3layouts">
                            <p class="text-da">
                                <span class="fa fa-phone mr-2"></span>+84 000263676
                            </p>
                        </div>
                        <div class="col-xl-6"></div>
                    </div>
                </div>
                <div class="col-xl-5 col-md-7 top-social-agile text-md-right text-center pr-sm-0 mt-md-0 mt-2">
                    <div class="row middle-flex">
                        <div class="col-lg-5 col-4 top-w3layouts p-md-0 text-right">
                            <!-- login -->
                            @if(Session::has('user-avatar'))
                                <a href="{{url('/logout')}}"
                                   class="rounded-circle logo-user">{{Session::get('user-avatar')}}</a>
                            @elseif(Session::has('user-name'))
                                <a href="{{url('/logout')}}"
                                   class="rounded-circle logo-user">{{Session::get('user-name')}}</a>
                            @else
                                <a href="{{url('login')}}" class="btn login-button-2 text-uppercase text-wh">
                                    <span class="fa fa-sign-in mr-2"></span>Login
                                </a>
                        @endif
                        <!-- //login -->
                        </div>
                        <div class="col-lg-7 col-8 social-grid-w3">
                            <!-- social icons -->
                            <ul class="top-right-info">
                                <li>
                                    <p>Follow Us:</p>
                                </li>
                                <li class="facebook-w3">
                                    <a href="#facebook">
                                        <span class="fa fa-facebook-f"></span>
                                    </a>
                                </li>
                                <li class="google-w3">
                                    <a href="#google">
                                        <span class="fa fa-google-plus"></span>
                                    </a>
                                </li>
                                <li>
                                    <p>Cart:</p>
                                </li>
                                <li class="twitter-w3">
                                    <div style="position: relative">
                                        <a href="{{url('/order')}}">
                                            <span class="fa fa-shopping-cart"></span>
                                        </a>
                                        @if(Session::has('total-item') && Session::get('total-item'))
                                            <span id="total-item-cart">{{Session::get('total-item')}}</span>
                                        @endif
                                    </div>
                                </li>
                            </ul>
                            <!-- //social icons -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- //top-bar -->

<!-- header 2 -->
<!-- navigation -->
<div class="main-top py-1">
    <div class="container">
        <div class="nav-content">
            <!-- logo -->
            <h1>
                <a id="logo" class="logo" href="{{url('/')}}">
                    <img src="/images/logo.png" alt="" class="img-fluid"><span>Tasty</span> Burger
                </a>
            </h1>
            <!-- //logo -->
            <!-- nav -->
            <div class="nav_web-dealingsls">
                <nav style="line-height: 2.5">
                    <label for="drop" class="toggle">Menu</label>
                    <input type="checkbox" id="drop"/>
                    <ul class="menu">
                        <li><a href="{{url('home')}}">Home</a></li>
                        {{--                        <li><a href="{{url('menu')}}">About Us</a></li>--}}
                        <li><a href="{{url('menu')}}">Menu</a></li>
                        {{--                        <li><a href="{{url('menu')}}">Contact Us</a></li>--}}
                        @if($title == 'Menu')
                            <li>
                                <div class="active-cyan-4">
                                    <input id="search-box" class="form-control" type="text" placeholder="Search"
                                           aria-label="Search">
                                </div>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
            <!-- //nav -->
        </div>
    </div>
</div>
<!-- //navigation -->
<!-- //header 2 -->

<!-- banner -->
<div class="main-banner-2">

</div>

<div>
    @yield('navbar-botttom')
</div>

<div class="container">
    @yield('content')
</div>

<script src="{{asset('/js/custom.js')}}"></script>
<script src="{{asset('/js/bootstrap.min.js')}}"></script>
</body>
</html>
