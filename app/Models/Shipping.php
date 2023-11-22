<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'internal_price',
        'external_price',
        'overseas_price'
    ];
    public function transactions()
    {
        return $this->hashMany(Transactions::class);
    }
}
