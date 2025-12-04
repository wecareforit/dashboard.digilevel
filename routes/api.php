<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\checkApiToken;
use App\Models\Contact;
use App\Models\Relation;
use App\Models\Task;

Route::middleware([checkApiToken::class, 'apilogger'])->group(function () {

    // Contacts endpoint
        Route::get('/contacts', function (Request $request) {
        $query = Contact::select(
            'id', 'first_name', 'last_name', 'relation_id','department', 'function', 'email', 'location_id', 'type_id', 'company'
        );
        $filterable = [
            'id'         => null, 
            'type_id'    => [1,2],
            'department' => null,  
        ];
            return api_response($query, $request, $filterable, 10);
        });

     // Relation endpoint
        Route::get('/relations', function (Request $request) {
        $query = Relation::select(
            'id', 'name', 'zipcode', 'place','address', 'country', 'website', 'emailaddress', 'type_id', 'remark'
        );

        $filterable = [
            'id'         => null, 
            'type_id'    => [1,2],
            'department' => null,  
        ];
            return api_response($query, $request, $filterable, 10);
        });

      // Tasks endpoint
        Route::get('/tasks', function (Request $request) {
        $query = Task::select(
            'id', 'title', 'description', 'relation_id','project_id', 'type_id', 'employee_id', 'deleted_at','priority','begin_date','deadline'
        );
        
        $filterable = [
            'id'         => null, 
            'type_id'    => [1,2],
            'department' => null,  
        ];
            return api_response($query, $request, $filterable, 10);
        });

});