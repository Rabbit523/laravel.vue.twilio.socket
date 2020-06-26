<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
           /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'reviews';

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
        'sender_id', 'receiver_id', 'rate', 'description', 'type', 'session'
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
        return $this->belongsTo('App\Models\Customer', 'sender_id');
    }

    public function consultant() {
        return $this->belongsTo('App\Models\Consultant', 'sender_id');
    }
}
