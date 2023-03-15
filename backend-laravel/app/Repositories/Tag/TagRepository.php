<?php

namespace App\Repositories\Tag;

use App\Models\Tag;
use App\Repositories\EloquentRepository;
use App\Repositories\BaseRepository;
use App\Repositories\Tag\TagRepositoryInterface;

class TagRepository extends BaseRepository implements TagRepositoryInterface
{
    public function getModel()
    {
        return Tag::class;
    }
}