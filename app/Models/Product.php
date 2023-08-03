<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function rack()
    {
        return $this->belongsTo(Rack::class);
    }

    public function floor()
    {
        return $this->belongsTo(Floor::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function deliveries()
    {
        return $this->belongsToMany(Delivery::class, 'delivery_product');
    }

    public function pickers()
    {
        return $this->hasMany(Picker::class);
    }

    public function returnStocks()
    {
        return $this->belongsToMany(ReturnStock::class, 'pickers');
    }

}
