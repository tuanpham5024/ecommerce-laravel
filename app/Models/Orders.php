<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $fillable = [
      'name',
      'address',
      'phone',
      'email',
      'note',
      'customer_id',
      'paymentmethod_id',
      'total_price',
      'status_id',
    ];
}
