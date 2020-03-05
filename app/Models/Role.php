<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
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
	 *
	 * static attribute validation rules
	 *
	 * @var array
	 */
	public static $rules = [
		'name'	=> 'required',
		'slug'	=> 'bail|required|unique:roles,slug',
		'description'	=> 'nullable',
	];

    //
    // public function getRouteKeyName()
    // {
    //     return 'slug';
    // }
}
