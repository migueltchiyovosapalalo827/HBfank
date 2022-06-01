<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cidade extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable = array('nome');

    public function getBairroAttribute($cityId){
        return $this->bairros()->where('cidade_id',$cityId);
    }

    public function bairros()
    {
        return $this->hasMany(Bairro::class);
    }
}
