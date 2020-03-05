<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Departments;

class UserResource extends JsonResource
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
        $department = Departments::where('id', $this->department_type)->first();
        if($this->is_active == 1){
            $status = 'Active';
        }else{
            $status = 'Inactive';
        }
        return [
            'id' => $this->id,
            'name' => $this->party->person->firstname.' '.$this->party->person->lastname,
            'party_type_id' => $this->party->party_type_id,
            'email' => $this->email != null ? $this->email : 'N/A',
            'username' => $this->username,
            'password' => $this->password,
            'department_type' =>  $department['name'] != null ?  $department['name'] : 'N/A',
            'role' => $this->name,
            'is_active' => $status
        ];
    }
}