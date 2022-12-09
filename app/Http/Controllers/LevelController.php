<?php

namespace App\Http\Controllers;

use App\Http\Resources\levelresourse;
use App\Http\Resources\qustionresourse;
use App\Models\chooes;
use App\Models\Level;
use App\Models\soulion;
use App\Models\soulionlevel;
use App\Models\TrueFalse;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user=Auth::guard('sanctum')->user();
$user->score;
        $level=Level::all();


      return Response()->json([
        'message' => $level,
        'score'=>$user->score
    ], 200);
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
           'name'=>'required'
        ]);
        $level =Level::create($request->all());
        if ($level){
            return Response()->json([
                'message' => 'true',
                'status'=>200
            ], 200);
        }else{
            return Response()->json([
                'message' => 'false',
            ], 404);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required'
        ]);
        $level =Level::findOrFail($id);
        $level->update([
            'name'=>$request->name
        ]);


        if ($level){

            return Response()->json([
                'message' => 'true',
                'status'=>200
            ], 200);
        }else{
            return Response()->json([
                'message' => 'false',
            ], 404);
        }
    }

    public function destroy($id)
    {
        $level =Level::destroy($id);
        if ($level){

            return Response()->json([
                'message' => 'true',
                'status'=>200
            ], 200);
        }else{
            return Response()->json([
                'message' => 'false',
            ], 404);
        }
    }
    public function gettleveluser(){
        $user=Auth::guard('sanctum')->user();
        $user->score;
        $level=Level::all();

        return Response()->json([
            'level' =>levelresourse::collection($level),
            'score'=>$user->score
        ], 200);
    }




    public function postlevelsoultion(Request$request){
        $user=Auth::guard('sanctum')->user();

        $request->validate([
       'level_id'=>'required|integer|exists:levels,id',
        ]);
        soulionlevel::updateOrCreate([
           'user_id'=> $user->id,
            'level_id'=>$request->level_id
        ]);
        return Response()->json([
            'massage'=>'true',
            'status'=>200
        ]);
    }


    public function getqustion($id){
//        $user=Auth::guard('sanctum')->user();
//
//        $t=soulion::whereNotNull('true_false_id')->where('level_id',$id)->where('user_id',$user->id)->pluck('true_false_id');
//        $c=soulion::whereNotNull('chooe_id')->where('level_id',$id)->where('user_id',$user->id)->pluck('chooe_id');


//        $data=Level::where('id',$id)->with([
//            'true_false'=>function($qurey) use($t){
//                $qurey->whereNotIn('id',$t);
//            }
//        ])->with([
//            'choosee'=>function($qurey) use($c){
//                $qurey->whereNotIn('id',$c);
//            }
//        ])->get();

        $data=Level::where('id',$id)->with(
            'true_false')->with(
            'choosee')->get();

//        $sochooes=chooes::whereIn('id',$t)->get();
//        $soTrueFalse=TrueFalse::whereIn('id',$t)->get();


        return Response()->json([

            'data'=> qustionresourse::collection($data),
//            'nosoluion'=>['chooes'=>$sochooes,'truefalse'=>$soTrueFalse]
        ]);
    }

    public function postqustionsoultion(Request $request){
        $request->validate([
            'level_id'=>'required|integer|exists:levels,id',
            'true_false_id'=>'nullable|integer|exists:true_falses,id',
            'chooe_id'=>'nullable|integer|exists:chooes,id',
            'stats'=>[
                'required',
                Rule::in(['nurmal', 'false','true','skip']),
            ]

        ]);
        $power=0;
        if ($request->has('chooe_id')){
            $power= chooes::find($request->chooe_id)->score;
        }else{
            $power= TrueFalse::find($request->true_false_id)->score;
        }
        $user=Auth::guard('sanctum')->user();
        $score=$user->score;
        if ($request->stats=='true'){
            $user->update([
               'score'=>$score+$power
            ]);
        }elseif ($request->stats=='skip'){
            $user->update([
                'score'=>$score-1
            ]);
        }
$request->merge([
   'user_id'=>$user->id,
]);
        soulion::updateOrCreate($request->all());
        return Response()->json([
            'massage'=>'true',
            'status'=>200
        ]);

    }
}
