<?php

use App\Http\Controllers\ObjectMonitoringController;
use App\Services\EBoekhouden;
use Illuminate\Support\Facades\Artisan;

Route::get('/monitoring/retrieveInfo', [ObjectMonitoringController::class, 'retrieveInfo']);

Route::get('/run-migration', function () {
    Artisan::call('migrate --force');
    return redirect('/');
});


Route::get('/tenant-not-found', function () {
    return view('errors.tenant-not-found');
})->name('tenant.notfound');


Route::get('/tenants/{tenant}/{path}', function ($tenant, $path) {
    $file = storage_path("app/tenants/{$tenant}/{$path}");
    if (!file_exists($file)) {
        abort(404);
    }
    return response()->file($file);
})->where('path', '.*');



Route::get('/setup', function () {


    //Check if 
    // Run all migrations
    Artisan::call('migrate', [
        '--force' => true, // ensures it runs even in production
    ]);

    // Run the database seeder
    Artisan::call('db:seed', [
        '--class' => 'DatabaseSeeder',
        '--force' => true, // ensures it runs even in production
    ]);

 
    $output = Artisan::output();
    dd($output);

    return redirect('/'); // redirect to home page
});

Route::get('/test-service', function (EBoekhouden $service) {
    return $service->GetRelations();
});
