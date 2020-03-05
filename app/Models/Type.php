<?php

namespace App\Models\Student;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    //

    protected $table = 'student_types';

    public function student(){
        return $this->hasOne(Student::class);
    }
}
