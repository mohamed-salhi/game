<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\TrueFalse;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class truefalseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TrueFalse::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function gettlevel()
    {
$data=Level::select(['name','id'])->get();
       return Response()->json([
           'massage'=>$data
       ]) ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'level_id'=>'required|integer|exists:levels,id',
            'title'=>'required|string|between:2,100',
            'score'=>'required|integer',
            'anwaer' => [
                'required',
                Rule::in([0,1]),
            ],
        ]);
       $tf= TrueFalse::create($request->all());
       if ($tf){
           return response()->json([
               'massage' => $tf,
               'status'=>200
           ]);
       }else{
           return response()->json([
               'massage' => 'faled',
               'status'=>404
           ]);
       }



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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function gettruefalsedit($id)
    {
        $f=TrueFalse::find($id);
        if ($f){
            return response()->json([
                'massage' => $f,
                'status'=>200
            ]);
        }else{
            return response()->json([
                'massage' => 'notfound',
                'status'=>404
            ]);
        }
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
        $request->validate([
            'level_id'=>'required|integer|exists:levels,id',
            'title'=>'required|string|between:2,100',
            'score'=>'required|integer',
            'anwaer' => [
                'required',
                Rule::in([0,1]),
            ],
        ]);
      $tf=TrueFalse::find($id);
       if ($tf){
           $tf->update($request->all());
        return response()->json([
            'massage' => $tf,
            'status'=>200
        ]);
        }else{
           return response()->json([
               'massage' =>'faild',
               'status'=>404
           ]);

       }



    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tf=TrueFalse::find($id);
        if ($tf){
            $tf->delete();
            return response()->json([
                'massage' =>'true',
                'status'=>200
            ]);
        }
        return response()->json([
            'massage' =>'faild',
            'status'=>404
        ]);

    }
}
