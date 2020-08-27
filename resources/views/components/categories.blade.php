<div class="container-fluid border-info my-2 pb-5" style="border-top: 1px solid">
    <h3 class="mt-2">Danh mục</h3>
    @foreach(\App\Models\Category::all() as $category)
        <a href="{{ route('categories', $category->id) }}" class="btn btn-primary m-1 btn-sm">
            {{Str::upper($category->name)}}
            ({{$category->courses()->count()}})
        </a>
    @endforeach
</div>
