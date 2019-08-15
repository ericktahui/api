<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatEstados extends Model
{
    protected $table ='CatEstados';
    protected $primaryKey = 'idEstado';
    public $timestamps = false;
}