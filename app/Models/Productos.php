<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    protected $table ='Productos';
    protected $primaryKey = 'idProducto';
    public $timestamps = false;
}