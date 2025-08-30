<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
    'name',
    'slug',
    'description',
    'price',
    'quantity',
    'category_id',
    'currency',
    'offer_ends_at',
    'discount_price'
];

    // This function defines the relationship: A Product BELONGS TO a Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
        public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function attributeValues()
{
    return $this->belongsToMany(AttributeValue::class, 'product_attribute_values');
}
}