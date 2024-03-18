<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, Uuids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name'
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
