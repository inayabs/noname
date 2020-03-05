<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Deal extends Model implements AuditableContract
{
    //
    use SoftDeletes;
    use Auditable;

    protected $dates =  ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'reference_id',
        'is_active',
        'lead_source_id',
        'deal_status'
    ];

    public function party()
    {
       return $this->belongsTo(Party::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function deal_status()
    {
        return $this->belongsTo(DealStatus::class);
    }

    public function lead_source()
    {
        return $this->belongsTo(LeadSource::class);
    }

    public function deal_type()
    {
        return $this->belongsTo(DealType::class);
    }

    public function deal_equipment()
    {
        return $this->hasMany(DealEquipment::class);
    }

    public function org_details()
    {
        return $this->hasOne(OrganisationDetail::class);
    }

    public function quotation()
    {
        return $this->hasOne(Quotation::class);
    }

    public function deal_staff()
    {
        return $this->hasMany(DealStaff::class);
    }
    
    public function deal_representative()
    {
        return $this->hasMany(DealRepresentative::class);
    }

    public function deal_machine()
    {
        return $this->hasMany(DealMachine::class);
    }

    public function notes()
    {
        return $this->hasMany(DealNote::class, 'deal_id', 'id')->orderBy('created_at', 'desc');
    }
}
