<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

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
<nav class="navbar navbar-expand-lg navbar-light mb-2 mb-5">
    <a class="navbar-brand ml-5" href="{{route('home')}}">BLACKGUY</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-around" id="navbarSupportedContent">
        <ul class="navbar-nav">
            {{--                    lap lai toan bo category --}}
            @foreach(App\Models\Category::query()->with('tags')->get() as $category)

                <li class="nav-item category mr-4">
                    <a href="{{route('category.show', $category->id)}}"
                       class="nav-link d-flex justify-content-between text-dark">
                        {{ $category->name }}
                        @if($category->tags->count() > 0)
                            <i class="fas fa-angle-down"></i>
                        @endif
                    </a>
                    @if($category->tags->count() > 0)
                        <div class="sub-category justify-content-center">
                            @foreach($category->tags as $tag)
                                <a href="{{ route('tags', $tag->id) }}" class="sub-category-tag mt-2 mx-5">
                                    {{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </li>

            @endforeach
        </ul>

        @auth
            <div class="btn-group position-absolute" style="right: 70px;">
                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                    {{ Auth::user()->name }}
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="{{ route('profile') }}" class="dropdown-item" type="button">Trang cá nhân</a>
                    <div class="dropdown-divider"></div>

                    @can('admin')
                        <a href="{{ route('admin') }}" class="dropdown-item">Quản lý web</a>
                    @endcan

                    <div class="dropdown-divider"></div>
                    <a href="" class="dropdown-item">Trợ giúp</a>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
        document.getElementById('logout-form').submit();">
                        Đăng xuất
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        @endauth

        @guest
            <div class="ml-5">
                <a href="/login" class="btn btn-info">Đăng nhập</a>
                <a href="/register" class="btn btn-info">Đăng kí</a>
            </div>
        @endguest
    </div>
</nav>

@yield('content')

@section('footer')

@endsection

</body>
</html>
