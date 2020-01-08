<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\QueuePlayer;
use App\Events\GenerateRoom;

use App\User;
use App\DuelRoom;
use Auth;

class DuelController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function Room()
    {
        $users = User::where('onduel', true)->get();

        return [
            'Players' => $users
        ];
    }

    public function QueuePlayer(int $id)
    {
        $user = Auth::user();
        
        if ($user->id_user == $id)
        {
            $user->onduel = true;
            $user->save();
            
            event(new QueuePlayer($user));

            $users = User::where('onduel', true)->inRandomOrder()->get()->except(Auth::id());
            if ($users->count() > 0)
            {
                $opponent = $users->first();
                $room = new DuelRoom;
                $room->player_one = $user->id_user;
                $room->player_two = $opponent->id_user;
                $room->question_seeder = $this->generateRandomString(12);

                $room->save();
                //broadcast(new GenerateRoom($user, $opponent, $room));
                event(new GenerateRoom($room));
                broadcast(new GenerateRoom($room));

                return ['success' => 1 , 'message' => 'Player '.$user->name.' has join!'];
            }
            else{
                return ['success' => 1 , 'message' => 'Player '.$user->name.' has join! Waiting!'];
            }

        }
        else
        {
            return ['success' => 0 , 'message' => 'Cannot join!'];
        }
    }

    public function PlayerQuit(int $id)
    {
        $user = Auth::user();

        if ($user->id == $id)
        {
            $user->onduel = false;
            $user->save();

            event(new PlayerQuit($user));
        }
    }
}
