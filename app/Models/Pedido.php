<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;


    protected $fillable = array('pedido_especial','nota','quantidade','forma_de_pagamento','referencia_de_pagamento','estado',
                                'total','iva',	'cliente_id','nota','endereco',	'taxa_de_entrega');


    public function getClientAttribute(){
        $cliente = $this->cliente()->get()[0];
        // client
        // null
        if ($cliente)
        {
            return $cliente;
        }
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class)->withPivot('preco','quantidade');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function pagamento()
    {

        return $this->hasOne(Pagamento::class);
    }

}
