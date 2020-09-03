<div class="container-fluid">
    @foreach($courses as $course)
        <a class="row mt-3" style="max-height: {{$height}}rem;" href="{{route('course', $course->id )}}">
            <div class="col-3">
                <img class="img-fluid" src="{{$course->img}}" alt="">
            </div>
            <div class="col-8">
                <h5>{{$course->name}}</h5>
                <p>{{$course->description}}</p>
                <div>
                    <span>Views: {{$course->view}}</span>
                    <span class="mr-3">Likes: {{$course->like}}</span>
                    <p>Tác giả: {{\App\User::query()->findOrFail($course->user_id)->name ?? "admin"}}</p>
                </div>
            </div>
        </a>
    @endforeach
</div>
