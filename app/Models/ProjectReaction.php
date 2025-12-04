<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ProjectReaction extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    public static function boot()
    {

        parent::boot();

        //Insert the userID
        static::created(function ($item) {
            //  $item->user_id = Auth::id();
            Project::where('id', $item->project_id)->update(['status_id' => $item->status_id]);

        });

        static::updating(function ($item) {
            //  $item->user_id = Auth::id();

            Project::where('id', $item->project_id)->update(['status_id' => $item->status_id]);

        });

    }

    // Attributes that should be mass-assignable
    protected $fillable = ['reaction', 'status_id', 'user_id'];

    public function status()
    {
        return $this->belongsTo(ProjectStatus::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
