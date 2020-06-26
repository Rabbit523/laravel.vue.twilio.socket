<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChargingTransactions extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'charging_transactions';

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
      'user_id', 'type', 'amount', 'transaction_id', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
      'password', 'remember_token',
    ];
}
