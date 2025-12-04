<?php
namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

final class TomTomService
{
    private PendingRequest $client;
    public function __construct()
    {
        $this->client = Http::baseUrl(config('services.tomtom.url'));
    }

    protected function token(): string
    {
        return config('services.tomtom.token');
    }

    protected function call(string $method, string $url, array $payload): Response
    {
        $this->client
            ->withoutVerifying()
            ->withOptions(["verify" => false]);

        $response = $this->client->{$method}($url, $payload);
        return $response;
    }

    public function GetAddressByCoordinates(string $lon, string $lat): string
    {
        $request = $this->call(method: 'get', url: '/reverseGeocode/' . $lon . ',' . $lat . '.json', payload: [
            'key' => $this->token(),

        ]);

        return collect($request->json()['addresses'][0]['address']);

    }
}
