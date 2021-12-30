<?php


namespace App\Controllers\Admin\Dashboard;

use App\Libraries\Breadcrumb;
use App\Libraries\PagesUtils;
use App\Libraries\Utils;
use App\Models\GradiModel;
use App\Models\PersonaleOperativoModel;
use App\Models\SedeModel;
use App\Models\SpecsModel;
use CodeIgniter\Controller;
use Config\Paths;
class Formation extends Controller
{

    protected $breadcrumb;
    protected $usersList;
    protected $fieldList;
    protected $gradiList;
    protected $sediList;
    protected $search;

    public function __construct()
    {
        $this->breadcrumb = new Breadcrumb();
        $this->breadcrumb->add('Home', '/admin/dashboard');
        $this->breadcrumb->add('Formazione', '/admin/dashboard/formation');
        $page = new PagesUtils('/admin/dashboard/formation', 'Storico Formazione');
        $this->breadcrumb = $this->breadcrumb->render();

        $user = new PersonaleOperativoModel();
        $user = $user->select('nome, cognome, codice_fiscale')->get()->getResultArray();
        $this->usersList = array();
        $counter = 0;
        foreach ($user as $row) {
            $this->usersList[$counter]['label'] = $row['nome'] .' '. $row['cognome'] .' - '.$row['codice_fiscale'];
            $this->usersList[$counter]['value'] = $row['codice_fiscale'];
            $counter++;
        }

        $results = $page->getAll();
        $counter = 0;
        foreach ($results as $result) {
            $this->search[$counter]['label'] = $result['title'];
            $this->search[$counter]['value'] = base_url($result['link']);
            $counter++;
        }
    }

    public function index()
    {
        if (session()->get('level') >= 8) {
            $data = [
                'page_title' => 'Dashboard - Formazione',
                'breadcrumbs' => $this->breadcrumb,
                'searchList' => json_encode($this->search),
                'usersList' => json_encode($this->usersList),
            ];
            return view("admin/pages/formation", $data);
        } else {
            return redirect()->to('admin');
        }
    }

    public function getData(){
        if ($this->request->getMethod() == 'post' && !empty($this->request->getVar('codice_fiscale'))) {
            $user =  new PersonaleOperativoModel();
            $user = $user
                ->where('codice_fiscale', $this->request->getVar('codice_fiscale'))
                ->get()
                ->getRowArray();
            if(!empty($user['id'])){
                $specs = new SpecsModel();
                $specs = $specs
                    ->where('user',$user['id'])
                    ->get()
                    ->getResultArray();
                return json_encode($specs);
            }
        }
    }

    public function addSpecs() {
        $error = null;
        $success = null;
        if ($this->request->getMethod() == 'post' && !empty($this->request->getVar('userID')) && !empty($this->request->getVar('spec'))) {
            $specializzazione = new SpecsModel();
            $dataSpec = [
                'user' => $this->request->getVar('userID'),
                'qualifica' => $this->request->getVar('spec'),
            ];
            if(!$specializzazione->insert($dataSpec)){
                $error[] ="Errore nell'inserimento della qualifica ".$this->request->getVar('spec')." nel database formazione";
            } else {
                $success[] = $this->request->getVar('spec'). " aggiunta con successo";

            }
            $data = [
                'page_title' => 'Dashboard - Formazione',
                'breadcrumbs' => $this->breadcrumb,
                'searchList' => json_encode($this->search),
                'usersList' => json_encode($this->usersList),
                'validation' => $error,
                'success' => $success,
            ];
            return view("admin/pages/formation", $data);
        }
    }
}