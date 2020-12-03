<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $dates = ['deleted_at'];

    public function getRouteKeyName()
    {
        return 'order_code';
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_products');
    }
}
