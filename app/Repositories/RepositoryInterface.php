<?php

namespace App\Repositories;

interface RepositoryInterface
{
    /**
     * Get All
     * @return mixed
     */
    public function getAll();


    /**
     * @param $id
     * @return mixed
     */
    public function find($id);

    /**
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * @param $id
     * @param array $attributes
     * @return mixed
     */
    public function update($id, array $attributes);

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id);

}
