<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use Auth;
use DateTime;
use DateTimeZone;
use App\arena;
use App\partisipan;
use App\Http\Controllers\Controller;

class arenacontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function createarena(Request $request)
    {
        date_default_timezone_get('Asia/Jakarta');

        $phpdate = date_create_from_format('Y-m-d H:i:s',$request->waktu_selesai,new DateTimeZone('Asia/Jakarta'));
        
        if($phpdate < new DateTime()){
            return response()->json([
                'success'=> 0,
                'message'=>'arena tidak dapat dibuat karena batas waktu akhir sudah lewat'
            ]);
        }
        
        $uniquecode=$this->generateRandomString(5);

        $check=Arena::where('uniquecode',$uniquecode)->first();

        if($check!=NULL){
            $this->createarena($request);
            
        }
        else {
            $arena=new arena;
            $arena->id_paketsoal=$request->id_paketsoal;
            $arena->waktu_mulai=$request->waktu_mulai;
            $arena->waktu_selesai=$request->waktu_selesai;
            $arena->uniquecode=$uniquecode;
            $arena->save();

            $partisipan=new partisipan;
            $partisipan->id_user= Auth::user()->id_user;
            $partisipan->id_arena= $arena->id_arena;
            $partisipan->score='-';
            $partisipan->save();
            
            return response()->json([
                'success'=> 1,
                'uniquecode'=>$uniquecode
            ]);
            }

        
    }

    public function joinarena(Request $request)
    {
        date_default_timezone_get('Asia/Jakarta');
        $arena=Arena::where('uniquecode',$request->uniquecode)->first();
        

        if($arena!=NULL){
            // $phpdate = strtotime($arena->waktu_selesai);
            $phpdate = date_create_from_format('Y-m-d H:i:s',$arena->waktu_selesai,new DateTimeZone('Asia/Jakarta'));
            // $phpdate->setTimeZone();
            // var_dump($phpdate);
            // var_dump(new DateTime('now'));
            // var_dump(date('m/d/Y h:i:s a',new DateTime('now')));
            // var_dump($phpdate >= new DateTime('now'));
            // die();
            if($phpdate >= new DateTime('now')){

                $checkavailability=Partisipan::where(['id_arena'=>$arena->id_arena,'id_user'=>Auth::user()->id_user])->first(); 

                if($checkavailability!=NULL){
                    return response()->json([
                        'success'=> 0,
                        'message'=>'user sudah masuk dalam arena'
                    ]);
                }
                $partisipan=new partisipan;
                $partisipan->id_user= Auth::user()->id_user;
                $partisipan->id_arena= $arena->id_arena;
                $partisipan->score='-';
                $partisipan->save();
                
                return response()->json([
                    'success'=> 1
                ]);
                
            }else{
                return response()->json([
                    'success'=> 0,
                    'message'=>'tidak dapat join, waktu permainan telah berakhir'
                ]);
                
            }
        }
        else{
            return response()->json([
                'success'=> 0,
                'message'=> 'arena tidak ditemukan'
            ]);
        }
    }

    public function submitarena(Request $request){

        $partisipan=Partisipan::where([
            ['id_arena','=',intval($request->id_arena)],
            ['id_user','=',Auth::user()->id_user]
        ])->first();

        // var_dump($partisipan->score);
        // echo(strval($request->score));
        // echo($partisipan->score);
        // die();

        $partisipan->score=strval($request->score);
        $partisipan->save();

        return response()->json([
            'success'=> 1
        ]);
    }

    public function historiarena(Request $request){
        $user=Auth::user();
        $partisipan=$user->partisipan;
        $histori=[];
        foreach ($partisipan as $value) {
            $temp = $value->arena;
            $temp->score = $value->score;
            array_push($histori,$temp);
        }
        return response()->json([
            'data'=>$histori
        ]);
    }

    public function detailarena(Request $request){
        $arena=arena::find($request->id_arena);
        $partisipan=$arena->partisipan;
        $detail=[];
        foreach ($partisipan as $value){
            $temp = $value->user;
            $temp->score = $value->score;
            array_push($detail,$temp);
        }
        $waktu_mulai=date_create_from_format('Y-m-d H:i:s',$arena->waktu_mulai,new DateTimeZone('Asia/Jakarta'));
        $waktu_selesai=date_create_from_format('Y-m-d H:i:s',$arena->waktu_selesai,new DateTimeZone('Asia/Jakarta'));
        $waktu_sekarang=new DateTime('now');
        
        if(($waktu_mulai<=$waktu_sekarang)&&($waktu_selesai>=$waktu_sekarang)){
            $bisa_mengerjakan=true;
        }
        else{
            $bisa_mengerjakan=false;
        }
        return response()->json([
            'data'=>$detail,
            'bisa_mengerjakan'=>$bisa_mengerjakan
        ]);
    }



    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
