<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\ResponseFactory as Response;
use Spatie\ArrayToXml\ArrayToXml;

class soalcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $array = [
            'Questions' => [
                'Question' => 'Ada 10 buku. 8 buku bersampul coklat. Persentase buku bersampul coklat adalah ',
                'Image' => '',
                'Answers' => [
                    'Choices' =>[
                        [
                            '_attributes'=>['correct'=>'false'],
                            '_value'=>'60%'
                        ],[
                            '_attributes'=>['correct'=>'true'],
                            '_value'=>'80%'
                        ],[
                            '_attributes'=>['correct'=>'false'],
                            '_value'=>'70%'
                        ],[
                            '_attributes'=>['correct'=>'false'],
                            '_value'=>'50%'
                        ]
                    ]
                ]
            ]
        ];  
        // $result = ArrayToXml::convert($array,'QuestionDatabase');
        // echo($result);
        return response()->xml($array, 200,[
            'Content-Type' => 'text/xml',
            'Content-Disposition:' => 'attachment; filename="asd.xml"'
        ],'QuestionDatabase');
        // return response($result,200,[
        //     'Content-Type' => 'text/xml',
        //     'Content-Disposition:' => 'attachment; filename="asd.xml"'
        // ]);
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
