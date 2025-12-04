<?php
namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

final class EBoekhouden
{
    private PendingRequest $client;
    public $secretToken = null;
    public function __construct()
    {
        $this->client = Http::baseUrl(config('services.eboekhouden.url'));
    }

    protected function call(string $method, string $url, array $payload): Response
    {

        $response = $this->client->{$method}($url, $payload);
        return $response;

    }

    public function GetToken(): string
    {
        $request = $this->call(method: 'post', url: 'v1/session', payload: [
            'accessToken' => '078x2Qg6oDnYOpBd4O4xZvrGKXBj6klsrshZhRnKg4RWpvDqz0',
            "source"      => "Postman",
        ]);
        $this->secretToken = $request->json('token');
        return $this->secretToken;
    }

    protected function callToken(string $method, string $url, array $payload): Response
    {
        if (! $this->secretToken) {
            $this->GetToken();
        }
        $this->client
            ->withoutVerifying()
            ->withOptions(["verify" => false])
            ->withToken($this->secretToken);
        $response = $this->client->{$method}($url, $payload);
        return $response;
    }

    public function GetRelations(): string
    {
        $token   = $this->gettoken();
        $request = $this->callToken(method: 'get', url: 'v1/relation', payload: []);

        foreach ($request->json()['items'] as $data) {

            $relation_data = $this->callToken(method: 'get', url: 'v1/relation/' . $data['id'], payload: []);

            \App\Models\Relation::updateOrCreate([
                'external_id' => $relation_data['id'],
            ], [
                'name'        => $relation_data['name'] ?? '',
                'source'      => 'eboekhouden' ?? '',
                'external_id' => $data['id'] ?? '',
                // 'email'         => $data['email'] ?? '',
                // 'phone'         => $data['phone'] ?? '',
                // 'street'        => $data['street'] ?? '',
                // 'house_number'  => $data['house_number'] ?? '',
                // 'postal_code'   => $data['postal_code'] ?? '',
                // 'city'          => $data['city'] ?? '',
                // 'country_code'  => $data['country_code'] ?? '',
                // 'relation_type' => $data['relation_type'] ?? '',
            ]);

            //  return $request;

        }
        return true;

        //   return $request;
    }

}
