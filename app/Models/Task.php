<?php
namespace App\Models;

use App\Enums\ActionTypes;
use App\Enums\Priority;
use App\Enums\TaskTypes;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Relaticle\CustomFields\Models\Concerns\UsesCustomFields;
use Relaticle\CustomFields\Models\Contracts\HasCustomFields;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Support\Facades\Mail;
use App\Mail\ActionToUser;


class Task extends Model implements HasCustomFields
{
    use HasFactory;
    use UsesCustomFields;
    use SoftDeletes;
    use LogsActivity;

    /**
     * @var string[]
     */
    protected $casts = [
        'metadata' => 'collection',
    ];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'text']);
    }
    protected function casts(): array
    {
        return [

            'priority'  => Priority::class,
            'type'      => TaskTypes::class,

        ];
    }


protected static function booted()
{
static::creating(function ($model) {
    $model->make_by_employee_id = auth()->id();

    // Alleen mail verzenden als de taak aan iemand anders wordt toegewezen
    if ($model->employee_id != auth()->id() && $model->employee?->email) {
        $subject = "🚨 Taak toegewezen aan jou: " . ($model->title ?? 'Geen titel');

        Mail::to($model->employee->email)
            ->send(new ActionToUser($model, $subject));
    }
});

static::updating(function ($model) {
    // Alleen mail verzenden als de taak aan iemand anders wordt toegewezen
    if ($model->employee_id != auth()->id() && $model->employee?->email) {
        $subject = "🚨 Taak toegewezen aan jou: " . ($model->title ?? 'Geen titel');

        Mail::to($model->employee->email)
            ->send(new ActionToUser($model, $subject));
    }
});
}

    public function employee()
    {
        return $this->hasOne(User::class, 'id', 'employee_id');
    }

       public function make_by_employee()
    {
        return $this->hasOne(User::class, 'id', 'make_by_employee_id');
    }



    public function getRelatedToAttribute()
    {

        // switch ($this->model) {
        //     case 'relation':
        return Relation::whereId($this->relation_id)->first();
        //     break;
        // case 'project':
        //     return Project::whereId($this->model_id)->first();
        //     break;
        // case 'location':
        //     return ObjectLocation::whereId($this->model_id)->first();
        //     break;
        // case 'object':
        //     return ObjectsAsset::whereId($this->model_id)->first();
        //     break;
        // case 'contactperson':
        //     return Contact::whereId($this->model_id)->first();
        //     break;
        // default:
        //code block

    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function relations()
    {
        return $this->belongsTo(Relation::class);
    }

}
