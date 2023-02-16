<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Pdf extends BaseController
{
    public function view()
    {
        $file = $this->request->getGet('file');
        $type = $this->request->getGet('type');

        $data = [
            'title' => 'PDF Viewer',
            'file' => "$type/$file"
        ];

        return view('pdf/view', $data);
    }
}
