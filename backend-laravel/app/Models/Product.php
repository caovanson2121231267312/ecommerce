<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, Sluggable, SluggableScopeHelpers, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'price',
        'images',
        'description',
        'view',
        'content',
        'note',
        'category_id',
        'user_id',
        'sale',
        'note',
        'hot',
        'payload',
        'like',
        'status',
        'quantity',
        'time_sale',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
                'unique' => true,
                'onUpdate' => true,
            ]
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function images()
    {
        return $this->hasMany(ImagesProduct::class, "images_products");
    }

    public function details()
    {
        return $this->hasMany(ProductInfor::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, "tag_product");
    }
}
