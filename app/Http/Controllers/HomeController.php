<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\Tag;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    private $tags;
    private $courses;

    public function __construct()
    {
        try {
            $this->tags = app()->make('tag');
            $this->courses = app()->make('course');
        } catch (BindingResolutionException $e) {
        }
    }

    public function index()
    {
        try {
            return view('pages.home');
        } catch (Exception $exception) {
            dd($exception);
        }
    }
}
