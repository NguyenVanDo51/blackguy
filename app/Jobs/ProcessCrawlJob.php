<?php

namespace App\Jobs;

use App\Models\Course;
use App\Models\Tag;
use App\ProcessCrawl;
use DiDom\Document;
use DiDom\Exceptions\InvalidSelectorException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class ProcessCrawlJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public ProcessCrawl $processCrawl;

    /**
     * Create a new job instance.
     *
     * @param ProcessCrawl $processCrawl
     */
    public function __construct(ProcessCrawl $processCrawl)
    {
        $this->processCrawl = $processCrawl;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws InvalidSelectorException
     */
    public function handle()
    {
        if ($this->processCrawl->status != ProcessCrawl::STATUS_PENDING &&
            $this->processCrawl->status != ProcessCrawl::STATUS_FAILED) {
            logger('Ignore not pending Task');
            return;
        }

        try {
            $this->processCrawl->update([
                'status' => ProcessCrawl::STATUS_PROCESSING
            ]);

            $document = new Document($this->processCrawl->url, true);

            $name = $document->first('h1 > .text-gray-200');
            $description = $document->first('.pt-4.flex.flex-col.justify-between>div');
            $img = $document->first('img')->getAttribute('src');

            $course = Course::query()->create([
                'user_id' => $this->processCrawl->user_id,
                'name' => Str::of($name->text())->trim(),
                'description' => Str::of($description->text())->trim(),
                'img' => $img,
                'crawl_url' => $this->processCrawl->url
            ]);

            $tagsSearch = $document->first('.mt-2.flex.items-center');

            $tagsCurrent = Tag::query()->pluck('name')->toArray();

            $tags = [];

            // Lay ra toan bo cac tag cua course
            foreach ($tagsSearch->children() as $tag) {
                $str = Str::of($tag->text())->trim();
                if (!in_array($str, $tags)
                    && $str != ""
                    && $str != "TOPICS"
                ) {
                    array_push($tags, $str);
                }
            }

            // attach course voi tag
            foreach ($tags as $tag) {
                // neu chua ton tai tag thi them moi
                if (!in_array(strtoupper($tag), $tagsCurrent)) {
                    $tagCurrnet = Tag::query()->create([
                        'name' => strtoupper($tag)
                    ]);
                    $tagCurrnet->courses()->attach($course->id);
                } else {
                    // Neu da ton tai roi
                    $tagCurrent = Tag::query()->where('name', strtoupper($tag))->firstOrFail();
                    $tagCurrent->courses()->attach($course->id);
                }
            }

            // Get ra danh sach cac bai hoc
            $lessions = $document->find('.max-w-6xl.flex.justify-center.flex-wrap div a');

            foreach ($lessions as $index => $lession) {
                $href = $lession->attr('href');

                $documentLession = new Document($href, true);
                $title = $documentLession->first('h1 div.ml-4');
                $video = $documentLession->first('meta[property=\'og:video\']');
                $video = $video->getAttribute('content');

                $course->lessions()->create([
                    'lession' => $index,
                    'title' => $title->text(),
                    'video' => Str::replaceFirst('v/', 'watch?v=', $video)
                ]);
            }

            $this->processCrawl->update([
                'status' => ProcessCrawl::STATUS_COMPLETED
            ]);

        } catch (\Exception $e) {
            logger('Error when process ', [
                'exception' => $e
            ]);
            $this->processCrawl->update([
                'status' => ProcessCrawl::STATUS_FAILED,
                'error' => $e->getMessage() . $e->getTraceAsString()
            ]);
        }
    }
}
