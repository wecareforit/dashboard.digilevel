<?php
namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

final class RDWService
{
    private PendingRequest $client;
    public function __construct()
    {
        $this->client = Http::baseUrl(config('services.rdw.url'));
    }

    protected function call(string $method, string $url, array $payload): Response
    {
        $this->client->withHeaders(['x-api-key' => config('services.rdw.token')]);
        $response = $this->client->{$method}($url, $payload);
        return $response;
    }

    public function GetVehicle(string $licenseplate): string
    {
        $licenseplate = strtoupper(preg_replace('/[^a-z0-9 ]/i', '', $licenseplate));
        $request      = $this->call(method: 'get', url: '/m9d7-ebf2.json', payload: [
            'kenteken' => $licenseplate,
        ]);
        //  dd(collect($request->json()));
        return collect($request->json());
    }
}
