<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\Tag;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use mysql_xdevapi\Exception as ExceptionAlias;

class HomeController extends Controller
{
    public $data;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        try {
            $categories = Category::query()->with('tags')->get();
            // Lay ra tat ca cac tag co is_show = 1 de hien thi ra trang chu
            $tags = Tag::query()->where('is_show', 1)->get();
            $this->data = [
                'categories' => $categories,
                'tags' => $tags
            ];

        } catch (ExceptionAlias $exception) {
            echo $exception;
        }

    }

    public function index()
    {
        return view('pages.home', $this->data);
    }

    public function search(Request $req)
    {
        $req->validate([
            'search' => 'required'
        ]);

        $option = $req->input('option');
        $search = $req->input('search');

        $data = Arr::add($this->data, 'option', $option);
        $data = Arr::add($data, 'search', $search);

        if ($option == null) {
            // tim kiem khoa hoc tren tat ca the loai
            try {
                $result = Course::where('name', 'like', '%' . $search . '%')
                    ->paginate(4);
                $data = Arr::add($data, 'courses', $result);
            } catch (Exception $e) {
                return $e;
            }

        } else {
            // Tim kiem co the loai
            try {
//
                $category = Category::query()->findOrFail($option);

                $result = $category->courses()->where('name', 'like', '%' . $search . '%')->paginate(4);

                $data = Arr::add($data, 'courses', $result);
            } catch (Exception $e) {
                return $e;
            }
        }

        return view('pages.search', $data);
    }

    public function viewCourse(Course $course)
    {
        try {
            $course->with(['lessions', 'tags'])->get();
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
}
