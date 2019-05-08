<?php

namespace App\Http\Resources\Api;

use App\Models\GoodImg;
use Illuminate\Http\Resources\Json\JsonResource;

class GoodResource extends JsonResource
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
            'sales_volume' => $this->sales_volume,
            'describe' => htmlspecialchars($this->describe),
            'stock' => $this->stock,
            'good_imgs' => GoodImgResource::collection($this->goodImgs),
        ];
    }
}
