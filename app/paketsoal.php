<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class paketsoal extends Model
{
    protected $primaryKey = 'id_paketsoal';

    public function paketsoal()
    {
        return $this->hasMany('App\soal','id_paketsoal','id_paketsoal');
    }

    public function list_arena()
    {
        return $this->hasMany('App\arena','id_paketsoal','id_paketsoal');
    }



    //
}
