<?php

namespace App\Repositories\Category;

use App\Models\Category;
use App\Repositories\EloquentRepository;
use App\Repositories\BaseRepository;
use App\Repositories\Category\CategoryRepositoryInterface;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    public function getModel()
    {
        return Category::class;
    }

    public function category($config)
    {
        $categories = $this->model
            ->orderBy($config['order_by'], $config['mode'])
            ->when($config['search'], function($q) use($config) {
                return $q->where($config['search'], "like", "%" . $config['key'] . "%" );
            })
            ->paginate($config['page_size']);

        return $categories;
    }

    public function getAlbumWithSong($id){ }

    //Delete all song of album by album id
    public function deleteSongOfAlbum($id){ }

    //Get all album and song belong to this album
    public function getAllAlbumWithSong(){}
}