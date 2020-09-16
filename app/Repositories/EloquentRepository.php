<?php

namespace App\Repositories;

use Exception;

abstract class EloquentRepository implements RepositoryInterface
{
    protected $_model;

    /**
     * EloquentRepository constructor.
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct()
    {
        $this->setModel();
    }

    abstract function getModel();

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function setModel()
    {
        $this->_model = app()->make(
            $this->getModel()
        );
    }

    /**
     * @return bool|mixed
     */
    public function getAll()
    {
        try {
            return $this->_model->all();
        } catch (Exception $exception) {
            logger($exception->getMessage());
        }

        return false;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function find($id)
    {
        // TODO: Implement find() method.
        try {
            return $this->_model->find($id);
        } catch (Exception $exception) {
            logger($exception->getMessage());
        }

        return false;
    }

    /**
     * @param array $attributes
     * @return bool|mixed
     */
    public function create(array $attributes)
    {
        // TODO: Implement create() method.
        try {
            return $this->_model->create($attributes);
        } catch (Exception $exception) {
            logger($exception->getMessage());
        }

        return false;
    }

    /**
     * @param $id
     * @param array $attributes
     * @return bool|mixed
     */
    public function update($id, array $attributes)
    {
        // TODO: Implement update() method.
        $result = $this->_model->findOrFail($id);
        if ($result) {
            $result->update($attributes);
            return $result;
        }

        return false;
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id): bool
    {
        // TODO: Implement delete() method.
        $result = $this->_model->findOrFail($id);
        if ($result) {
            $result->delete($id);

            return true;
        }
        return false;
    }
}
