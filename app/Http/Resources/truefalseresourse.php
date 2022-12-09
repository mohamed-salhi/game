<?php

namespace App\Http\Resources;

use App\Models\Level;
use App\Models\soulion;
use App\Models\TrueFalse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class truefalseresourse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {$user=Auth::guard('sanctum')->user();
    $t=soulion::whereNotNull('true_false_id')->where('level_id',$this->level_id)->where('user_id',$user->id)->pluck('true_false_id')->toArray();
        return ["id"=> $this->id,
                "level_id"=> $this->level_id,
                "title"=> $this->title,
                "score"=> $this->score,
                "anwaer"=> $this->anwaer,
                "status"=>in_array($this->id, $t)?
                $this->check($this->level_id,$user->id,$this->id)
                :'nurmal'];
    }
    public function check($level_id,$user_id,$id){
        $stats=soulion::whereNotNull('true_false_id')->where('level_id',$level_id)->where('user_id',$user_id)->where('true_false_id',$id)->select('stats')->first();
        if ($stats->stats=='true'){
            return 'true';
        }elseif($stats->stats=='skip'){
            return 'skip';
        }else{
            return 'false';
        }
    }
}
