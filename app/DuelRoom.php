<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DuelRoom extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'player_one', 'player_two', 'question_seeder',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    
    protected $primaryKey = 'id';
}
