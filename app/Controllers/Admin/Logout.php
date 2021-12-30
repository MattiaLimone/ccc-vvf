<?php


namespace App\Controllers\Admin;


use CodeIgniter\Controller;

class Logout extends Controller
{
    public function index()
    {
        session()->destroy();
        return redirect()->to('admin');
    }
}