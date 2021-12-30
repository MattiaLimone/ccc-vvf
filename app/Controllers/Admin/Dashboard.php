<?php

namespace App\Controllers\Admin;


use App\Libraries\Breadcrumb;
use App\Libraries\PagesUtils;
use App\Models\FonogrammaModel;
use App\Models\PersonaleOperativoModel;
use CodeIgniter\Controller;

class Dashboard extends Controller
{
    protected $breadcrumb;
    protected $search;
    protected $userCount;
    protected $fonogrammi;

    public function __construct() {
        $this->breadcrumb = new Breadcrumb();
        $this->breadcrumb->add('Home', '/admin/dashboard');
        $page = new PagesUtils('/admin/dashboard','Dashboard');
        $this->breadcrumb = $this->breadcrumb->render();
        $results = $page->getAll();
        $counter = 0;
        foreach ($results as $result) {
            $this->search[$counter]['label'] = $result['title'];
            $this->search[$counter]['value'] = base_url($result['link']);
            $counter++;
        }
        $userCount = new PersonaleOperativoModel();
        $this->userCount = $userCount->select()->countAllResults();

        $fonogramma = new FonogrammaModel();
        $this->fonogrammi = $fonogramma->select('personale_operativo.nome, personale_operativo.cognome, sede.sede_destinazione, fonogramma.*')
            ->join('sede', 'fonogramma.user = sede.user', 'left')
            ->join('personale_operativo','fonogramma.user = personale_operativo.id', 'left')
            ->orderBy('created_at','DESC')
            ->limit(10)
            ->get()->getResultArray();
    }

    public function index()
    {
        $data = [
            'page_title' => 'Dashboard',
            'breadcrumbs' => $this->breadcrumb,
            'searchList' => json_encode($this->search),
            'userCount' => $this->userCount,
            'fonogrammi' => $this->fonogrammi
        ];
        return view("admin/dashboard", $data);

    }
}