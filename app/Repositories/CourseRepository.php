<?php


namespace App\Repositories;


use App\Models\Category;
use App\Models\Course;
use Exception;
use Illuminate\Pagination\Paginator;

class CourseRepository extends EloquentRepository implements RepositoryInterface
{
    public function getModel()
    {
        // TODO: Implement getModel() method.
        return Course::class;
    }

    /**
     * Search courses without category
     * @param $key
     * @return bool | Course
     */
    public function searchInAll($key)
    {
        try {
            return $this->_model->where('name', 'like', '%' . $key . '%')->paginate(4);
        } catch (Exception $exception) {
            logger($exception->getMessage());
        }
        return false;
    }

    /**
     * search courses with category
     * @param $key
     * @param $option
     * @return mixed
     */
    public function searchWithCategory($key, $option)
    {
        try {
            $category = Category::query()->findOrFail($option);
            return $category->courses()->where('name', 'like', '%' . $key . '%')->paginate(4);
        } catch (Exception $exception) {
            logger($exception->getMessage());
        }
    }

    public function withLessionAndTag($course)
    {
        try {
            dd($course);
            return $course->with(['lessions', 'tags'])->get();
        } catch (Exception $e) {
            logger([
                'Exception when get courses with Lesion and Tag' => $e
            ]);
        }
    }

    public function userRegister()
    {

    }
}
