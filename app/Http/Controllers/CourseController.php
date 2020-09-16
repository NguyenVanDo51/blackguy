<?php

namespace App\Http\Controllers;

use App\CourseUser;
use App\Models\Course;
use App\Models\Lession;
use App\Repositories\CourseRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    protected $courseRepository;

    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function show(Course $course)
    {
        try {
            $percent = 0;
            // Tinh % hoan thanh
            if (Auth::check()) {
                $is_finish = Auth::user()->lessions()
                    ->where('is_finish', 1)
                    ->where('course', $course->id)
                    ->count();
                $total = $course->lessions()->count();
                $percent = round(($is_finish / $total) * 100);
            }
        } catch (Exception $exception) {
            logger($exception);
        }

        return view('pages.sourse', compact('course', 'percent'));
    }

    public function searchWithCategory(Request $req)
    {
        $req->validate([
            'search' => 'required'
        ]);

        $option = $req->input('option');
        $search = $req->input('search');

        if ($option) {
            $courses = $this->courseRepository->searchWithCategory($search, $option);
        } else {
            $courses = $this->courseRepository->searchInAll($search);
        }

        return view('pages.search', compact('courses', 'search', 'courses'));
    }

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

    public function search(Request $request)
    {
        $courses = Course::query()
            ->where('name', 'like', '%' . $request->input('course_name') . '%')
//            ->where('name', 'like', '%web%')
            ->orderByDesc('created_at')
            ->paginate(10);

        $search = true;

        return view('pages.admin.course', compact('courses', 'search'));
    }
}
