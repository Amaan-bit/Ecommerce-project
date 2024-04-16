<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempOrders extends Model
{
    use HasFactory;
    protected $table = 'temp_orders';
    protected $primaryKey = 'id';
}
