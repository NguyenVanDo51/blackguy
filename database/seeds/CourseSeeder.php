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
//        Course::query()->insert([
//            'name' => 'PHP nâng cao',
//            'description' => 'Khóa học PHP nâng cao',
//            'img' => 'https://www.dammio.com/wp-content/uploads/2018/09/php_code_demo.jpg'
//        ]);
        factory(App\Models\Course::class)
            ->create()
            ->each(function ($course) {
                $course->lessions()->createMany(factory(App\Models\Lession::class, 10)->make()->toArray());
            });
    }
}
