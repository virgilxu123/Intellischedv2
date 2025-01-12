<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'IntelliSched')</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.22.3/dist/bootstrap-table.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    {{-- <script src="https://kit.fontawesome.com/1b65260656.js" crossorigin="anonymous"></script> --}}
    <link rel="stylesheet" href="{{asset('admin-assets/fontAwesome/css/fontawesome.css')}}">
    <link rel="stylesheet" href="{{asset('admin-assets/fontAwesome/css/brands.css')}}">
    <link rel="stylesheet" href="{{asset('admin-assets/fontAwesome/css/solid.css')}}">
    <link rel="stylesheet" href="{{asset('admin-assets/css/style.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @yield('links')
</head>

<body>
    <div class="wrapper">
        <aside id="sidebar" class="js-sidebar">
            <!-- Content For Sidebar -->
            <div class="vh-100 ">
                <div class="sidebar-logo">
                    <a href="{{route('dashboard')}}">Intellisched</a>
                </div>
                <ul class="sidebar-nav">
                    <li class="sidebar-header">
                        Admin
                    </li>
                    <li class="sidebar-item">
                        <a href="{{route('dashboard')}}" class="sidebar-link">
                            <i class="fa fa-dashboard px-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed" data-bs-target="#pages" data-bs-toggle="collapse"
                            aria-expanded="false"><i class="fa-solid fa-file-lines px-2"></i>
                            Schedules
                        </a>
                        {{-- <a href="{{route('schedule')}}" class="sidebar-link">
                            <i class="fa fa-table pe-2"></i>
                            Schedules
                        </a> --}}
                        <ul id="pages" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item ms-3">
                                <a href="{{route('schedule')}}" class="sidebar-link">Manage/Create Schedule</a>
                            </li>
                            <li class="sidebar-header ms-3 py-0">
                                Recent
                            </li>
                            <li class="sidebar-item ms-3">
                                <a class="sidebar-link" href="{{ $academic_year_terms->isNotEmpty() ? route('create-schedule', $academic_year_terms->sortByDesc('created_at')->first()->id) : '#' }}" style="font-size: small">
                                    {{ $academic_year_terms->isNotEmpty() ? $academic_year_terms->sortByDesc('created_at')->first()->academic_year->year_start . '-' . ($academic_year_terms->sortByDesc('created_at')->first()->academic_year->year_start + 1) . ' ' . $academic_year_terms->sortByDesc('created_at')->first()->term->term : 'No recent schedule' }}
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-header">
                        Manage
                    </li>
                    <li class="sidebar-item">
                        <a href="{{route('manage-faculty')}}" class="sidebar-link">
                            <i class="fa fa-users px-2"></i>
                            Faculty Members
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{route('manage-subjects')}}" class="sidebar-link">
                            <i class="fa-solid fa-book px-2"></i>
                            Subjects
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{route('manage-rooms')}}" class="sidebar-link">
                            <i class="fa-solid fa-building px-2"></i>
                            Rooms
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{route('manage-designations')}}" class="sidebar-link">
                            <i class="fa fa-info px-2"></i>
                            Designation
                        </a>
                    </li>
                    <li class="sidebar-header">
                        Reports
                    </li>
                    <li class="sidebar-ite">
                        <a href="{{route('work-load-summary')}}" class="sidebar-link">
                            <i class="fa-solid fa-list-check px-2"></i>
                            Workload Summary
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{route('manage-signatories')}}" class="sidebar-link">
                            <i class="fa-solid fa-file-signature px-2"></i>
                            Signatories
                        </a>
                    </li>
                </ul>
            </div>
        </aside>
        <div class="main">
            <nav class="navbar navbar-expand px-3 border-bottom">
                <button class="btn" id="sidebar-toggle" type="button">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-collapse navbar">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0">
                                <img src="{{asset('admin-assets/image/icon-admin-8.jpg')}}" class="avatar img-fluid rounded" alt="">
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="#" class="dropdown-item">Profile</a>
                                <a href="#" class="dropdown-item">Setting</a>
                                <form id="logoutForm" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <a href="#" class="dropdown-item" onclick="document.getElementById('logoutForm').submit()">Logout</a>
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <main class="content px-3 py-2">
                @yield('content')
            </main>
            <a href="#" class="theme-toggle">
                <i class="fa-regular fa-moon"></i>
                <i class="fa-regular fa-sun text-warning"></i>
            </a>
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row text-muted">
                        <div class="col-6 text-start">
                            <p class="mb-0">
                                <a href="#" class="text-muted">
                                    <strong>Intellisched</strong>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/bootstrap-table@1.22.3/dist/bootstrap-table.min.js"></script>
    <script src="{{asset('admin-assets/js/script.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @stack('scripts')
    @yield('scripts')
</body>

</html>
