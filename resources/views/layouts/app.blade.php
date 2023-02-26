<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet"/>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.1.0/mdb.min.css" rel="stylesheet"/>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @yield('extra_css')

</head>
<body>

    <div class="page-wrapper chiller-theme">
        
        <nav id="sidebar" class="sidebar-wrapper">
          <div class="sidebar-content">
            <div class="sidebar-brand">
                <a href="#">ninja hr</a>
                <div id="close-sidebar">
                    <i class="fas fa-times"></i>
                </div>
            </div>
            <div class="sidebar-header">
                <div class="user-pic">
                    <img class="img-responsive img-rounded" src="{{ asset('images/profile.png') }}"
                    alt="User picture">
                </div>
                <div class="user-info">
                    <span class="user-name">Jhon
                    <strong>Smith</strong>
                    </span>
                    <span class="user-role">Administrator</span>
                    <span class="user-status">
                    <i class="fa fa-circle"></i>
                    <span>Online</span>
                    </span>
                </div>
            </div>
            <!-- sidebar-header  -->
            <div class="sidebar-menu">
                <ul>
                    <li class="header-menu">
                        <span>Menu</span>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fas fa-home"></i>
                            <span>Home</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fas fa-users"></i>
                            <span>Employees</span>
                        </a>
                    </li>
                    
                    {{-- <li class="sidebar-dropdown">
                        <a href="#">
                            <i class="fa fa-globe"></i>
                            <span>Maps</span>
                        </a>
                        <div class="sidebar-submenu">
                            <ul>
                            <li>
                                <a href="#">Google maps</a>
                            </li>
                            <li>
                                <a href="#">Open street map</a>
                            </li>
                            </ul>
                        </div>
                    </li> --}}
                </ul>
            </div>
            <!-- sidebar-menu  -->
          </div>
        </nav>
        <!-- sidebar-wrapper  -->
        <div class="app-bar">
            <div class="col-md-8 mx-auto d-flex justify-content-between align-items-center">
                <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
                    <i class="fas fa-bars"></i>
                </a>
                <h5 class="mb-0">@yield('title')</h5>
                <a href=""></a>
            </div>
        </div>
        <main class="py-4">
            @yield('content')
        </main>
        <div class="bottom-bar">
            <div class="col-md-8 mx-auto d-flex justify-content-between">
                <a href="">
                    <i class="fas fa-home"></i>
                    <p class="mb-0">Home</p>
                </a>
                <a href="">
                    <i class="fas fa-home"></i>
                    <p class="mb-0">Home</p>
                </a>
                <a href="">
                    <i class="fas fa-home"></i>
                    <p class="mb-0">Home</p>
                </a>
            </div>
        </div>
        <!-- page-content" -->

    {{-- Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.1.0/mdb.min.js"></script>

    <!-- Jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    @yield('script')

    <script>
        jQuery(function ($) {

            $(".sidebar-dropdown > a").click(function() {
                $(".sidebar-submenu").slideUp(200);
                if (
                    $(this).parent().hasClass("active")
                ) {
                    $(".sidebar-dropdown").removeClass("active");
                    $(this).parent().removeClass("active");
                } else {
                    $(".sidebar-dropdown").removeClass("active");
                    $(this)
                    .next(".sidebar-submenu")
                    .slideDown(200);
                    $(this)
                    .parent()
                    .addClass("active");
                }
            });

            $("#close-sidebar").click(function(e) {
                e.preventDefault();
                $(".page-wrapper").removeClass("toggled");
            });
            $("#show-sidebar").click(function(e) {
                e.preventDefault();
                $(".page-wrapper").addClass("toggled");
            });

        });
    </script>
</body>
</html>
