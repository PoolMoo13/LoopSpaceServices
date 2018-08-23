<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Space extends Model
{

    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
	];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function items()
    {
        return $thi->hasMany('App\Item');
    }


}
