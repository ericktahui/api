<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PagoPedidoCubreSocio extends ComposeKeysModel
{
    protected $table ='Pago_Pedido_Cubre_Socio';
    protected $primaryKey = ['Pedido_idPedido','Socio_idSocio'];
    public $incrementing = false;
    public $timestamps = false;
}