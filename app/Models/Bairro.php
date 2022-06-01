<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bairro extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $fillable = array('nome', 'cidade_id');



    public function cidade()
    {
        return $this->belongsTo(Cidade::class);
    }


    public function clientes()
    {
        return $this->hasMany(Cliente::class);
    }

}
