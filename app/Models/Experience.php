<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    /**
   * The table associated with the model.
   * 
   * @var string
   */
    protected $table = 'experiences';

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
      'consultant_id', 'from', 'to', 'company', 'position', 'country', 'city', 'description'
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
