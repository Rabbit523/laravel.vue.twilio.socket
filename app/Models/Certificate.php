<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    /**
   * The table associated with the model.
   * 
   * @var string
   */
    protected $table = 'certificates';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $fillable = [
      'consultant_id', 'date', 'name', 'institution', 'description', 'diploma'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
      'password', 'remember_token',
    ];

    public function consultant() {
      return $this->belongsTo('App\Models\Consultant', 'consultant_id');
    }
}
