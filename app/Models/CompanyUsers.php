<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class companyUsers extends Model
{
    public $table = 'company_user';

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

}
