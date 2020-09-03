@extends('templade.dashboard')

@section('tag')
    btn-primary
@endsection

@section('content')
    <h3 class="mb-4">Quản lý thẻ</h3>

    <p>
        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
            Thêm
        </button>
    </p>

    <form action="{{route('admin-tag-add')}}" method="POST">
        @csrf
        <div class="collapse" id="collapseExample">
            <div class="form-group">
                <input type="text" class="form-control w-50" name="tag" aria-describedby="tag" placeholder="Nhập tên thẻ">

                @error('tag')
                    <small class="text-danger">Đã tồn tại hoặc chưa nhập</small>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">
                Xác nhận
            </button>
        </div>
    </form>

    <h4 class="mt-3">Cài đặt thẻ hiện lên trang chủ</h4>
    <form action="{{route('admin-tag-home')}}" method="POST">
        @csrf
        <div class="input-group w-50 mx-auto my-3">
            <select multiple class="custom-select" name="tag[]">
                @foreach($tags as $tag)
                    <option @if($tag->is_show) selected @endif value="{{$tag->id}}">{{$tag->name}}</option>
                @endforeach
            </select>

            <div>
                <button class="btn btn-outline-secondary" type="submit">Lưu thay đổi</button>
            </div>
        </div>
    </form>


    <h4 class="mt-3">Danh sách thẻ</h4>
    <table class="table table-hover table-dark overflow-auto mx-auto w-50">
        <thead>
        <tr>
            <th scope="col">Tên thẻ</th>
            <th scope="col">Số khóa học</th>
            <th scope="col" style="min-width: 7rem">Hành động</th>
        </tr>
        </thead>
        <tbody>
        @foreach($tags as $tag)
            <tr>
                <td>{{$tag->name}}</td>
                <td>{{$tag->courses_count}}</td>
                <td>
                    <a href="{{route('admin-tag-edit', $tag->id)}}"
                        class="btn btn-secondary btn-sm" title="Xóa">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>

        @endforeach

        </tbody>
    </table>
    <div class="text-center">{{$tags->links()}}</div>
@endsection
