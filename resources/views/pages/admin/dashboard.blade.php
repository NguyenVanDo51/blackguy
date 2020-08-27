<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/home.js') }}" defer></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/course.css') }}">

    <!-- Icon -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
          integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

</head>
<body>
<div class="container-fluid">
    <div class="row">
        @section('menu')
        <div class="col-2 pt-4 position-fixed overflow-auto"
             style="height: 100vh; box-shadow: 2px 0px 6px; z-index: 999;">
            <p class="text-center">Chức năng Admin</p>
            <div class="dropdown-divider"></div>
            <a href="{{route('admin')}}"
               @if($function == 'dashboard')
               class="btn-primary btn w-100 text-left my-1">
                @else
                    class="btn w-100 text-left my-1">
                @endif
                <i class="fas fa-columns mr-2"></i>
                <span>Thống kê</span>
            </a>
            <a href="{{route('admin', 'course')}}"
               @if($function == 'course' || $function == 'edit-course' || $function == 'lession' || $function == 'add-lession')
               class="btn-primary btn w-100 text-left my-1">
                @else
                    class="btn w-100 text-left my-1">
                @endif
                <i class="fas fa-columns mr-2"></i>
                <span>Quản lý khóa học</span>
            </a>
            <a href="{{route('admin', 'user')}}"
               @if($function == 'user')
               class="btn-primary btn w-100 text-left my-1">
                @else
                    class="btn w-100 text-left my-1">
                @endif
                <i class="fas fa-columns mr-2"></i>
                <span>Tài khoản</span>
            </a>
            <a
                @if($function == 'help')
                class="btn-primary btn w-100 text-left my-1">
                @else
                    class="btn w-100 text-left my-1">
                @endif
                <i class="fas fa-columns mr-2"></i>
                <span>Trợ giúp</span>
            </a>

            <a href="{{route('home')}}" class="btn w-100 text-left my-1">
                <i class="fas fa-columns mr-2"></i>
                <span>Thoát</span>
            </a>
        </div>
        @show

        <div class="col-2"></div>
        <div class="col-10">
            <div class="text-right mt-3">
                <span>Xin chào, {{Auth::user()->name}}</span>
                <a class="mx-2" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
        document.getElementById('logout-form').submit();">
                    Đăng xuất
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
            @switch($function)
                @case('dashboard')
                <x-admin.statistical/>
                @break

                @case('course')
                <x-admin.course :courses="$courses"/>
                @break

                @case('user')
                <x-admin.user/>
                @break

                @case('add-course')
                <x-admin.addcourse :tags="$tags" :categories="$categories"/>
                @break

                @case('edit-course')
                <x-admin.editcourse :tags="$tags" :categories="$categories" :course="$course" />
                @break

                @case('lession')
                <x-admin.lession :course="$course" />
                @break

                @case('add-lession')
                <x-admin.addlession :course="$course" />
                @break

                @case('edit-lession')
                <x-admin.editlession :course="$course" :lession="$lession"/>
                @break

            @endswitch
        </div>
    </div>
</div>
</body>
</html>
