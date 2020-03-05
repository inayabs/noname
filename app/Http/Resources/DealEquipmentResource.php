<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DealEquipmentResource extends JsonResource
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
            'deal' => $this->deal,
            'equipment' => $this->equipment,
            'equipment_id' => $this->equipment_id,
            'target_patients_monthly' => $this->target_patients_monthly,
            'patient_payment' => $this->patient_payment,
            'bpjs' => $this->bpjs,
            'remarks' => $this->remarks
        ];
    }
}
