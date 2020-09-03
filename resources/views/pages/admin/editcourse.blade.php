@extends('templade.dashboard')
@section('course')
    btn-primary
@endsection
@section('content')
    <div class="w-50 mx-auto mb-3">
        <form method="POST" action="{{route('handle-edit-course', $course->id)}}">
            @csrf()
            <div class="form-group">
                <label for="name">Tên khóa học</label>
                <input type="text" class="form-control" id="name" name="name" value="{{$course->name}}">
            </div>
            <div class="form-group">
                <label for="img">Hình ảnh (url)</label>
                {{--            <input type="file" class="form-control-file" id="img" name="img">--}}
                <input type="text" class="form-control" id="img" name="img" value="{{$course->img}}">
                <img src="{{$course->img}}" alt="" class="img-fluid my-2">
            </div>
            {{--        {{dd($course->tags()->select('name')->get(), $tags)}}--}}
            <div class="form-group">
                <label for="tags">Thẻ (Nhấn giữ ctrl khi chọn để chọn nhiều mục)</label>
                <select multiple class="form-control" id="tags" name="tags[]">
                    @foreach($tags as $tag)
                        <option
                            @if($course->tags()->get()->contains($tag)) selected @endif
                        class="text-uppercase" value="{{$tag->id}}">{{$tag->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="category">Danh mục</label>
                <select class="custom-select" id="category" name="category">
                    @foreach($categories as $category)
                        <option
                            @if($category == $course->category) selected @endif
                        class="text-uppercase" value="{{$category->id}}">{{$category->name}}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="title">Mô tả ngắn (tối đa 200 kí tự)</label>
                <textarea class="form-control" name="title" id="title" maxlength="200"
                          rows="2">{{$course->description}}</textarea>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Cập nhật</button>
            <a href="{{route('admin', $course->id)}}" class="btn btn-primary">Hủy</a>

            @if ($errors->any())
                <div class="text-danger mt-3">
                    Cần điền đây đủ thông tin
                </div>
            @endif
        </form>
    </div>
@endsection
