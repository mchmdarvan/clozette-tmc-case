<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, Uuids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'sku', 'name', 'price', 'category_id', 'stock'
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
