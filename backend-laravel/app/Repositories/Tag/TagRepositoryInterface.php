<?php

namespace App\Repositories\Tag;

use App\Repositories\BaseRepositoryInterface;

interface TagRepositoryInterface extends BaseRepositoryInterface
{
    public function getTags($config);
}