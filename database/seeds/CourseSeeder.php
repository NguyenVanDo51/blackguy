<?php

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Course::class)
            ->create()
            ->each(function ($course) {
                $course->lessions()->createMany(factory(App\Models\Lession::class, 10)->make()->toArray());
            });
    }
}
