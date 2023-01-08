<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Mass assignment protection
    protected $fillable =['code', 'name', 'quantity'];
        
    // timestaps (created _at & update_at)
    public $timestamps = true;
}
