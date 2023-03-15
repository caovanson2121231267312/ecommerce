<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, Sluggable, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'price',
        'images',
        'description',
        'view',
        'detail',
        'note',
        'category_id',
        'sale',
        'time_limit',
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

    public function images()
    {
        return $this->hasMany(ImagesProduct::class, "images_products");
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, "tag_product");
    }
}
