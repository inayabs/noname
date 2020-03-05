<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    //
    protected $fillable = ['name', 'email_subject', 'serial_no', 'email_content', 'active'];
    protected $dates = ['created_at'];
}
