<?php
namespace App\Services;

use App\Models\gpsObject;
use App\Models\gpsObjectData;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

final class GPSTrackingService
{
    private PendingRequest $client;
    public function __construct()
    {

        $this->client = Http::baseUrl(config('services.cargps.url'));
    }

    protected function token(): string
    {
        return config('services.cargps.token');
    }

    protected function call(string $method, string $url, array $payload): Response
    {
        $this->client
            ->withoutVerifying()
            ->withOptions(["verify" => false]);

        $response = $this->client->{$method}($url, $payload);
        return $response;
    }

    public function GetObjects(): string
    {

        $request = $this->call(method: 'get', url: '1.php', payload: [
            'key' => $this->token(),
            'api' => "pl",
            'ver' => "1.5",
            'cmd' => "GET_OBJECTS",
        ]);

        foreach ($request->json() as $data) {
            gpsObject::updateOrCreate([
                'imei' => $data['imei'],
            ], [
                'active'           => $data['active'],
                'object_expire'    => $data['object_expire'],
                'model'            => 'vehicle',
                'object_expire_dt' => $data['object_expire_dt'],
                'name'             => $data['name'] ?? '',
            ]);

        }
        return true;
    }

    public function GetObjectsData(): string
    {

        $request = $this->call(method: 'get', url: '1.php', payload: [
            'key' => $this->token(),
            'api' => "pl",
            'ver' => "1.5",
            'cmd' => "OBJECT_GET_POSITION,*",
        ]);

        foreach ($request->json() as $imei => $data) {

            $gpsobject    = gpsObject::where('imei', $imei)->first();
            $response     = (new TomTomService())->GetAddressByCoordinates($data['lat'], $data['lng']);
            $address_data = json_decode($response);

            gpsObjectData::
                updateOrCreate(
                [
                    'dt_server' => $data['dt_server'],
                    'imei'      => $imei,
                ], [

                    'dt_server'               => $data['dt_server'],
                    'dt_tracker'              => $data['dt_tracker'],
                    'vehicle_id'              => $gpsobject->vehicle_id,
                    'lat'                     => $data['lat'],
                    'lng'                     => $data['lng'],
                    'altitude'                => $data['altitude'] ?? '',
                    'angle'                   => $data['angle'] ?? '',
                    'speed'                   => $data['speed'] ?? '',
                    'params_gpslev'           => $data['params']['gpslev'] ?? '',
                    'params_pump'             => $data['params']['pump'] ?? '',
                    'params_track'            => $data['params']['track'] ?? '',
                    'params_bats'             => $data['params']['bats'] ?? '',
                    'params_acc'              => $data['params']['acc'] ?? '',
                    'params_batl'             => $data['params']['batl'] ?? '',
                    'loc_valid'               => $data['loc_valid'] ?? '',
                    'imei'                    => $imei ?? '',
                    'streetNameAndNumber'     => $address_data?->streetNameAndNumber ?? null,
                    'countryCode'             => $address_data?->countryCode ?? null,
                    'municipalitySubdivision' => $address_data?->municipality ?? null,
                    'countryCodeISO3'         => $address_data?->countryCodeISO3 ?? null,
                    'countrySubdivisionName'  => $address_data?->countrySubdivisionName ?? null,
                    'countrySubdivisionCode'  => $address_data?->countrySubdivisionCode ?? null,
                    'zipcode'                 => $address_data?->extendedPostalCode ?? null,
                ]);

        }
        return true;
    }

}
