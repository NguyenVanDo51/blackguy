@props(['course'])
<!-- Video and list lession -->
<div class="py-3 bg-primary text-light px-3 align-middle">
    <i class="fas fa-bars mr-3 font-weight-bold" style="font-size: 1.2rem"></i>
    <h4 class="d-inline m-0">Danh sách bài học</h4>
</div>

<div class="mt-3 overflow-auto" style="height: 20rem">
    @foreach($course->lessions()->get() as $item)

        @if(Str::contains(url()->current(), '/lession/') && $item->id == class_basename(url()->current()))
            <div class="py-3 px-3 lession bg-primary">
        @else
            <div class="py-3 px-3 lession">
        @endif
            <a style="color: black;"
               href="{{route('lession.index', ['course' => $course->id, 'lession' => $item->id])}}">
                <span class="ml-2">{{$loop->index + 1}}.</span>
                {{$item->title}}
            </a>
        </div>
    @endforeach
            </div>
</div>
