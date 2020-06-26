<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
           /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'company';

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
        'company_name', 'organization_number', 'bank_account', 'first_name', 'last_name', 'address', 'zip_code', 'zip_place', 'country'
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
