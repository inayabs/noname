<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PartyStudentResource extends JsonResource
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
            '_id' => $this->student->id,
            'name' => $this->name,
            'type' => $this->student->type == null ? 'N/A' : $this->student->type->type,
            'application_type' => $this->student->application_type
        ];
    }
}
