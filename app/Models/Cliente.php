<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Cliente extends Authenticatable
{
    use HasFactory;

    protected $table = 'clientes';
    public $timestamps = true;
    protected $fillable = array('nome', 'user_id', 'telefone', 'bairro_id', 'imagens');


    public function bairro()
    {
        return $this->belongsTo(Bairro::class);
    }



    public function notifications()
    {
        return $this->morphMany('App\Models\Notification', 'notifiable');
    }



    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }

    public function user()
    {
        # code...


   return $this->belongsTo(User::class);
    }


}
