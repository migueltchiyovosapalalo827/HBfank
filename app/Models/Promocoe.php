<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promocoe extends Model
{
    use HasFactory;
    protected $fillable = array('nome',	'descricao','inicio','fim','imagens');

}
