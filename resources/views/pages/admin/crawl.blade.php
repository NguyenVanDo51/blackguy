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

    <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th scope="col">Url</th>
            <th scope="col">Người dùng</th>
            <th scope="col">Thời gian tạo</th>
            <th scope="col">Thời gian kết thúc</th>
            <th scope="col">Trạng thái</th>
            <th scope="col">Lỗi</th>
            <th scope="col" style="min-width: 7rem">Hành động</th>
        </tr>
        </thead>
        <tbody>
        @foreach($jobs as $job)
            <tr style="max-height: 3rem; overflow: auto">
                <td>{{ $job->url }}</td>
                <td>{{ App\User::query()->findOrFail($job->user_id)->name }}</td>
                <td>{{ $job->created_at }}</td>
                <td>{{ $job->updated_at }}</td>

                <td class="@switch($job->status)
                    @case(App\ProcessCrawl::STATUS_PENDING)
                        text-secondary
                        @break
                    @case(App\ProcessCrawl::STATUS_COMPLETED)
                        text-success
                    @break
                    @case(App\ProcessCrawl::STATUS_PROCESSING)
                        text-primary
                    @break
                    @case(App\ProcessCrawl::STATUS_FAILED)
                        text-danger
                    @break
                    @endswitch
                    "
                    >{{ $job->status }}</td>
                <td class="d-flex overflow-auto" style="max-height: 7rem; max-width: 12rem">{{ $job->error }}</td>
                <td>
                    @if( $job->status == App\ProcessCrawl::STATUS_FAILED)
                        <a href="{{route('admin-crawl-failed-redispatch', $job->id)}}"
                        class="btn btn-secondary btn-sm">
                            <i class="fas fa-sync"></i>
                        </a>
                    @elseif( $job->status == App\ProcessCrawl::STATUS_PENDING)
                        <a href="{{route('admin-crawl-show', $job->id)}}"
                           class="btn btn-secondary btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                    @endif
                    <a href="{{ route('admin-crawl-remove', $job->id) }}"
                       class="btn btn-secondary my-1 btn-sm ">
                        <i class="fas fa-times"></i>
                    </a>
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
    <div>{{$jobs}}</div>
@endsection
