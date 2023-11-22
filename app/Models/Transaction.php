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
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function addres()
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
}
