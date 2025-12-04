<?php

use App\Models\tenantSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;


if (! function_exists('table_exists')) {
    function table_exists(string $tableName): bool
    {
        return Schema::hasTable($tableName);
    }
}

if (! function_exists('setting')) {
    function setting(string $key, mixed $default = null): mixed
    {
        static $settingsCache = [];

        if (table_exists('tenant_settings')) {
            if (array_key_exists($key, $settingsCache)) {
                return $settingsCache[$key];
            }

            $value = tenantSetting::where('key', $key)->value('value');

            return $settingsCache[$key] = $value ?? $default;
        }

        return $default;
    }
}
 if (! function_exists('api_response')) {
    /**
     * Return a standard API JSON response with filtering, validation, limit/offset, and pagination.
     *
     * @param \Illuminate\Database\Eloquent\Builder|Collection|array $data
     * @param \Illuminate\Http\Request|null $request
     * @param array $filterable  ['field_name' => ['allowed1', 'allowed2']]
     * @param int|null $perPage
     * @return \Illuminate\Http\JsonResponse
     */
    function api_response($data, ?Request $request = null, array $filterable = [], ?int $perPage = null)
    {
        if ($data instanceof \Illuminate\Database\Eloquent\Builder && $request) {
            foreach ($filterable as $field => $allowedValues) {
                $value = $request->query($field);

                if ($value !== null) {
                    // If $allowedValues is an array, validate
                    if (is_array($allowedValues) && !in_array($value, $allowedValues)) {
                        return response()->json([
                            'error' => "Invalid value '$value' for filter '$field'. Allowed values: " . implode(', ', $allowedValues)
                        ], 422);
                    }

                    // Apply the filter
                    $data->where($field, $value);
                }
            }

            // Handle limit/offset
            $limit = $request->query('limit', $perPage);
            $offset = $request->query('offset', 0);

            if ($limit) {
                $results = $data->skip($offset)->take($limit)->get();
                $total = $data->count();
                return response()->json([
                    'results' => $results,
                    'count' => $total,
                    'limit' => (int) $limit,
                    'offset' => (int) $offset,
                    'url' => env('APP_URL'),
                ]);
            } elseif ($perPage) {
                $results = $data->paginate($perPage);
                return response()->json([
                    'results' => $results->items(),
                    'count' => $results->total(),
                    'current_page' => $results->currentPage(),
                    'per_page' => $results->perPage(),
                    'last_page' => $results->lastPage(),
                    'url' => env('APP_URL'),
                ]);
            } else {
                $data = $data->get();
            }
        }

        $collection = $data instanceof Collection ? $data : collect($data);

        return response()->json([
            'results' => $collection,
            'count' => $collection->count(),
            'url' => env('APP_URL'),
        ]);
    }
if (! function_exists('tenant_disk')) {
    function tenant_disk(): string
    {
        $tenant = Cache::get('tenant');
        return $tenant ? 'tenant_' . $tenant->code : 'default';
    }
}


}