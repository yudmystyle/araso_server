<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class soal extends Model
{
    protected $primaryKey = 'id_soal';

    public function soal()
    {
        return $this->belongsTo('App\paketsoal','id_paketsoal','id_paketsoal');
    }


    //
}
