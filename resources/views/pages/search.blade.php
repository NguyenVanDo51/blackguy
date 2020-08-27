@extends('templade.app')

@section('title', 'Trang tìm kiếm')

@section('content')
    <div class="container-fluid bg-search mt-5">
        <div class="row justify-content-center">
            <form class="form-inline" method="get" action="{{route('search')}}">
                <div class="form-group ml-3">
                    <input type="text" class="form-control" value="{{$search}}" id="search" name="search"
                           placeholder="Tìm kiếm khóa học">
                </div>
                <div class="input-group">

                    <select class="custom-select" name="option">
                        <option value="">Tất cả</option>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}"
                                    @if($option == $category->id) selected @endif>{{$category->name}}</option>
                        @endforeach
                    </select>

                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">Tìm kiếm</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="row m-3">
            <h4>Tìm thấy ({{$courses->total()}}) kết quả cho từ khóa: '{{$search}}' @if($option == null)  @else trong
                danh mục '{{$option}}' @endif.</h4>
        </div>

        <div class="row">
            <div class="col-9">
                <x-listItem :courses="$courses" height="10"/>

                <div class="mt-3">
                    {{$courses->appends(request()->all())->links()}}
                </div>
            </div>
            <div class="col-3">
                <x-categories/>
                <x-tags/>
            </div>
        </div>


    </div>
@endsection

@section('footer')
    @parent
@endsection
