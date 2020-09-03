<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessCourse;
use App\Models\Course;
use App\Models\Tag;
use App\User;
use DiDom\Element;
use DiDom\Exceptions\InvalidSelectorException;
use Illuminate\Http\Request;
use DiDom\Document;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CrawlController extends Controller
{

    public function show()
    {
        $jobs = DB::table('jobs')->get();
        $failed_jobs = DB::table('failed_jobs')->get();
//        dd(str_replace('\\', '', Str::between($jobs[0]->payload, 's:49:\"', '";s:7:')));
        return view('pages.admin.crawl', compact('jobs', 'failed_jobs'));
    }

    /**
     * @throws InvalidSelectorException
     * @var $title Element[]
     * @var $course Course
     */
    public function crawl(Request $request)
    {
        $urls = Course::query()->pluck('crawl_url');
        $request->validate([
            'url' => ['starts_with:https://coderstape.com/', Rule::notIn($urls)]
        ]);

        $url = $request->input('url');

        ProcessCourse::dispatch($url);

        return back();
    }

    public function remove($jod_id)
    {
        try {
            DB::table('jobs')->delete($jod_id);
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }

        return back();
    }

    public function failedRedispatch(Request $request)
    {
        $url = 'https://' . $request->url;
        $job_id = $request->job;

        ProcessCourse::dispatch($url);

        try {
            DB::table('failed_jobs')->delete($job_id);
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
        return back();
    }

    public function failedRemove($jod_id)
    {
        try {
            DB::table('failed_jobs')->delete($jod_id);
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
        return back();
    }


}
