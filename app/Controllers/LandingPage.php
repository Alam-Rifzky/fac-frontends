<?php

namespace App\Controllers;

use App\Services\FacportService;

class LandingPage extends BaseController
{
    protected FacportService $facport;

    public function __construct()
    {
        $this->facport = new FacportService();
    }

    public function index()
    {
        // ----- ambil data API -----
        $modules = $this->facport->getModules();

        // ----- rakit objek $data (sesuai kebutuhan view Anda) -----
        $data = (object) [
            'judul'        => 'Implementor Resmi Training Accurate',
            'modul'        => $modules,
            'reqaccess'    => array_keys($modules),      // contoh: akses apa saja
            'reqdbaccess'  => [],                        // sesuaikan sendiri
        ];

        return view('landing_page', ['data' => $data]);
    }
}
