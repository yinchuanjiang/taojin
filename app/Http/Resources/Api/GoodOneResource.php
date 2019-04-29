<?php

namespace App\Http\Resources\Api;

use App\Models\GoodImg;
use Illuminate\Http\Resources\Json\JsonResource;

class GoodOneResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'price' => $this->price,
            'good_imgs' =>new GoodImgResource($this->goodImgs()->first()),
        ];
    }
}
