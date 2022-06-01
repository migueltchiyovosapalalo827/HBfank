<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = array('nome','descricao','preco','imagens');

    public function notHavingImageInDb(){
        return (empty($this->imagens))?true:false;
        //return true;
    }


    public function pedidos()
    {
        return $this->belongsToMany(Pedido::class);
    }


    public function productoimagens()
    {
        # code...
        return $this->hasMany(Productoimagen::class);
    }

   public function categoria()
   {
       # code...
       return $this->belongsTo(Categoria::class);
   }

}
