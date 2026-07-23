<?php

namespace App\Services;

use App\Models\Customer;
use Illuminate\Support\Facades\Http;

class ElasticsearchService
{
    private string $baseUrl;
    protected string $index;

    public function __construct()
    {
        $this->baseUrl = config('elasticsearch.url');
        $this->index = 'customers';
    }

    public function indexCustomer(Customer $customer)
    {
        return Http::put(
            "{$this->baseUrl}/{$this->index}/_doc/{$customer->id}",
            [
                'id' => $customer->id,
                'first_name' => $customer->first_name,
                'last_name' => $customer->last_name,
                'email' => $customer->email,
                'contact_number' => $customer->contact_number,
            ]
        );
    }

    public function deleteCustomer(Customer $customer)
    {
        return Http::delete(
            "{$this->baseUrl}/{$this->index}/_doc/{$customer->id}"
        );
    }

    public function searchCustomers(string $query)
    {
        $response = Http::post(
            "{$this->baseUrl}/{$this->index}/_search",
            [
                "query" => [
                    "multi_match" => [
                        "query" => $query,
                        "fields" => [
                            "first_name",
                            "last_name",
                            "email",
                            'contact_number',
                        ]
                    ]
                ]
            ]
        )->json();

        return collect($response['hits']['hits'] ?? [])->map(function ($hit) {
            return $hit['_source'];
        })->values();
    }
}
