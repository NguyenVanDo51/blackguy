<?php

namespace App\Providers;

use App\Http\Controllers\CourseController;
use App\Http\Controllers\TagController;
use App\Models\Category;
use App\Repositories\CourseRepository;
use App\Repositories\TagRepository;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useTailwind();
        Schema::defaultStringLength(191);

        $this->app->singleton('tag', function() {
            return new TagController(new TagRepository());
        });

        $this->app->singleton('course', function() {
            return new CourseController(new CourseRepository());
        });

        View::composer(['pages.home', 'pages.search'], function(\Illuminate\View\View $view) {
            $tags = $this->app->make('tag');
            $view->with([
                'categories' => Category::query()->with('tags')->get(),
                'tags' => $tags->getIsShow()
            ]);
        });
    }
}
