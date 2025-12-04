<?php

if (env('CHEX_TOKEN')) {
//Inspections - Check
    Schedule::command('app:import-chex')
        ->appendOutputTo('checx.log')
        ->everyMinute()
        ->between('10:00', '21:00');
}
//Monitoring - Modusystem
// if (config("services.modusystem.username")) {
//     Schedule::command('app:m-q-t-t-modusystem')
//         ->between('12:00', '23:59')
//         ->everyFiveMinutes();
// }

//GPS - LoveTracking
if (env('GPS_TRACKING_KEY')) {
    Schedule::call(function () {
        $objects = (new GPSTrackingService())->GetObjects();
    })
    // ->between('6:00', '23:59')
        ->everyMinute()
        ->appendOutputTo("tacking.text");

    Schedule::call(function () {
        $objects = (new GPSTrackingService())->GetObjectsData();
    })
    // ->between('6:00', '23:59')
        ->everyMinute()
        ->appendOutputTo("tacking.text");
}
