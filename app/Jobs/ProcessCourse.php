<?php

namespace App\Jobs;

use App\Models\Course;
use App\Models\Tag;
use DiDom\Document;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Throwable;

class ProcessCourse implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $url;

    public $timeout = 500;

    public $maxExceptions = 3;

    /**
     * Create a new job instance.
     * @var $document Document
     * @return void
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * Execute the job.
     * @return void
     * @throws \DiDom\Exceptions\InvalidSelectorException
     * @var $document Document
     * @var $course Course
     */
    public function handle()
    {
        $document = new Document($this->url, true);
        $name = $document->first('h1 > .text-gray-200');

        $description = $document->first('.pt-4.flex.flex-col.justify-between>div');

        // Hinh anh
        $imgs = $document->first('img')->getAttribute('src');

        $course = Course::query()->create([
        'name' => Str::of($name->text())->trim(),
        'description' => Str::of($description->text())->trim(),
        'img' => $imgs,
        'crawl_url' => $this->url
        ]);

        $tagsSearch = $document->first('.mt-2.flex.items-center');

        $tagsCurrent = Tag::query()->pluck('name')->toArray();

        $tags = [];

        // Lay ra toan bo cac tag cua course
        foreach($tagsSearch->children() as $tag) {
            $str = Str::of($tag->text())->trim();
            if(!in_array($str, $tags)
                && $str != ""
                && $str != "TOPICS"
            ) {
                array_push($tags, $str);
            }
        }

        // attach course voi tag
        foreach($tags as $tag) {
            // neu chua ton tai tag thi them moi
            if(!in_array(strtoupper($tag), $tagsCurrent)){
                $tagCurrnet =Tag::query()->create([
                    'name' => strtoupper($tag)
                ]);
                $tagCurrnet->courses()->attach($course->id);
            } else {
                // Neu da ton tai roi
                $tagCurrent = Tag::query()->where('name', strtoupper($tag))->firstOrFail();
//                dd($tagCurrent);
                $tagCurrent->courses()->attach($course->id);
            }
        }

        // Get ra danh sach cac bai hoc
        $lessions = $document->find('.max-w-6xl.flex.justify-center.flex-wrap div a');

        foreach ($lessions as $index => $lession) {
            $href = $lession->attr('href');

            $documentLession = new Document($href, true);
            $title =  $documentLession->first('h1 div.ml-4');
            $video = $documentLession->first('meta[property=\'og:video\']');
            $video = $video->getAttribute('content');

            $user_id = Auth::id();

            $course->lessions()->create([
                'user_id' => $user_id,
                'lession' => $index,
                'title' => $title->text(),
                'video' => Str::replaceFirst('v/', 'watch?v=', $video)
            ]);
        }
    }

    public function failed(Throwable $exception)
    {
        // Send user notification of failure, etc...
        echo 'Job Failed!';
    }

     /**
     * @return mixed
     */public function getUrl()
    {
        return $this->url;
    }
}
