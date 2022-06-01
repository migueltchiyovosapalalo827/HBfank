<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empregado extends Model
{
    use HasFactory;

    protected $fillable = array('nome','endereco','telefone','data_de_nascimento','user_id');
    protected $appends = ['age'];

    public function getAgeAttribute()
    {
        # code...
        return Carbon::parse($this->attributes['data_de_nascimento'])->age;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
