<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class TagController extends Controller
{
    public function show()
    {
        $tags = Tag::query()->withCount('courses')->paginate(10);

        return view('pages.admin.tag', compact('tags'));
    }

    public function delete(Tag $tag)
    {
        try {
            $tag->delete();
            $tag->courses()->detach();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        return back();
    }

    public function add(Request $request)
    {
        $tags = Tag::query()->pluck('name');
        $request->validate([
            'tag' => ['required',
                Rule::notIn($tags)
            ]
        ]);

        try {
            Tag::query()->create([
                'name' => $request->input('tag')
            ]);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        return back();
    }

    public function showHome(Request $request)
    {
        $tagsRequest = $request->input('tag');

        $tags = Tag::query()->get();

        foreach ($tags as $tag) {
            // Neu tag nam trong tag yeu cau tu client

            if (in_array( $tag->id, $tagsRequest)) {
                echo $tag->id . '<br>';
                // Neu trang thai la 0 thi doi thanh 1
                if ($tag->is_show == 0) {
                $tag->update([
                    'is_show' => true
                ]);
                }
            } else {
                // Neu tag khong nam trong tag yeu cau thi chuyen het thanh 0
                // Neu dang la 1 thi moi chuyen, 0 thi thoi
                if ($tag->is_show == 1) {
                echo $tag->id . '.';
                $tag->update([
                    'is_show' => false
                ]);
                }
            }
        }

        return back();
    }
}
