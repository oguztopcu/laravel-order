<?php

namespace App\Repositories;

class Repository
{
    protected $model;

    public function model()
    {
        return (new $this->model)->query();
    }
}
