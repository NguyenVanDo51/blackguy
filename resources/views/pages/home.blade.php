@extends('templade.app')

@section('title', 'Black guy')

@section('navbar')
    @parent
@endsection

@section('content')
    <div class="container bg-search mt-5">
        <div class="row justify-content-center">
            <form class="form-inline">
                <div class="form-group ml-3">
                    <label for="search" class="sr-only">Password</label>
                    <input type="text" class="form-control" id="search" name="search" placeholder="Tìm kiếm khóa học">
                </div>

                <div class="input-group">
                    <select class="custom-select">
                        <option selected>Tùy chọn</option>
                        @foreach($categories as $category)
                            <option value="">{{$category->name}}</option>
                        @endforeach
                    </select>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button">Tìm kiếm</button>
                    </div>
                </div>
            </form>
        </div>

        <h2 class="mt-5">Newest</h2>
        @foreach($tags as $tag)
            <div class="row mt-5">
                <a href=""><h1>{{$tag->name}}</h1></a>
            </div>
            <div class="row">
                @foreach($tag->courses()->get() as $course)
                    <div class="col-6 col-md-3">
                        <a href="">
                            <div class="card course-item" style="height: 22rem;">
                                <img class="card-img-top" src="{{$course->img ?? ""}}" alt="Card image cap">
                                <div class="card-title m-3">{{$course->name}}</div>
                                <div class="card-body mb-3 overflow-hidden">
                                    <p class="card-text">{{$course->description}}</p>
                                </div>
                                <div class="card-footer">Ngày tải lên: {{Str::substr($course->updated_at,0, 10) ?? "2020-08-18"}}</div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
@endsection

{{--@foreach($movieList as $movie)--}}
{{--    <div class="col-6 col-md-3">--}}
{{--        <a href="{{ route('movieIndex',['id' => $movie->id, 'chapter' => '1']) }}">--}}
{{--            <div class="card movie-item text-light" style="background-image: url('{{$movie->chapters->first()->img}}');" title="{{$movie->name}}">--}}
{{--                <h5 class="card-header">{{$movie->name}}</h5>--}}
{{--                <p class="card-footer">Số tập: {{$movie->chapters->count()}}</p>--}}
{{--            </div>--}}
{{--        </a>--}}
{{--    </div>--}}
{{--@endforeach--}}
