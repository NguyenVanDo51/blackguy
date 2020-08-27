@props(['course'])
<a href="{{route('course', $course->id)}}">
    <div class="card course-item" style="height: 22rem;">
        <img class="card-img-top" src="{{$course->img ?? ""}}" alt="Card image cap">
        <div class="card-title m-3">{{$course->name}}</div>
        <div class="card-body mb-3 overflow-hidden">
            <p class="card-text">{{$course->description}}</p>
        </div>
        <div class="card-footer">Ngày tải lên: {{Str::substr($course->updated_at,0, 10) ?? "2020-08-18"}}</div>
    </div>
</a>
