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

    {{-- Datatable --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
    
    {{--  Daterange Picker  --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    {{-- select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
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
                    <img class="img-responsive img-rounded" src="{{ auth()->user()->profile_img_path() }}"
                    alt="User picture">
                </div>
                <div class="user-info">
                    <span class="user-name">{{ auth()->user()->name }}</span>
                    <span class="user-role">{{ auth()->user()->department ? auth()->user()->department->title : '-' }}</span>
                    <span class="user-status">
                    <i class="fa fa-circle"></i>
                    <span>Online</span>
                    </span>
                </div>
            </div>

            <div class="sidebar-menu">
                <ul>
                    <li class="header-menu">
                        <span>Menu</span>
                    </li>
                    <li>
                        <a href="/">
                            <i class="fas fa-home"></i>
                            <span>Home</span>
                        </a>
                    </li>
                    @can('view_employee')
                    <li>
                        <a href="{{ route('employee.index') }}">
                            <i class="fas fa-users"></i>
                            <span>Employees</span>
                        </a>
                    </li>
                    @endcan
                    @can('view_salary')
                    <li>
                        <a href="{{ route('salary.index') }}">
                            <i class="fa-solid fa-money-bill"></i>
                            <span>Salary</span>
                        </a>
                    </li>
                    @endcan
                    @can('view_company_setting')
                    <li>
                        <a href="{{ route('company-setting.show', 1) }}">
                            <i class="fa-sharp fa-solid fa-building"></i>
                            <span>Company Setting</span>
                        </a>
                    </li>
                    @endcan
                    @can('view_department')
                    <li>
                        <a href="{{ route('department.index') }}">
                            <i class="fa-solid fa-sitemap"></i>
                            <span>Departments</span>
                        </a>
                    </li> 
                    @endcan
                    @can('view_role')
                    <li>
                        <a href="{{ route('role.index') }}">
                            <i class="fa-solid fa-user-shield"></i>
                            <span>Role</span>
                        </a>
                    </li>
                    @endcan
                    @can('view_permission')
                    <li>
                        <a href="{{ route('permission.index') }}">
                            <i class="fa-sharp fa-solid fa-shield"></i>
                            <span>Permission</span>
                        </a>
                    </li>
                    @endcan
                    @can('view_attendance')
                    <li>
                        <a href="{{ route('attendance.index') }}">
                            <i class="fa-solid fa-calendar-check"></i>
                            <span>Attendance <small>(Employees)</small></span>
                        </a>
                    </li>
                    @endcan
                    @can('view_attendance_overview')
                    <li>
                        <a href="{{ route('attendance.overview') }}">
                            <i class="fa-solid fa-calendar-check"></i>
                            <span>Attendance Overview</span>
                        </a>
                    </li>
                    @endcan
                    @can('view_payroll')
                    <li>
                        <a href="{{ route('payroll') }}">
                            <i class="fa-solid fa-money-check"></i>
                            <span>Payroll</span>
                        </a>
                    </li>
                    @endcan
                    
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

          </div>
        </nav>

        <div class="app-bar">
            <div class="col-md-10 mx-auto d-flex justify-content-between align-items-center px-2">
                @if (request()->is('/'))
                    {{-- <a id="show-sidebar" class="btn btn-sm btn-dark" href="#"> --}}
                    <a id="show-sidebar" class="" href="#">
                        <i class="fas fa-bars"></i>
                    </a>
                @else
                    <a id="back-btn" class="" href="#">
                        <i class="fa-solid fa-chevron-left"></i>
                    </a>
                @endif
                <h5 class="mb-0">@yield('title')</h5>
                <a href=""></a>
            </div>
        </div>
        <main class="py-5 px-2 content">
            <div class="col-md-10 mx-auto pb-5">
                @yield('content')
            </div>
        </main>
        <div class="bottom-bar">
            <div class="col-md-10 mx-auto d-flex justify-content-between px-2">
                <a href="{{ route('home') }}">
                    <i class="fas fa-home"></i>
                    <p class="mb-0">Home</p>
                </a>
                <a href="{{ route('attendance-scan') }}">
                    <i class="fa-solid fa-user-clock"></i>
                    <p class="mb-0">Attendance</p>
                </a>
                <a href="">
                    <i class="fa-solid fa-briefcase"></i>
                    <p class="mb-0">Project</p>
                </a>
                <a href="{{ route('profile.profile') }}">
                    <i class="fas fa-user"></i>
                    <p class="mb-0">Profile</p>
                </a>
            </div>
        </div>

    </div>
    {{-- Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.1.0/mdb.min.js"></script>

    <!-- Jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    {{-- Datatable --}}
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.jsdelivr.net/g/mark.js(jquery.mark.min.js)"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.10.13/features/mark.js/datatables.mark.js"></script>

    {{--  Daterange Picker  --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

     {{--  Laravel Javascript Validation   --}}
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>

    {{--  Sweet alert 2   --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Sweet alert 1 --}}
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    {{-- select2 --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{ asset('vendor/larapass/js/larapass.js') }}"></script>

    @yield('script')

    <script>

        let token = document.querySelector('meta[name=csrf-token]')
        if(token) {
            $.ajaxSetup({
                headers: { 
                    'X-CSRF-TOKEN': token.content
                }
            });
        }else {
            console.error('Token not found!');
        }

        const Toast = Swal.mixin({
            toast: true,
            position: 'top',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })


        jQuery(function ($) {

            $('#back-btn').on('click', function (e) {
                e.preventDefault()
                window.history.go(-1)
                return false;
            })

            $.extend(true, $.fn.dataTable.defaults, {
                mark: true,
                // responsive: true,
                // processing: true,
                // serverSide: true,
                // language: {
                //     paginate: {
                //         next: "<i class='fa-solid fa-circle-arrow-right'></i>",
                //         previous: "<i class='fa-solid fa-circle-arrow-left'></i>"
                //     },
                //     processing: 'processing................'
                // },
                // columnDefs: [
                //     {
                //         targets: [0],
                //         class: 'control'
                //     },
                //     {
                //         targets: "no-sort",
                //         sortable: false
                //     },
                //     {
                //         targets: "no-search",
                //         searchable: false
                //     },
                //     {
                //         targets: "hidden",
                //         visible: false
                //     },
                    
                // ],
            });

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

            @if (request()->is('/')) {
                document.addEventListener('click', (event) => {
                    if(document.getElementById('show-sidebar').contains(event.target)){
                        $(".page-wrapper").addClass("toggled");
                    }else if(!document.getElementById('sidebar').contains(event.target)){
                        $(".page-wrapper").removeClass("toggled");
                    }
                })
            }
            @endif

            $('.select-ninja').select2({
                placeholder: "Please choose",
                allowClear: true
            });


            @if (session('create'))
                Swal.fire({
                    title: 'Successfully Created!',
                    text: "{{ session('create') }}",
                    icon: 'success',
                    confirmButtonText: 'Containue'
                })
            @endif

            @if (session('update'))
                Swal.fire({
                    title: 'Successfully Updated!',
                    text: "{{ session('update') }}",
                    icon: 'success',
                    confirmButtonText: 'Containue'
                })
            @endif

            

        });
    </script>
</body>
</html>
