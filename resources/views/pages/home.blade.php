@extends('templade.app')

@section('title', 'Black guy')

@section('content')
    <div class="container bg-search mt-5">
        <div class="row justify-content-center">
            <form class="form-inline" method="get" action="{{ route('course.search') }}">
                <div class="form-group ml-3">
                    <label for="search" class="sr-only">Password</label>
                    <input type="text" class="form-control" id="search" name="search" placeholder="Tìm kiếm khóa học">
                </div>

                <div class="input-group">
                    <select class="custom-select" name="option">
                        <option selected value="">Tất cả</option>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">Tìm kiếm</button>
                    </div>
                </div>
            </form>
        </div>

        <h2 class="mt-5"><i class="fas fa-laptop-code mr-2"></i>Khóa học</h2>
        @foreach($tags as $tag)
            <div class="row mt-5">
                <div class="col-12">
                    <a href="{{route('tag.show', $tag->id)}}"><h1>{{$tag->name}}</h1></a>
                </div>
            </div>
            <div class="row mt-3">
                @foreach($tag->courses()->limit(4)->get() as $course)
                    <div class="col-6 col-md-3">
                        <x-card-item :course="$course"/>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
@endsection
