<?php
namespace App\Models;

//use App\Enums\TicketStatus;
use App\Enums\TimeTrackingStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Contracts\Auditable;
use Parallax\FilamentComments\Models\Traits\HasFilamentComments;
use Relaticle\CustomFields\Models\Concerns\UsesCustomFields;
use Relaticle\CustomFields\Models\Contracts\HasCustomFields;

class timeTracking extends Model implements Auditable, HasCustomFields
{

    use SoftDeletes;
    use HasFilamentComments;
    use UsesCustomFields;
    use \OwenIt\Auditing\Auditable;
    public $table       = "time_tracking";
    protected $fillable = ['description', 'weekno', 'relation_id', 'project_id', 'status_id', 'work_type_id', 'invoiceable'];


 

    protected static function boot(): void
    {

        parent::boot();

        static::saving(function ($model) {
            $model->weekno = date("W", strtotime($model->started_at));
            if (! $model['user_id']) {
                $model['user_id'] = auth()->id();
            }
        });



    }
    public function status()
    {
        return $this->hasOne(ticketStatus::class, 'id', 'ticket_status_id');
    }
    protected function casts(): array
    {
        return [
            'status_id' => TimeTrackingStatus::class,
            //  'ticket_status_id' => TicketStatus::class,
        ];
    }

    public function relation()
    {
        return $this->belongsTo(Relation::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function activity()
    {
        return $this->hasOne(workorderActivities::class, 'id', 'work_type_id');
    }

    public function user()
    {
        return $this->belongsTo(user::class);
    }

}
