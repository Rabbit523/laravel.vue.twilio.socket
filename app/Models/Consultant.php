<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultant extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'consultants';

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
        'user_id', 'profile_id', 'company_id', 'phone_contact', 'chat_contact', 'video_contact', 'currency', 'hourly_rate', 'rate', 'payment_method', 'completed_sessions', 'response_rate'
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

    public function profile() {
        return $this->belongsTo('App\Models\Profile', 'profile_id');
    }

    public function company() {
        return $this->belongsTo('App\Models\Company', 'company_id');
    }
}
