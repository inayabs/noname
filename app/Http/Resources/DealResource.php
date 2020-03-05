<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DealResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'is_active' => $this->is_active,
            'party' => $this->party,
            'party_name' => $this->party->name,
            'deal_type' => $this->deal_type,
            'user' => ['party' => $this->user->party]
            // 'party' => PartyResource::collection($this->whenLoaded('party_id')),
        ];
    }
}
