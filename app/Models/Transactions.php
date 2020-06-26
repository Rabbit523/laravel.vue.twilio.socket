<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'transactions';

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
      'user_id', 'consultant_id', 'amount', 'transaction_id', 'time_spent'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
      'password', 'remember_token',
    ];

    public function user() {
      return $this->belongsTo('App\User', 'user_id');
    }

    public function consultant() {
      return $this->belongsTo('App\Models\Consultant', 'consultant_id');
    }
}
