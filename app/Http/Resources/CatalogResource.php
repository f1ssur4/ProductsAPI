<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CatalogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
                'id' => $this->id,
                'name' => $this->name,
                'id_brand' => $this->id_brand,
                'id_category' => $this->id_category,
                'id_availability' => $this->id_availability,
                'price' => $this->price,
                'currency_title' => new CurrencyResource($this->Currency),
        ];
    }
}
