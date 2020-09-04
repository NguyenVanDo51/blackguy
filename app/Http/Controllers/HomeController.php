<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\Tag;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        try {
            return view('pages.home', $this->getData());
        } catch (Exception $exception) {
            echo $exception;
        }
    }

    protected function getData()
    {
        return [
            'categories' => Category::query()->with('tags')->get(),
            'tags'       => Tag::query()->where('is_show', 1)->get()
        ];
    }

    public function search(Request $req)
    {
        $req->validate([
            'search' => 'required'
        ]);

        $option = $req->input('option');
        $search = $req->input('search');

        $data           = $this->getData();
        $data['option'] = $option;
        $data['search'] = $search;

        if ($option == null) {
            // tim kiem khoa hoc tren tat ca the loai
            try {
                $data['courses'] = Course::where('name', 'like', '%'.$search.'%')
                    ->paginate(4);
            } catch (Exception $e) {
                logger('Exception when search', [
                    'exception' => $e
                ]);
                abort(500);
            }

        } else {
            // Tim kiem co the loai
            try {
                $category = Category::query()->findOrFail($option);

                $data['courses'] = $category->courses()->where('name', 'like', '%'.$search.'%')->paginate(4);
            } catch (Exception $e) {
                logger('Exception when search', [
                    'exception' => $e
                ]);
                abort(500);
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
                $total     = $course->lessions()->count();
                $percent   = round(($is_finish / $total) * 100);
            }
        } catch (Exception $exception) {
            logger($exception);
        }

        return view('pages.sourse', compact('course', 'percent'));
    }
}
