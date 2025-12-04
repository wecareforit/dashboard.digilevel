<?php
namespace App\Console\Commands;

use App\Models\Elevator;
use App\Models\external;
use App\Models\ExternalApiLog;
use DB;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ImportChex extends Command
{
    protected $signature   = "app:import-chex";
    protected $description = "Import Chex inspections";

    public function handle()
    {
 
 if (env('CHEX_TOKEN')) {
            try {
                $url                = config("services.chex.url") . "/inspections";
                $schedule_run_token = Str::random();

                $response = Http::withoutVerifying()->withHeaders([
                    "Authorization" => config("services.chex.token"),
                ])->get($url, [
                    "fromDate" => $data->from_date ?? "2025-01-01",
                    //date('Y-m-d'),
                ]);

                $records = json_decode($response->getBody())->result;

                foreach ($records as $item) {
                    switch ($item->status) {
                        case "Goedgekeurd":
                            $status_id = 1;
                            break;
                        case "Goedgekeurd met acties":
                            $status_id = 2;
                            break;
                        case "Afgekeurd":
                            $status_id = 3;
                            break;
                        case "Onbeslist":
                            $status_id = 4;
                            break;
                    }

                    $elevator_information = Elevator::where(
                        "nobo_no",
                        $item->objectId
                    )->first();

                    $inspection_insert = DB::table('elevator_inspections')->updateOrInsert(
                        ["external_uuid" => $item->inspectionId],

                        [
                            "status_id"             => $status_id,
                            "inspection_company_id" => config("services.chex.company_id"),
                            "type"                  => $item->inspectionType,
                            "nobo_number"           => $item->objectId,
                            "object_id"           => $elevator_information?->id,
                            "executed_datetime"     => $item->inspectionDate,
                            "if_match"              => isset($elevator_information->id) ? 1 : 0,
                            "end_date"              => $item->expiryDate,
                            "schedule_run_token"    => $schedule_run_token,

                        ]
                    );

                    $inspection_data_from_db = DB::table('elevator_inspections')
                        ->where('status_id', $status_id)
                        ->where('nobo_number', $item->objectId)
                        ->where('object_id', $elevator_information?->id)
                        ->where('schedule_run_token', $schedule_run_token)

                        ->first();

                    //get last info

                    $url = config("services.chex.url") . "/inspections/" . $item->inspectionId;

                    $response = Http::withoutVerifying()->withHeaders([
                        "Authorization" => config("services.chex.token"),
                    ])->get($url);

                    $records       = json_decode($response->getBody())->result;
                    $inspection_id = DB::table('elevator_inspections')->where(
                        "external_uuid",
                        $item->inspectionId
                    )->update([
                        "document"      => $records->reportData,
                        "certification" => $records->certificateData,
                    ]);

                    //Check of of er goedgekeurd is met acties
                    if ($records->comments && $status_id == 1) {
                        DB::table('elevator_inspections')->where('external_uuid', $item->inspectionId)->update(['status_id' => 2]);
                    }

                    foreach ($records->comments as $item) {
                        if ($item->status == "Herhaling") {
                            DB::table('elevator_inspections')->where(
                                "external_uuid",
                                $inspection_data_from_db->external_uuid
                            )->update(["status_id" => 6]);
                        }

                        DB::table('elevator_inspection_data')->updateOrInsert(
                            [
                                "inspection_id" => $inspection_data_from_db->id,
                                "zin_code"      => $item->code,
                            ],
                            [
                                "zin_code"           => $item->code,
                                "comment"            => $item->comment,
                                "type"               => $item->type,
                                "inspection_id"      => $inspection_data_from_db->id,
                                "status"             => $item->status,
                                "schedule_run_token" => $schedule_run_token,
                            ]
                        );
                    }
                }

                $logitem = "Check keuringsrapportage opgehaald ";

            } catch (Exception $e) {
                $logitem = "foutmelding" . $e->getMessage();

            }

            // DB::table('external')->where('id', $data->id)->update([
            //     'from_date' => date('Y-m-d'),
            // ]);

            ExternalApiLog::insert(
                [
                    "model"              => "ElevatorInspection",
                    "logitem"            => $logitem,
                    "model_sub"          => 'Chex',
                    "status_id"          => '1',
                    "schedule_run_token" => $schedule_run_token,
                ]

            );
        }
    }
}
