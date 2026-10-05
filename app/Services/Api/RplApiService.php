<?php

namespace App\Services\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class RplApiService
{
    protected Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 5,
            'connect_timeout' => 3,
        ]);
    }

    public function getRPL(string $nim): array
    {
        $default = [
            'sksrpl' => 0,
            'ipkrpl' => 0,
        ];

        try {
            $response = $this->client->get(
                config('services.lkam.url'),
                [
                    'query' => [
                        'nim' => $nim,
                    ],
                ]
            );

            $data = json_decode(
                $response->getBody()->getContents()
            );

            if (!is_array($data) || empty($data)) {
                return $default;
            }

            /*
             * API mengembalikan:
             * ["Data mahasiswa tidak tersedia"]
             */
            if (
                isset($data[0]) &&
                is_string($data[0]) &&
                $data[0] === 'Data mahasiswa tidak tersedia'
            ) {
                return $default;
            }

            $footer = $data[0]->footer[0] ?? null;

            if (!$footer) {
                return $default;
            }

            return [
                'sksrpl' => $footer->sksrpl ?? 0,
                'ipkrpl' => $footer->ipkrpl ?? 0,
            ];

        } catch (GuzzleException $e) {

            Log::warning('Gagal mengambil data RPL', [
                'nim' => $nim,
                'error' => $e->getMessage(),
            ]);

            return $default;
        }
    }
}
