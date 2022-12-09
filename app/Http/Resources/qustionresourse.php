<?php

namespace App\Http\Resources;

use App\Models\soulion;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class qustionresourse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

//        $user=Auth::guard('sanctum')->user();

//        $t=soulion::whereNotNull('true_false_id')->where('level_id',$id)->where('user_id',$user->id)->pluck('stats');
//        $c=soulion::whereNotNull('chooe_id')->where('level_id',$id)->where('user_id',$user->id)->pluck('stats');
//
        return [
            "id"=> $this->id,
        "name"=> $this->name,
        "score"=> $this->score,
        "true_false"=>truefalseresourse::collection($this->true_false) ,
        "choosee"=>chooesresourse::collection($this->choosee)
        ];
    }
}
