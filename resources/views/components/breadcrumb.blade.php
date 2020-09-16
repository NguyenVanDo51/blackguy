@props(['course'])

<div class="row text-primary align-items-center my-4">
    <div>
        <i class="fas fa-home"></i>
        <i class="fas fa-chevron-right mx-2"></i>
        <a href="{{route('category.show', $course->category->id ?? 1)}}">{{$course->category->name ?? ""}}</a>
        <i class="fas fa-chevron-right mx-2"></i>
        <a href="{{route('tag.show', $course->tags()->first()->id ?? 1)}}">{{$course->tags()->first()->name ?? ""}}</a>
        <i class="fas fa-chevron-right mx-2"></i>
        <a href="{{route('course.show', $course->id)}}">{{$course->name}}</a>
    </div>

</div>
