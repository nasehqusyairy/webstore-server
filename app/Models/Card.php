<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;
    public $fillable = [
        'name',
        'number',
        'cvv',
        'month',
        'year',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
