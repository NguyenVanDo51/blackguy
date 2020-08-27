<?php

namespace App\Http\Controllers;

use App\CourseUser;
use App\LessionUser;
use App\Models\Category;
use App\Models\Course;
use App\Models\Lession;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function lession(Course $course, Lession $lession)
    {

        // Neu nguoi dung chua dang ki hoc => dang ki
        if (!$course->users()->get()->contains(Auth::user())) {
            $course->users()->attach(Auth::id());
        }

        // them thong tin nguoi dung da xem video nay
        if (!$lession->users()->get()->contains(Auth::user())) {
            $lession->users()->attach(Auth::id(), [
                'course' => $course->id
            ]);
        };

        // Cap nhat video duoc xem cuoi cung
        CourseUser::query()->where('user_id', Auth::id())
            ->where('course_id', $course->id)
            ->update([
                'latest' => $lession->id
            ]);

        return view('pages.lession', compact('course', 'lession'));
    }

    public function tags(Tag $tag)
    {
        $courses = $tag->courses()->paginate(5);

        return view('pages.tag', [
            'courses' => $courses,
            'tag' => $tag
        ]);
    }

    public function categories(Category $category)
    {
        $courses = $category->courses()->paginate(5);

        return view('pages.category', [
            'courses' => $courses,
            'category' => $category
        ]);
    }
}
