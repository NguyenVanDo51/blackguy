@extends('templade.app')

@section('content')
    <!-- Top info -->
    <div class="container-fluid my-5">
        <div class="row bg-dark mb-5 p-4 text-light">
            <div class="col-2"></div>
            <div class="col-10">
                <h2>{{$course->name}}</h2>
                <p>Tác giả: {{ App\User::query()->findOrFail($course->user_id)->name ?? "Admin"}}</p>
                <span>Lượt thích: {{$course->like}}</span>
                <span class="mx-3">Lượt xem: {{$course->view}}</span>
                <span>Số bai hoc: {{$course->lessions()->count()}}</span>
                    <p class="pt-4">
                        @if($course->users()->get()->contains(Auth::user()))
                            <a href="{{ route('lession', ['course' => $course->id, 'lession' => $course->lessions()->first('id')->id]) }}"
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
            </div>
        </div>
    </div>
    <!-- End top info -->

    <!-- Content -->
    <div class="container">

        <!-- breadcrumb -->
        <x-breadcrumb :course="$course"/>

        <!-- Video and list lession -->
        <div class="row py-3 px-0">
            <div class="col-12 pl-0">
                @yield('img')
            </div>

            <div class="col-12 mt-3 ">
                <x-list-lession :course="$course" />
            </div>

            <div class="row">
                <div class="col-12">
                    @yield('infomation')
                </div>
            </div>
        </div>

@endsection
