<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    protected $fillable = array('nome','descricao','preco','imagens');

     public function productos()
    {
        # code...
        return $this->hasMany(Producto::class);
    }
}
