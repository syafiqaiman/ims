<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Picker extends Model
{
    use HasFactory;

    public function returnStock()
    {
        return $this->belongsTo(ReturnStock::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rack()
    {
        return $this->belongsTo(Rack::class);
    }

    public function floor()
    {
        return $this->belongsTo(Floor::class);
    }

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'status',
        'order_no',
        'floor_id',
        'rack_id',
    ];

}