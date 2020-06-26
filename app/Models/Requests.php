<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Requests extends Model
{
           /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'requests';

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
        'customer_id', 'consultant_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function customer() {
        return $this->belongsTo('App\Models\Customer', 'customer_id');
    }

    public function consultant() {
        return $this->belongsTo('App\Models\Consultant', 'consultant_id');
    }
}
