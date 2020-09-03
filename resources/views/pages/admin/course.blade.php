@extends('templade.dashboard')

@section('course')
    btn-primary
@endsection

@section('content')
    <h1>Quản lý khóa học</h1>
    <a class="btn btn-primary float-right mb-2" href="{{route('view-add-course')}}">Thêm khóa học</a>
    <table class="table table-hover table-dark">
        <thead>
        <tr>
            <th scope="col">Tên</th>
            <th scope="col">Số bài học</th>
            <th scope="col">Hình ảnh</th>
            <th scope="col">Thẻ</th>
            <th scope="col">Thể loại</th>
            <th scope="col">Lượt xem</th>
            <th scope="col">Lượt thích</th>
            <th scope="col">Tác giả</th>
            <th scope="col" style="min-width: 8rem;">Hành động</th>
        </tr>
        </thead>
        <tbody>
        @foreach( $courses as $course)
            <tr>
                <td>{{$course->name}}</td>
                <td>{{$course->lessions()->count()}}</td>
                <td>
                    <img src="{{$course->img}}" alt="" width="100" height="60">
                </td>
                <td>
                    @foreach($course->tags()->select('name')->get() as $tag)
                        <button class="btn btn-primary my-1 btn-sm text-lowercase">{{$tag->name}}</button>
                    @endforeach
                </td>
                <td>{{$course->category()->first('name')->name ?? "Web"}}</td>
                <td>{{$course->view ?? ''}}</td>
                <td>{{$course->like ?? ''}}</td>
                <td>
                    @if($course->crawl_url)
                        Crawl
                    @else
                        {{App\User::query()->find($course->user_id)->first()->name ?? 'admin'}}
                    @endif
                </td>
                <td style="min-width: 2rem">
                    <a href="{{route('view-lession', $course->id)}}"
                       class="btn btn-secondary btn-sm" title="Danh sách bài học">
                        <i class="far fa-eye"></i>
                    </a>
                    <a href="{{route('edit-course', $course->id)}}"
                       class="btn btn-secondary my-1 btn-sm" title="Sửa">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="{{route('remove-course', $course->id)}}" type="button"
                       class="btn btn-secondary btn-sm" title="Xóa">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="text-center">{{$courses->links()}}</div>
@endsection
