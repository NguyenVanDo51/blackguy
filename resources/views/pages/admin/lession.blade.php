@extends('templade.dashboard')
@section('course')
    btn-primary
@endsection
@section('content')
{{--    {{dd($lessions)}}--}}

<h3>Các bài học trong khóa {{$course->name}}</h3>
<a class="btn btn-primary float-right mb-2" href="{{route('view-add-lession', $course->id)}}">Thêm</a>

<table class="table table-hover table-striped">
    <thead>
    <tr>
        <th scope="col">Bài</th>
        <th scope="col">Tiêu đề</th>
        <th scope="col">Link video</th>
        <th scope="col">Ngày thêm</th>
        <th scope="col" style="min-width: 7rem">Hành động</th>
    </tr>
    </thead>
    <tbody>
    @foreach($lessions as $lession)
        <tr>
            <td>{{$lession->lession}}</td>
            <td>{{$lession->title}}</td>
            <td>{{$lession->video}}</td>
            <td>{{$lession->created_at}}</td>
            <td style="min-width: 2rem">
                <a href="{{route('edit-lession', ['course' => $course->id, 'lession' => $lession->id])}}"
                    class="btn btn-secondary my-1 btn-sm" title="Sửa">
                    <i class="fas fa-edit"></i>
                </a>
                <a href="{{route('remove-lession', $lession->id)}}"
                    class="btn btn-secondary btn-sm" title="Xóa">
                    <i class="fas fa-trash"></i>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="text-center">{{$lessions->links()}}</div>
@endsection
