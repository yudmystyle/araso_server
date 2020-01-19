<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class partisipan extends Model
{

    protected function setKeysForSaveQuery(Builder $query)
    {
        $query
            ->where('id_user','=',$this->getAttribute('id_user'))
            ->where('id_arena','=',$this->getAttribute('id_arena'));

        return $query;
    }

    protected $fillable = [
        'score','id_user','id_arena'
    ];

    public function user()
    {
        return $this->belongsTo('App\user','id_user','id_user');
    }

    public function arena()
    {
        return $this->belongsTo('App\arena','id_arena','id_arena');
    }
}
