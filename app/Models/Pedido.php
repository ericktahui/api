<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table ='Pedido';
    protected $primaryKey = 'idPedido';
    public $timestamps = false;
}