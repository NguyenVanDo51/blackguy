@props(['course', 'lession'])

    <h2>Sửa video {{$lession->lession}}-{{$lession->title}} trong khóa học '{{$course->name}}'</h2>

<div class="w-50 mx-auto">
    <form method="POST" action="{{route('add-lession', $course->id)}}">
        @csrf()
        <div class="form-group">
            <label for="lession">Số thứ tự (hiện tại)</label>
            <input type="number" class="form-control" value="{{ $lession->lession}}" id="lession" name="lession">
            @error('lession')
            <p class="text-danger">So thu tu trong hoac da ton tai</p>
            @enderror
        </div>
        <div class="form-group">
            <label for="title">Mô tả</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Mô tả bài học" value="{{$lession->title}}" />
        </div>

        <div class="form-group">
            <label for="category">Link video</label>
            <input type="text" class="form-control" id="video" name="video" value="{{$lession->video}}" placeholder="https://www.youtube.com/watch?v=...">
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Cập nhât</button>
        <a href="{{route('edit-lession', ['course' => $course->id, 'lession' => $lession->id ])}}" class="btn btn-primary">Hủy</a>
        @if ($errors->any())
            <div class="text-danger mt-3">
                Chú ý điền chính xác các thông tin
            </div>
        @endif
    </form>
</div>
