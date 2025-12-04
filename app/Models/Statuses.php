<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class Supplier
 *
 
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Statuses extends Model
{
    use SoftDeletes;

  
 
    
    // // Number of items to be shown per page
    // protected $perPage = 20;

    // // Attributes that should be mass-assignable
    // protected $fillable = ['last_edit_at','last_edit_by','name','zipcode','place','address','emailaddress','phonenumber'];
    
    // // Attributes that are searchable
    // static $searchable = ['last_edit_at','last_edit_by','name','zipcode','place','address','emailaddress','phonenumber']; 
    
    
}
