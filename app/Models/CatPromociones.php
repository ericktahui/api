<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatPromociones extends Model
{
    protected $table ='CatPromociones';
    protected $primaryKey = 'idPromocion';
    public $timestamps = false;
}