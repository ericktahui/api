<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuarioRelEntidad extends ComposeKeysModel
{
    protected $table ='Usuario_Rel_Entidad';
    protected $primaryKey = ['Usuario_idUsuario','Entidad_idEntidad'];
    public $incrementing = false;
    public $timestamps = false;
}
