<?php


namespace App\Repositories;


use App\Models\Category;

class CategoryRepository extends EloquentRepository
{
    function getModel()
    {
        // TODO: Implement getModel() method.
        return Category::class;
    }

    public function getCoursesInCategory($category)
    {
        try {
            return $category->courses()->paginate(5);
        } catch (\Exception $exception) {
            logger($exception);
        }
    }
}
