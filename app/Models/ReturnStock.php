<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnStock extends Model
{
    use HasFactory;

    protected $table = 'return_stock';

    protected $fillable = [
        'user_id',
        'company_id',
        'address',
        'phone_number',
        'email',
        'return_no',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'return_stock_pivot')
            ->withPivot('quantity', 'remark', 'status');
    }
}
