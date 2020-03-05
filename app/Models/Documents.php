<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documents extends Model
{
    //
    protected $fillable = ['u_id', 'path_id', 'name', 'note', 'hash_name', 'size', 'mime_type', 'ext', '_input', 'version', 'is_current'];
    protected $dates = ['created_at'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
