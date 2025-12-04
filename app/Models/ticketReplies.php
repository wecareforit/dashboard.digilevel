<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ticketReplies extends Model
{

    // protected $casts = [
    //     'status_id' => TicketStatus::class,
    // ];

    public static function boot()
    {
        parent::boot();

        static::created(function ($item) {
            $item->user_id = Auth::user()->id;
        });
    }

    public function employee()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

}
