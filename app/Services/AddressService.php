<?php

namespace App\Services;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;


final class AddressService 
{
    private PendingRequest $client;
    public function __construct()
    {
        $this->client = Http::baseUrl(config('services.pro6pp.url'));
    }

    protected function token(): string
    {
        return config('services.pro6pp.token');
    }

    protected function call(string $method, string $url, array $payload): Response
    {
        $this->client
            ->withoutVerifying()
            ->withOptions(["verify"=>false]);

        $response = $this->client->{$method}($url, $payload);
        return $response;
    }

    public function GetAddress(string $postalcode,$number): string
    {

        if (!isset($number))
        { 
            $number  = 1;
        };                        ; 

        $postalcode = strtoupper(preg_replace('/\s+/', '', $postalcode));
        $request = $this->call(method: 'get', url: '/v2/autocomplete/nl', payload: [
            'authKey'       => $this->token(),
            'postalCode'    => $postalcode,
            'streetNumber'  => $number
        ]);
 
         return collect($request->json());       

    }
}
