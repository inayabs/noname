<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ComSettingResource extends JsonResource
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
            'trainer_id' => $this->trainer_id,
            'course_codes' => $this->course_codes,
            'student_quota' => $this->student_quota,
            'trainer_collab' => $this->trainer_collab,
            'commission_value' => $this->commision_type_id.' '.$this->commision_value
        ];
    }
}
