@props(['course'])
<a href="{{route('course', $course->id)}}">
    <div class="card course-item" style="height: 22rem; color: black;">
        <img class="card-img-top" src="{{$course->img ?? ""}}" alt="Card image cap" style="height: 9rem;">

        <div class="card-body overflow-hidden mb-2">
            <div class="card-title">{{$course->name}}</div>
            <p class="card-text mb-2">{{$course->description}}</p>
        </div>
        <div class="card-footer m-0">Ngày tải lên: {{Str::substr($course->updated_at,0, 10) ?? "2020-08-18"}}</div>
    </div>
</a>
