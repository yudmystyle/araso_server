<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\DuelParticipant;
use App\Http\Controllers\Controller;
use App\paketsoal;
use App\User;
use App\Duel;
use App\DuelAnswer;
use Auth;

class DuelController extends Controller
{
    public function createDuel()
    {
        $check = Duel::where('status', 'waiting')->first();

        if($check == NULL){
            //Get Paket Soal Ramdomly
            $paketsoal = paketsoal::inRandomOrder()->first();

            //Create Duel
            $duel = new Duel;
            $duel->id_paketsoal = $paketsoal->id_paketsoal;
            $duel->status = 'waiting';
            $duel->save();

            //Add first participant
            $duel_participant = new DuelParticipant;
            $duel_participant->id_user = Auth::user()->id_user;
            $duel_participant->id_duel = $duel->id_duel;
            $duel_participant->score = '-';
            $duel_participant->save();

            return response()->json([
                'success' => 1,
                'id_duel' => $duel->id_duel,
                'paketsoal' => $duel->id_paketsoal,
                'opponent' => null,
                'status' => 'Waiting'
            ]);
        }
        else{
            // Check same user or not
            $participant_check = DuelParticipant::where('id_duel', $check->id_duel)->where('id_user', Auth::user()->id_user)->first();

            if($participant_check == NULL){
                // $duel_participant_1 = Get first participant where id_user = check->id_user
                $duel_participant_1 = DuelParticipant::where('id_duel', $check->id_duel)->first();

                //Second Participant
                $duel_participant_2 = new DuelParticipant;
                $duel_participant_2->id_user = Auth::user()->id_user;
                $duel_participant_2->id_duel = $check->id_duel;
                $duel_participant_2->score = '-';
                $duel_participant_2->save();

                //Change duel status
                $check->status = 'playing';
                $check->save();

                //Get opponent username
                $opponent = User::where('id_user', $duel_participant_1->id_user)->first();

                return response()->json([
                    'success' => 1,
                    'id_duel' => $check->id_duel,
                    'paketsoal' => $check->id_paketsoal,
                    'opponent' => $opponent->name,
                    'status' => 'Playing'
                ]);
            }
            else{
                return response()->json([
                    'success' => 1,
                    'id_duel' => $check->id_duel,
                    'paketsoal' => $check->id_paketsoal,
                    'opponent' => null,
                    'status' => 'Waiting'
                ]);
            }
        }

        return response()->json([
            'success'=> 0,
            'message'=>'Error'
        ]);
    }

    public function checkDuel(Request $request){
        $duel = Duel::where('id_duel', $request->id_duel)->first();

        if($duel->status == 'playing'){
            //Get opponent
            $opponent_participant = DuelParticipant::where('id_duel', $request->id_duel)->where('id_user', '!=', Auth::user()->id_user)->first();
            $opponent = User::where('id_user', $opponent_participant->id_user)->first();

            return response()->json([
                'success' => 1,
                'id_duel' => $duel->id_duel,
                'paketsoal' => $duel->id_paketsoal,
                'opponent' => $opponent->name,
                'status' => 'Playing'
            ]);
        }
        else if($duel->status == 'done'){
            return response()->json([
                'success' => 1,
                'id_duel' => $duel->id_duel,
                'paketsoal' => $duel->id_paketsoal,
                'opponent' => null,
                'status' => 'Done'
            ]);
        }
        else{
            return response()->json([
                'success' => 1,
                'id_duel' => $duel->id_duel,
                'paketsoal' => $duel->id_paketsoal,
                'opponent' => null,
                'status' => 'Waiting'
            ]);
        }
    }

    public function cancelDuel(Request $request){
        $this->finishDuel($request->id_duel);

        return response()->json([
            'success'=> 1,
            'message'=>'Success'
        ]);
    }

    public function submitDuel(Request $request){
        $participant = DuelParticipant::where('id_duel', $request->id_duel)->where('id_user', Auth::user()->id_user)->first();
        $participant->score = $request->score;
        $participant->save();

        //Change duel status to done
        $this->finishDuel($request->id_duel);

        $opponent_participant = DuelParticipant::where('id_duel', $request->id_duel)->where('id_user', '!=', Auth::user()->id_user)->first();
        $opponent = User::where('id_user', $opponent_participant->id_user)->first();
        if($opponent_participant->score == '-'){
            return response()->json([
                'success'=> 1,
                'opponent' => $opponent->name,
                'status' => 'Playing',
                'score' => null
            ]);
        }
        else{
            return response()->json([
                'success'=> 1,
                'opponent' => $opponent->name,
                'status' => 'Done',
                'score' => $opponent_participant->score
            ]);
        }
    }

    public function finishDuel($id_duel){
        $duel = Duel::where('id_duel', $id_duel)->first();
        $duel->status = 'done';
        $duel->save();
    }

    public function submitAnswer(Request $request){
        $duel_answer = new DuelAnswer;
        $duel_answer->id_user = Auth::user()->id_user;
        $duel_answer->id_duel = $request->id_duel;
        $duel_answer->answer = $request->answer;
        $duel_answer->correct_answer = $request->correct_answer;
        $duel_answer->question_number = $request->question_number;
        $duel_answer->save();

        return response()->json([
            'success'=> 1,
            'message' => 'Success submit answer : ' . $duel_answer->answer . ', question number : ' . $duel_answer->question_number
        ]);
    }

    public function getYourAnswers(Request $request){
        $duel_answers = DuelAnswer::where('id_duel', $request->id_duel)->where('id_user', Auth::user()->id_user)->get();

        return response()->json([
            'success'=> 1,
            'data' => $duel_answers
        ]);
    }

    public function getOpponentAnswers(Request $request){
        $duel_answers = DuelAnswer::where('id_duel', $request->id_duel)->where('id_user', '!=', Auth::user()->id_user)->get();

        return response()->json([
            'success'=> 1,
            'data' => $duel_answers
        ]);
    }
}
