<?php

namespace App\Http\Controllers;

use App\CourseUser;
use App\Models\Course;
use App\Models\Lession;
use App\Repositories\LessionRepository;
use Illuminate\Support\Facades\Auth;

class LessionController extends Controller
{
    protected $lessionRepository;

    public function __construct(LessionRepository $repository)
    {
        $this->lessionRepository = $repository;
    }

    public function show(Course $course, Lession $lession)
    {
        // Neu nguoi dung chua dang ki hoc => dang ki
        try {
            if (!$course->users()->get()->contains(Auth::user())) {
                $course->users()->attach(Auth::id());
            }

            // Cap nhat video duoc xem cuoi cung
            CourseUser::query()->where('user_id', Auth::id())
                ->where('course_id', $course->id)
                ->update([
                    'latest' => $lession->id
                ]);
        } catch (\Exception $exception) {
            logger([
                'Error when attach course -> user' => $exception->getMessage()
            ]);
        }

        $this->lessionRepository->attachLesionLatest($course, $lession);

        return view('pages.lession', compact('course', 'lession'));
    }
}
