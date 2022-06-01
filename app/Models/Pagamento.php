<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    use HasFactory;


    protected $fillable = array('pedido_id','referencia_de_pagamento','valor','estado');

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }
}
