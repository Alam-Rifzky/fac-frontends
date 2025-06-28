<?php

namespace App\Services;

use Config\Facport;
use CodeIgniter\HTTP\CURLRequest;

class FacportService
{
    protected CURLRequest $client;
    protected string $baseURL;

    public function __construct()
    {
        $this->client  = service('curlrequest');
        $this->baseURL = (new Facport())->baseURL;
    }

    /**
     * Ambil daftar modul & item-itemnya.
     *
     * @return array ['Modul Buku Besar' => [...], ...]
     */
    public function getModules(): array
    {
        $url  = "{$this->baseURL}/items?q=modules";
        $resp = $this->client->get($url, ['verify' => false])->getBody();
        $json = json_decode($resp, true);

        if (! isset($json['data']) || ! is_array($json['data'])) {
            return []; // atau lempar exception
        }

        // mapping module → items
        $map = [];
        foreach ($json['data'] as $row) {
            $map[$row['module']] = $row['items'];
        }

        return $map;
    }
}
