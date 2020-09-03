@extends('templade.dashboard')
@section('course')
    btn-primary
@endsection
@section('content')
<div class="w-50 mx-auto">
    <form method="POST" action="{{route('add-course')}}">
        @csrf()
        <div class="form-group">
            <label for="name">Tên khóa học</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Nhập tên khóa học">
        </div>
        <div class="form-group">
            <label for="img">Hình ảnh (url)</label>
            <input type="text" class="form-control" id="img" name="img" placeholder="Url hình ảnh">
        </div>

        <div class="form-group">
            <label for="category">Danh mục</label>
            <select class="custom-select" id="category" name="category">
                @foreach(App\Models\Category::query()->get() as $category)
                    <option class="text-uppercase" value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="tags">Thẻ (Nhấn giữ ctrl khi chọn để chọn nhiều mục)</label>
            <select multiple class="form-control" id="tags" name="tags[]">
                @foreach(App\Models\Tag::query()->get() as $tag)
                    <option class="text-uppercase" value="{{$tag->id}}">{{$tag->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="title">Mô tả ngắn (tối đa 200 kí tự)</label>
            <textarea class="form-control" name="title" id="title" maxlength="200" rows="2"></textarea>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Thêm</button>
        <a href="{{route('admin', 'course')}}" class="btn btn-primary">Hủy</a>
        @if ($errors->any())
            <div class="text-danger mt-3">
                Cần điền đây đủ thông tin
            </div>
        @endif
    </form>
</div>

@endsection
