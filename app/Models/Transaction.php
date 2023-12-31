<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    use HasFactory;
    protected $fillable = [
        'user_id',
        'address_id',
        'card_id',
        'shipping_id',
        'status',
        'total'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function address()
    {
        return $this->belongsTo(Address::class);
    }
    public function card()
    {
        return $this->belongsTo(Card::class);
    }
    public function shipping()
    {
        return $this->belongsTo(Shipping::class);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }
}
