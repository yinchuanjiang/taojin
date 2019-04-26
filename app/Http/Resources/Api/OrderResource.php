<?php

namespace App\Http\Resources\Api;

use App\Models\Enum\OrderEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'good' => new GoodResource($this->good),
            'sn' => $this->sn,
            'quantity' => $this->quantity,
            'total' => $this->total,
            'status' => OrderEnum::getStatusName($this->status),
            'address' => \GuzzleHttp\json_decode($this->address,true)
        ];
    }
}
