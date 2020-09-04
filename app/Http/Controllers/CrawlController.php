<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessCrawlJob;
use App\ProcessCrawl;
use App\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CrawlController extends Controller
{
    public function index()
    {
        $jobs = ProcessCrawl::query()->orderByDesc('id')->paginate(10);
        return view('pages.admin.crawl', compact('jobs'));
    }

    /**
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function create(Request $request)
    {
        $urls = ProcessCrawl::query()->pluck('url');
        $request->validate([
            'url' => ['starts_with:https://coderstape.com/',
                Rule::notIn($urls)]
        ]);

        $user = User::query()->findOrFail(Auth::id());

        $job = $user->processCrawl()->create([
            'url' => $request->input('url'),
            'user_id' => Auth::id(),
            'status' => ProcessCrawl::STATUS_PENDING
        ]);

        // Day vao queue
        ProcessCrawlJob::dispatch($job);

        return back();
    }

    public function destroy($processCrawl)
    {
        try {
            ProcessCrawl::query()->findOrFail($processCrawl)->delete();
        } catch (Exception $e) {
            logger($e->getMessage() . $e->getTraceAsString());
        }

        return back();
    }

    public function update($job_id)
    {
        try {
            $crawlJob = ProcessCrawl::query()->findOrFail($job_id);
            ProcessCrawlJob::dispatch($crawlJob);
        } catch (Exception $e) {
            dd($e);
        }
        return back();
    }

    public function show($job_id)
    {
        try {
            $job = ProcessCrawl::query()->findOrFail($job_id);
            return view('pages.admin.editcrawl', compact('job'));
        } catch (Exception $exception) {
            dd($exception);
        }
    }

    public function edit(Request $request, $job_id)
    {
        try {
            $urls = ProcessCrawl::query()->pluck('url');
            $request->validate([
                'url' => ['starts_with:https://coderstape.com/',
                    Rule::notIn($urls)]
            ]);

            // Sua thong tin
            $crawlJob = ProcessCrawl::query()->findOrFail($job_id);

            $crawlJob->update([
                'url' => $request->input('url')
            ]);

        } catch (Exception $exception) {
            logger($exception);
        }

        return redirect()->route('admin-crawl-view');
    }

}
