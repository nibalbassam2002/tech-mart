<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        
    ];
    public function parent()
{
    return $this->belongsTo(Category::class, 'parent_id');
}
public function children()
{
    return $this->hasMany(Category::class, 'parent_id');
}
public function attributes()
{
    return $this->belongsToMany(Attribute::class, 'attribute_category');
}
}
