<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Facport extends BaseConfig
{
    public string $baseURL;

    public function __construct()
    {
        parent::__construct();
        $this->baseURL = getenv('API_FACPORT') ?: 'https://fac-institute.com/facport';
    }
}
