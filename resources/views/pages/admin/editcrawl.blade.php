@extends('templade.dashboard')

@section('crawl')
    btn-primary
@endsection

@section('content')
    <h3>Crawl Khoa hoc</h3>
    <div class="my-3 mx-auto w-50">
        <form action="{{route('admin-crawl-edit', $job->id)}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="user">Nguoi thuc hien</label>
                <input type="text" class="form-control" id="user" readonly value="{{ App\User::query()->findOrFail($job->user_id)->name }}">
            </div>
            <div class="form-group">
                <label for="created_at">Thoi gian tao</label>
                <input type="text" class="form-control" id="created_at" readonly value="{{ $job->created_at }}">
            </div>
            <div class="form-group">
                <label for="updated_at">Nguoi thuc hien</label>
                <input type="text" class="form-control" id="updated_at" readonly value="{{ $job->updated_at }}">
            </div>
            <div class="form-group">
                <label for="url">Sửa url</label>
                <input type="text" class="form-control" id="url" name="url" placeholder="https://coderstape.com/..." value="{{ $job->url }}">

                @error('url')
                <small class="text-danger">Sai định dạng url hoặc url đã được crawl rồi!</small>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
        </form>
    </div>

@endsection
