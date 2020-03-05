<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TrainerResource extends JsonResource
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
            'user_id' => $this->user_id,
            'name' => $this->firstname.' '.$this->middlename.' '.$this->lastname,
            'phone_number' =>$this->phone_number,
            'email' => $this->email,
            'course_taught' => $this->course_taught != null ? $this->course_taught : 'N/A',
            'course_location' => $this->course_location != null ? $this->course_location : 'N/A',
            'commission_settings' => $this->commission_settings
        ];
    }
}
