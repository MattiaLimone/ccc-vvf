<?php


namespace App\Controllers\Admin;

use CodeIgniter\Controller;

class Home extends Controller
{
    public function index()
    {
        return redirect()->to(site_url('admin/login'));
    }
}
