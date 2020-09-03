@extends('templade.dashboard')

@section('crawl')
    btn-primary
@endsection

@section('content')
    <h3>Crawl Khoa hoc</h3>
    <div class="my-3 mx-auto w-50">
        <form action="{{route('admin-crawl-handle')}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="url">URL</label>
                <input type="text" class="form-control " id="url" name="url" placeholder="https://coderstape.com/...">

                @error('url')
                <small class="text-danger">Sai định dạng url hoặc url đã được crawl rồi!</small>
                @enderror

            </div>
            <button type="submit" class="btn btn-primary">Crawl</button>
        </form>
    </div>

    <table class="table table-hover table-dark">
        <thead>
        <tr>
            <th scope="col">Url</th>
            <th scope="col">Ngoại lệ</th>
            <th scope="col">Kết thúc lúc</th>
            <th scope="col">Trạng thái</th>
            <th scope="col" style="min-width: 7rem">Hành động</th>
        </tr>
        </thead>
        <tbody>
        @foreach($jobs as $job)
            <tr>
{{--                <td>{{Str::between(str_replace('\\', '', $jobs[0]->payload), 'https://', '";s:7:') ?? "Lỗi"}}</td>--}}
                @php
                    $url = Str::between(str_replace('\\', '', $job->payload), 'https://', '";s:7:');
                @endphp
                <td>{{$url ?? "Lỗi"}}</td>

                <td></td>
                <td></td>
                <td class="text-primary">Đang thực hiện</td>

                <td>
                    <a href="{{route('admin-crawl-remove', $job->id)}}"
                        class="btn btn-secondary my-1 btn-sm "
                        title="Đổi mật khẩu">
                        <i class="fas fa-times"></i>
                    </a>
                </td>
            </tr>
        @endforeach

        @foreach($failed_jobs as $job)
            <tr>
                @php
                    $url = Str::between(str_replace('\\', '', $job->payload), 'https://', '";s:7:');
                @endphp
                <td>https://{{$url ?? "Lỗi"}}</td>
                <td>{{Str::limit($job->exception, 50) ?? ""}}</td>
                <td>{{$job->failed_at ?? ""}}</td>
                <td>Thất bại</td>

                <td>
                    <form action="{{route('admin-crawl-failed-redispatch')}}" method="POST" style="display: inline">
                        @csrf
                        <input type="text" class="d-none" value="{{$job->id}}" name="job">
                        <input type="text" class="d-none" value="{{$url}}" name="url">
                        <button type="submit"
                                class="btn btn-secondary my-1 btn-sm "
                                title="Thử lại">
                            <i class="fas fa-sync"></i>
                        </button>
                    </form>


                    <a href="{{route('admin-crawl-failed-remove', $job->id)}}"
                        class="btn btn-secondary btn-sm" title="Xóa">
                        <i class="fas fa-times"></i>
                    </a>
                </td>
            </tr>

        @endforeach

        </tbody>
    </table>
@endsection
