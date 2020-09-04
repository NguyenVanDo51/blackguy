@extends('templade.app')

@section('content')
    <!-- Top info -->
    <div class="container-fluid my-5">
        <div class="row bg-dark mb-5 p-4 text-light">
            <div class="col-2"></div>
            <div class="col-8">
                <h2>{{$course->name}}</h2>
                <p>Tác giả:
                    @if( empty($course->user_id))
                        Admin
                    @else
                        {{ App\User::query()->findOrFail($course->user_id)->name ?? "Admin"}}
                    @endif
                </p>
                <span>Lượt thích: {{$course->like}}</span>
                <span class="mx-3">Lượt xem: {{$course->view}}</span>
                <span>Số bai hoc: {{$course->lessions()->count()}}</span>
                @if(!empty($course->lessions()->first()))
                    <p class="my-2">
                    @if($course->users()->get()->contains(Auth::user()))
                        <div class="progress my-3">
                            <div class="progress-bar" role="progressbar" style="width: {{$percent}}%;"
                                 aria-valuenow="25"
                                 aria-valuemin="0" aria-valuemax="100">
                                {{$percent}}%
                            </div>
                        </div>
                        <a href="{{ route('lession', ['course' => $course->id, 'lession' => Auth::user()->courses()->where('course_id', $course->id)->first()->pivot->latest]) }}"
                           class="btn btn-primary mr-2">
                            Tiếp tục học
                        </a>
                    @else
                        <a href="{{ route('lession', ['course' => $course->id, 'lession' => $course->lessions()->first('id')->id]) }}"
                           class="btn btn-primary mr-2">
                            Đăng kí ngay
                        </a>
                    @endif
                    @guest
                        <label for="" class="text-danger"> * Bạn cần đăng nhập để tiếp tục </label>
                        @endguest
                        </p>
                    @else
                        <div class="my-3 mr-2">
                            <button class="btn btn-secondary">Sắp ra mắt</button>
                        </div>
                    @endif
            </div>
            <div class="col-2"></div>
        </div>
    </div>
    <!-- End top info -->

    <!-- Content -->
    <div class="container">

        <!-- breadcrumb -->
        <x-breadcrumb :course="$course"/>

        <!-- Video and list lession -->
        <div class="row py-3 px-0">
            <div class="col-12 col-md-4">
                <img src="{{$course->img}}" alt="" class="img-fluid">
            </div>

            <div class="col-12 col-md-8 my-5 my-md-0">
                <h3>Giới thiệu về khóa học</h3>
                <p>{{$course->name}}</p>
            </div>

            @if(!empty($course->lessions()->first()))
                <div class="col-12 mt-5">
                    <x-list-lession :course="$course"/>
                </div>
            @endif
        </div>

@endsection


