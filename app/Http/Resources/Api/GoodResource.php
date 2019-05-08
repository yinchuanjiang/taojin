<?php

namespace App\Http\Resources\Api;

use App\Models\GoodImg;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

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
            //'describe' => htmlspecialchars($this->describe),
            'describe' => str_replace('<img src="/uploads/','<img src="'.config('app.url').'/uploads/',$this->describe),
//            'stock' => $this->stock,
            'good_imgs' => $this->getPictures($this->pictures),
        ];
    }

    public function getPictures($pictures)
    {
        $data = [];
        foreach ($pictures as $picture)
        {
            $data[] = [
                'img_url' => config('app.url').'/uploads/'.$picture
            ];
        }
        return $data;
    }
}
