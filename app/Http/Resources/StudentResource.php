<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
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
            '_id' => $this->id,
            'id' => $this->party_id,
            'name' => $this->party->name,
            'type' => $this->type == null ? 'N/A' : $this->type->type,
            'application_type' => $this->application_type
        ];
    }
}
