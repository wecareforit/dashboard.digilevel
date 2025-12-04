<?php
namespace App\Models;

use App\Enums\ActionStatus;
use App\Enums\ActionTypes;
use App\Mail\ActionToUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use OwenIt\Auditing\Contracts\Auditable;

class systemAction extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    public $table = "actions";

    protected $fillable = [
        'object_id',
        'private_action',
    ];

    protected function casts(): array
    {
        return [
            'status_id' => ActionStatus::class,
            'type_id'   => ActionTypes::class,

        ];
    }

    public function getTypeAttribute($value)
    {

        return $this->type_id->getLabel();

        //ActionTypes::values()[$this->attributes['type_id']]->label();

    }

    public function itemdata()
    {
        return $this->hasMany(ObjectInspectionData::class, 'action_id', 'id');
    }

    public function create_by_user()
    {
        return $this->hasOne(User::class, 'id', 'create_by_user_id');
    }

    public function for_user()
    {
        return $this->hasOne(User::class, 'id', 'for_user_id');
    }

    public function company()
    {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'relation_id');
    }
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            $model->create_by_user_id = $user = auth()->id();;

        });

        static::saved(function (self $request) {

            //IF NOT DIRETY
            if ($request->isDirty()) {

                $user = User::where('id', $request->for_user_id)->first();

                if ($user->id != Auth::id()) {
                    Mail::to("info@digilevel.nl")->send(new ActionToUser($request));
                }

            }
        });

    }

}
