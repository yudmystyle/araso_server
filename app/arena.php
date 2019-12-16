<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class arena extends Model
{
    protected $primaryKey = 'id_arena';

    public function partisipan()
    {
        return $this->hasMany('App\partisipan','id_arena','id_arena');
    }

    public function kategori()
    {
        return $this->belongsTo('App\paketsoal','id_paketsoal','id_paketsoal');
    }



    //
}
