<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productoimagen extends Model
{
    use HasFactory;
    protected $table = "productoimagens";
    protected $fillable = ['nome','url'	,'producto_id'];





    public function producto()
    {
        # code...
        return $this->belongsTo(Producto::class);
    }
}
