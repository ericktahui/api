<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetallePedido extends ComposeKeysModel
{
    protected $table ='Detalle_Pedido';
    protected $primaryKey = ['idPedido','idProducto'];
    public $incrementing = false;
    public $timestamps = false;
}
