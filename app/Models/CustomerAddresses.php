<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAddresses extends Model
{
    use HasFactory;
    protected $table = 'customer_addresses';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id','first_name','last_name','email','address','apartment','city','state','zip','mobile'];
}
