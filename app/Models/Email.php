<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{

    /**
     * Auditable events.
     *
     * @var array
     */
    protected $auditableEvents = [
        'deleted',
        'restored',
        'updated',
        'created'
    ];

    /**
    * Should the timestamps be audited?
    *
    * @var bool
    */
    protected $auditTimestamps = true;

    /**
        * The table associated with the model.
        *
        * @var string
        */
       protected $table = 'user_emails';

    /**
     *
     * Fillables
     * 
     * @var array
     */
    protected $fillable = [
    	'user_id', 'email', 'email_password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    	'email_password'
    ];

    /**
     *
     * Guarded
     *
     */
    protected $guarded = [];

    /**
     *
     * Get associated user on each email
     *
     */
    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
