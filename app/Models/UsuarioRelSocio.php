<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


//class UsuarioRelSocio extends Model
class UsuarioRelSocio extends ComposeKeysModel
{
    protected $table ='Usuario_Rel_Socio';
    protected $primaryKey = ['Usuario_idUsuario','Socio_idSocio'];
    public $incrementing = false;
    public $timestamps = false;
}
