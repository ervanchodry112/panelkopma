<?php

namespace App\Controllers;

use App\Models\AnggotaModel;
use App\Models\CalonModel;
use App\Models\FakultasModel;
use App\Models\JurusanModel;
use App\Models\KegiatanModel;
use App\Models\PembayaranSimwa;
use App\Models\PoinModel;
use App\Models\ReferalModel;
use App\Models\SimpananModel;
use App\Models\Presensi;

use App\Libraries\Ciqrcode;
use App\Models\Home_model;
use Kenjis\CI3Compatible\Core\CI_Input;
use CodeIgniter\I18n\Time;

use function bin2hex;
use function file_exists;
use function mkdir;

class Dashboard extends BaseController
{

    function __construct()
    {
    }

    public function index()
    {
        $data = [
            'title' => 'Dashboard',
        ];

        return view('dashboard/index', $data);
    }
}
