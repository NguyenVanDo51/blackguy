<div class="container-fluid border-info my-2" style="border-top: 1px solid">
    <h3 class="mt-2">Thẻ</h3>
    @foreach(\App\Models\Tag::query()->get() as $tag)
        <a href="{{ route('tags', $tag->id) }}" class="btn btn-primary m-1 btn-sm">
            {{Str::upper($tag->name)}}
            ({{$tag->courses()->count()}})
        </a>
    @endforeach
</div>
