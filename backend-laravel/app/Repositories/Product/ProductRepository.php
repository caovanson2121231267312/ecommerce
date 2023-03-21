<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Repositories\EloquentRepository;
use App\Repositories\BaseRepository;
use App\Repositories\Product\ProductRepositoryInterface;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function getModel()
    {
        return Product::class;
    }

    public function createProduct(array $attributes, array $detail, array $tags)
    {
        $product = $this->model->create($attributes);

        $product->tags()->attach($tags);

        $product->details()->createMany($detail);

        return $product;
    }

    public function getProduct()
    {
        return $this->model->where("category_id", "=", 1)->get();
    }
}
