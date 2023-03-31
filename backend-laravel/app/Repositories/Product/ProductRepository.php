<?php

namespace App\Repositories\Product;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Repositories\BaseRepository;
use App\Repositories\EloquentRepository;
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

    public function getProducts($config)
    {
        $relations =  ['category', 'tags', 'details', 'brand', 'user'];
        return $this->model
            ->orderBy($config['order_by'], $config['mode'])
            ->select('*', DB::raw('(SELECT AVG(rate) FROM rates WHERE rates.product_id = products.id) as avg_rate'))
            ->when($relations, function ($q) use ($relations) {
                return $q->with($relations)->withCount(['rates']);
            })
            ->when($config['search'], function ($q) use ($config) {
                return $q->where($config['search'], "like", "%" . $config['key'] . "%");
            })
            ->paginate($config['page_size'] ?? config('setting.default_page_size'));
    }
}
