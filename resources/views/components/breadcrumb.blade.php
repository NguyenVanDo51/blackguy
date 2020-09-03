@props(['course'])

<div class="row text-primary align-items-center my-4">
    <div>
        <i class="fas fa-home"></i>
        <i class="fas fa-chevron-right mx-2"></i>
        <a href="{{route('categories', $course->category->id ?? 1)}}">{{$course->category->name ?? ""}}</a>
        <i class="fas fa-chevron-right mx-2"></i>
        <a href="{{route('tags', $course->tags()->first()->id ?? 1)}}">{{$course->tags()->first()->name ?? ""}}</a>
        <i class="fas fa-chevron-right mx-2"></i>
        <a href="{{route('course', $course->id)}}">{{$course->name}}</a>
    </div>

</div>
