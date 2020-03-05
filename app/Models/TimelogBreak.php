<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimelogBreak extends Model
{
    //
    protected $fillable = [
        'timelog_id',
        'break_start',
        'break_end',
        'total_breaks',
        'notes',
        'last_user_activity',
    ];
    protected $dates = ['break_start', 'break_end', 'created_at'];

    public function timelog()
    {
        return $this->belongsTo(Timelog::class);
    }
}
