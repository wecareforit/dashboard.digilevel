<?php
namespace App\Models;

use App\Enums\Priority;
use App\Enums\TicketStatus;
use App\Enums\TicketTypes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Mail\TicketToUser; 
use Illuminate\Support\Facades\Mail;
class Ticket extends Model
{

    use SoftDeletes;
    protected $casts = [

        'priority' => Priority::class,
        'status_id' => TicketStatus::class,
        'type' => TicketTypes::class
    ];


    
// protected static function booted()
// {
// static::created(function ($model) {
//     if ($model->created_by_user) {
//         // Ticketnummer = id
//         $ticketnummer = $model->id;

//         // First 3 letters from app name (uppercase)
//         $shortName = strtoupper(substr(env('APP_NAME', 'My Application'), 0, 3));

//         // Subject line
//         $subject = "Ticket #{$shortName}-{$ticketnummer} geregistreerd:";
 
//        // Search for user's contact email
//         $contact = Contact::where('id', $model->created_by_user)->first();

//         if ($contact && $contact->email) {
//             Mail::to($contact->email)
//                 ->send(new TicketToUser($model, $subject));
//         }
//     }
// });

    // static::updating(function ($model) {
    //     if ($model->employee?->email) {
    //         // Bepaal subject bij update
    //         $subject = ($model->employee_id != auth()->id())
    //             ? "🚨 Taak toegewezen aan jou: " . ($model->title ?? 'Geen titel')
    //             : "Taak geupdate: " . ($model->title ?? 'Geen titel');

    //         Mail::to($model->employee->email)
    //             ->send(new ActionToUser($model, $subject));
    //     }
    // });
//}


    public function relation()
    {
        return $this->belongsTo(Relation::class);
    }

    public function type()
    {
        return $this->belongsTo(ticketType::class, 'type_id', 'id');
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function location()
    {
        return $this->hasOne(relationLocation::class, 'id', 'location_id');
    }

 
    public function timeTracking()
    {
        return $this->hasMany(timeTracking::class, 'ticket_id', 'id');
    }

    public function AssignedByUser()
    {
        return $this->hasOne(User::class, 'id', 'assigned_by_user');
    }

    public function createByUser()
    {
        return $this->hasOne(Contact::class, 'id', 'created_by_user');
    }

    public function replies()
    {
        return $this->hasMany(ticketReplies::class);
    }

    public function object()
    {
        return $this->hasOne(ObjectsAsset::class, 'id', 'asset_id');
    }

    public function objects(): HasMany
    {
        return $this->hasMany(assetToTicket::class, 'ticket_id', 'id');

    }

}
