<?php


namespace App\Repositories;

use App\Models\Tag;

class TagRepository extends EloquentRepository implements RepositoryInterface
{
    function getModel()
    {
        // TODO: Implement getModel() method.
        return Tag::class;
    }

    function getIsShow()
    {
        try {
            return $this->_model->where('is_show', 1)->get();
        } catch (\Exception $exception) {
            logger($exception->getMessage());
        }

        return false;
    }

    function getWithPaginate($number)
    {
        try {
            return $this->_model->paginate($number);
        } catch (\Exception $exception) {
            logger($exception->getMessage());
        }
    }
}
