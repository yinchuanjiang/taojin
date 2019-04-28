<?php

namespace App\Http\Resources\Api;

use App\Models\Enum\BalanceDetailEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class BalanceDetailResource extends JsonResource
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
            'type' => BalanceDetailEnum::getStatusName($this->type),
            'cash' => $this->cash,
            'created_at' => $this->created_at,
        ];
    }
}
