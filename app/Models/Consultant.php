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
        'unique_id', 'industry_expertise', 'phone_contact', 'chat_contact', 'video_contact', 'company_name', 'invoice_mail', 'invoice_first_name', 'invoice_last_name', 'invoice_address', 'invoice_zip_code', 'invoice_zip_place', 'prof_image', 'image_access'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'unique_id');
    }
}
