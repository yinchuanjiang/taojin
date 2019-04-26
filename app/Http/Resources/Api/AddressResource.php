<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            'to_name' => $this->to_name,
            'mobile' => $this->mobile,
            'province' => $this->province,
            'city' => $this->city,
            'area' => $this->area,
            'detail' => $this->detail,
            'postcode' =>$this->postcode
        ];
    }
}
