<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class levelresourse extends JsonResource
{
    public $data;


    public function toArray($request)
    {
        $user=Auth::guard('sanctum')->user();
        $user->score;
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'scoreeee'=>$this->score,
            'stats'=>($user->score-$this->score>0)?1:0,
        ];
    }
}
