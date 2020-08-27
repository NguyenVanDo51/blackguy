@props(['course'])
<!-- Video and list lession -->
<div class="py-3 bg-primary text-light px-3 align-middle">
    <i class="fas fa-bars mr-3 font-weight-bold" style="font-size: 1.2rem"></i>
    <h4 class="d-inline m-0">Danh sách bài học</h4>
</div>

<div class="mt-3 overflow-auto bg-dark" style="height: 20rem">
    @foreach($course->lessions()->get() as $item)

        @if(Str::contains(url()->current(), '/lession/') && $item->id == class_basename(url()->current()))
            <div class="py-3 px-3 lession bg-primary">
                @else
                    <div class="py-3 px-3 lession">
                        @endif
                        <a class="text-light"
                           @auth
                           @if(\Illuminate\Support\Facades\Auth::user()->courses()->where('course_id', $course->id)->exists())
                           href="{{route('lession', ['course' => $course->id, 'lession' => $item->id])}}">
                            @endif
                            @endauth
                            <span class="ml-2">{{$loop->index + 1}}.</span>
                            {{$item->name}}
                        </a>
                    </div>

                    @endforeach
            </div>
</div>
