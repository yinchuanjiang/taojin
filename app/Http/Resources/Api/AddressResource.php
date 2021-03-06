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
            'address' => $this->address,
            'city' => $this->city,
            'detail' => $this->detail,
            'postcode' =>$this->postcode
        ];
    }
}
