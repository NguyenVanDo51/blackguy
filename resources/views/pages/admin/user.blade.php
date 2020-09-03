@extends('templade.dashboard')

@section('user')
    btn-primary
@endsection

@section('content')
    <h3>Danh sách người dùng đã đăng ký</h3>
    <div class="my-3">
        <form action="{{route('admin-user-search')}}" method="GET" class="form-inline">
            <input type="text" class="form-control " id="search" name="search" value="{{$search ?? ""}}">
            <button type="submit" class="btn btn-primary mx-2"><i class="fas fa-search"></i></button>
            @if(!empty($search))
                <a href="{{route('admin-user-list')}}" type="button" class="btn btn-danger"><i class="fas fa-times"></i></a>
            @endif
        </form>
    </div>
    <table class="table table-hover table-dark">
        <thead>
        <tr>
            <th scope="col">Tên</th>
            <th scope="col">Email</th>
            <th scope="col">Vai trò</th>
            <th scope="col">Ngày đăng ký</th>
            <th scope="col">Số khóa học</th>
            <th scope="col" style="min-width: 7rem">Hành động</th>
        </tr>
        </thead>
        <tbody>
        @each('eaches.user', $users, 'user')
        </tbody>
    </table>
    <div class="text-center my-3">{{$users->links()}}</div>
@endsection
