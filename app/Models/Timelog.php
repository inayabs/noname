<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timelog extends Model
{
    //
    protected $fillable = [
        'user_id',
        'time_in',
        'time_out',
        'total_mins_break',
        'total_mins_tardy',
        'on_leave',
        'is_absent',
        'last_activity',
    ];
    protected $dates = ['time_in', 'time_out', 'created_at'];

    public function breaks()
    {
        return $this->hasMany(TimelogBreak::class)->orderBy('break_start', 'desc');
    }
}
