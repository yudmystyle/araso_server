<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Duel extends Model
{
    protected $primaryKey = 'id_duel';

    protected $fillable = [
        'status'
    ];

    public function partisipan()
    {
        return $this->hasMany('App\DuelParticipant','id_duel','id_duel');
    }

    public function kategori()
    {
        return $this->belongsTo('App\paketsoal','id_paketsoal','id_paketsoal');
    }
}
