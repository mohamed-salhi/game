<?php

namespace App\Http\Resources;

use App\Models\soulion;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class chooesresourse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user=Auth::guard('sanctum')->user();
        $c=soulion::whereNotNull('chooe_id')->where('level_id',$this->level_id)->where('user_id',$user->id)->pluck('chooe_id')->toArray();

        return [
                "id"=> $this->id,
                "level_id"=> $this->level_id,
                "title"=> $this->title,
                "score"=> $this->score,
                "answarone"=> $this->answarone,
                "answartow"=> $this->answartow,
                "answarthree"=> $this->answarthree,
                "answarfour"=> $this->answarfour,
                "answartrue"=> $this->answartrue,
                "status"=>in_array($this->id, $c)?
                    $this->check($this->level_id,$user->id,$this->id)
                    :'nurmal'

        ];
    }
    public function check($level_id,$user_id,$id){
        $stats=soulion::whereNotNull('chooe_id')->where('level_id',$level_id)->where('user_id',$user_id)->where('chooe_id',$id)->select('stats')->first();
if ($stats->stats=='true'){
    return 'true';
}elseif($stats->stats=='skip'){
    return 'skip';
}elseif($stats->stats=='false'){
    return 'false';
}else{
    return 'nurmal';
}
    }
}
