@props(['course'])

<div class="w-50 mx-auto">
    <form method="POST" action="{{route('add-lession', $course->id)}}">
        @csrf()
        <div class="form-group">
            <label for="lession">Số thứ tự (mac dinh la bai ke tiep)</label>
            <input type="number" class="form-control" value="{{ $course->lessions()->max('lession') + 1}}" id="lession" name="lession">
            @error('lession')
                <p class="text-danger">So thu tu trong hoac da ton tai</p>
            @enderror
        </div>
        <div class="form-group">
            <label for="title">Mô tả</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Mô tả bài học">
        </div>

        <div class="form-group">
            <label for="category">Link video</label>
            <input type="text" class="form-control" id="video" name="video" placeholder="https://www.youtube.com/watch?v=...">
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Thêm</button>
        <a href="{{route('admin', ['function' => 'add-lession', 'course' => $course->id])}}" class="btn btn-primary">Hủy</a>
        @if ($errors->any())
            <div class="text-danger mt-3">
                Chú ý điền chính xác các thông tin
            </div>
        @endif
    </form>
</div>
