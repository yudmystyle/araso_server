<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class DuelParticipant extends Model
{
    protected function setKeysForSaveQuery(Builder $query)
    {
        $query
            ->where('id_user','=',$this->getAttribute('id_user'))
            ->where('id_duel','=',$this->getAttribute('id_duel'));

        return $query;
    }

    protected $fillable = [
        'score','id_user','id_duel'
    ];

    public function user()
    {
        return $this->belongsTo('App\User','id_user','id_user');
    }

    public function duel()
    {
        return $this->belongsTo('App\Duel','id_duel','id_duel');
    }
}
