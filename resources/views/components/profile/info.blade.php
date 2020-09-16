<div class="card">
    <div class="card-header bg-secondary">
        <h3>Thông tin hồ sơ</h3>
    </div>
    <div class="p-3 info">
        <h5>Thông tin</h5>
        <p>
            <i class="fas fa-user mr-2"></i>
            {{Auth::user()->name}}
        @can('admin')
            <span class="font-weight-bold">(Admin)</span>
        @endcan
        </p>
        <p><i class="far fa-envelope mr-2"></i>{{Auth::user()->email}}</p>
        <p><i class="fas fa-table mr-2"></i></i>{{Auth::user()->created_at}}</p>

    </div>
    <div class="p-3">
        <h5>Học tập ({{Auth::user()->loadCount('courses')->courses_count ?? '0'}})</h5>
        <div class="container-fluid">
            <div class="row">
                <div class="card-group my-3">
                    @foreach(Auth::user()->courses()->get() as $course)
                        <div class="col-3 my-3">
                            <a href="{{route('course.show', $course->id)}}" class="text-dark">
                                <img class="card-img-top" src="{{$course->img ?? ""}}" alt="Card image cap">
                                <div class="card-text m-1">{{$course->name}}</div>
                                <div class="card-text bg-secondary text-light pl-1">
                                    <p>Hoàn thành: 0%</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
