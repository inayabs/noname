<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Party extends Model implements AuditableContract
{
    //
    use SoftDeletes;
    use Auditable;

    protected $dates =  ['created_at', 'deleted_at'];

    protected $table = 'party';

    protected $fillable = [
        'party_type_id',
        'name'
    ];

    public function person()
    {
        return $this->hasOne(Person::class);
    }

}
