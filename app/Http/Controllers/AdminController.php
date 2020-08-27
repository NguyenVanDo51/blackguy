<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\Lession;
use App\Models\Tag;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function messages()
    {
        return [
            'title.required' => 'Phần mô tả là bắt buộc',
            'name.required' => 'Tên khóa học chưa được nhập',
        ];
    }

    public function dashboard($function = 'dashboard', Course $course, Lession $lession)
    {
        try {
            $courses = Course::query()->orderByDesc('created_at')->paginate(10);
            $tags = Tag::query()->get();
            $categories = Category::query()->get();
        } catch (Exception $exception) {
            echo $exception;
        }

        return view('pages.admin.dashboard', compact('function', 'courses', 'tags', 'categories', 'course', 'lession'));
    }

    public function addCourse(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'img' => 'required',
            'tags' => 'required',
            'category' => 'required',
            'title' => 'required'
        ]);

        $name = $request->name;
        $img = $request->img;
        $tags_id = $request->tags;
        $categogy = $request->category;
        $title = $request->title;

        // Them khoa hoc tu category model de tao su lien ket
        $course = Category::query()->findOrFail($categogy)->courses()->create([
            'name' => $name,
            'img' => $img,
            'description' => $title,
            'user_id' => Auth::id()
        ]);

        // attach khoa hoc va tag
//        foreach ($tags_id as $tag_id) {
        Tag::query()->findMany($tags_id)->each(function ($tag) use ($course) {
            $tag->courses()->attach($course->id);
        });
//        }

        return redirect()->route('admin', 'course');
    }

    /**
     * Xoa course
     */

    public function removeCourse(Course $course)
    {
        try {
            // detach cac tag
            $course->tags()->detach();
            $course->delete();
        } catch (Exception $exception) {
            echo $exception;
        }

        return redirect()->back();
    }

    /**
     * Show form Sua course
     */

    public function editCourse()
    {
        return redirect()->route('admin', 'edit-course');
    }

    /**
     * Xu ly sua course
     */

    public function handleEditCourse(Request $request, Course $course)
    {
        $request->validate([
            'name' => 'required',
            'img' => 'required',
            'tags' => 'required',
            'category' => 'required',
            'title' => 'required'
        ]);

        $name = $request->name;
        $img = $request->img;
        $tags = $request->tags;
        $categogy = $request->category;
        $title = $request->title;

        // neu category khong thay doi
        $course->update([
            'name' => $name,
            'img' => $img,
            'category_id' => $categogy,
            'description' => $title,
            'user_id' => Auth::id()
        ]);


        $course->tags()->sync($tags);

        // attach khoa hoc va tag
//        Tag::query()->findMany($tags_id)->each(function ($tag) use ($course) {
//            $tag->courses()->attach($course->id);
//        });
//        }

        return redirect()->route('admin', 'course');
    }

    /**
     * Them lession
     */

    public function addLession(Request $request, Course $course)
    {

        $lessions_avai = $course->lessions()->pluck('lession')->toArray();

        $request->validate([
            'lession' => ['required', Rule::notIn($lessions_avai)],
            'title' => 'required',
            'video' => 'starts_with:https://www.youtube.com/watch?v='
        ]);

        $course->lessions()->create([
            'lession' => $request->lession,
            'title' => $request->title,
            'video' => $request->video
        ]);
        return redirect()->route('admin', ['function' => 'lession', 'course' => $course->id]);
    }

    /**
     * Xoa lession
     */
    public function removeLession(Lession $lession)
    {
        $course_id = $lession->course_id;
        $lession->delete();
        $lession->users()->detach();
        return redirect()->route('admin', ['function' => 'lession', 'course' => $course_id]);
    }

    /**
     * Sua lession
     */
    public function handleEditLession(Request $request, Course $course, Lession $lession)
    {
        $lessions_avai = $course->lessions()->pluck('lession')->toArray();

        $request->validate([
            'lession' => ['required', Rule::notIn($lessions_avai)],
            'title' => 'required',
            'video' => 'starts_with:https://www.youtube.com/watch?v='
        ]);

        $lession->update([
            'lession' => $request->lession,
            'title' => $request->title,
            'video' => $request->video
        ]);

        $lession->users()->detach();
    }

}
