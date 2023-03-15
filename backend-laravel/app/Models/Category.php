<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, Sluggable, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'image',
        'description'
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

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
}
