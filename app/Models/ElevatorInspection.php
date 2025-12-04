<?php
namespace App\Models;

use App\Enums\InspectionStatus;
use App\Models\ObjectsAsset;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ElevatorInspection extends Model
{
    use SoftDeletes;
    protected function casts(): array
    {
        return [
            'status_id'        => InspectionStatus::class,
            'latestInspection' => InspectionStatus::class,
        ];
    }

    public function elevator()
    {
        return $this->belongsTo(Elevator::class, 'nobo_number', 'nobo_no');
    }

    public function itemdata()
    {
        return $this->hasMany(ObjectInspectionData::class, 'inspection_id', 'id');
    }

    public function actions()
    {
        return $this->hasMany(systemAction::class, 'item_id', 'id')->where('model', 'ObjectInspection');
    }

    public function inspectioncompany()
    {
        return $this->belongsTo(Relation::class, 'inspection_company_id', 'id')->withTrashed();
    }

    protected static function boot(): void
    {
        parent::boot();

        static::saving(function ($model) {
            //     $model->company_id = Filament::getTenant()->id;
        });

        static::saved(function (self $request) {

            $elevator_data = Elevator::query()
                ->whereHas('latestInspection', fn($subQuery) => $subQuery
                        ->whereColumn('id', DB::raw('(SELECT id FROM object_inspections  WHERE  object_inspections.object_id = elevators.id and deleted_at is null ORDER BY end_date DESC LIMIT 1)'))
                        ->where('object_id', $request->object_id)

                )->first();

            Elevator::where('id', $request->object_id)->update([
                'current_inspection_end_date'  => $elevator_data->latestInspection->end_date ?? null,
                'current_inspection_status_id' => $elevator_data->latestInspection->status_id ?? null,
            ]);

        });

    }
 
    //     static::saved(function (self $request) {

    //         $elevators = ObjectsAsset::query()
    //         ->whereHas('latestInspection', fn($subQuery) => $subQuery
    //                 ->where('end_date', '<', Carbon::today())
    //                 ->whereColumn('id', DB::raw('(SELECT id FROM object_inspections WHERE object_inspections.object_id = elevators.id and deleted_at is null ORDER BY end_date DESC LIMIT 1)'))
    //         )
    //         ->where('id', $request->object_id)
    //         ->first();

    //         ObjectsAsset::where('id', $request->object_id)->update([
    //             'current_inspection_end_date'  => $elevator->latestInspection->end_date ?? null,
    //             'current_inspection_status_id' => $elevator->latestInspection->status_id ?? null,
    //         ]);

    //     )};

}
