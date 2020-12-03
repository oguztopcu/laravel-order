<?php

namespace App\Repositories;

class Repository
{
    protected $model;

    /**
     * Database'de id'ye göre arama sağlar
     *
     * @param int $id
     * @return mixed
     */
    public function findById($id)
    {
        return $this->model()->where('id', '=', $id)->first();
    }

    /**
     * Dinamik query sınıfı oluşturur.
     *
     * @return mixed
     */
    public function model()
    {
        return (new $this->model)->query();
    }
}
