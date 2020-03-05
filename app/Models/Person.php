<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model implements AuditableContract
{
    //
    use Auditable;
    use SoftDeletes;
    
    protected $table = 'persons';
    protected $dates =  ['created_at', 'deleted_at'];

    protected $fillable = ['person_type_id', 'gender', 'firstname', 'lastname', 'middlename', 'date_of_birth', 'prefix'];


    public function party()
    {
        return $this->belongsTo(Party::class);
    }

    // gets persons full name
    public function getFullNameAttribute()
    {
        return preg_replace('/\s+/', ' ', $this->firstname . ' ' . $this->middlename . ' ' . $this->lastname);
    }
}
