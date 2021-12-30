<?php


namespace App\Controllers\Admin\Dashboard;


use App\Libraries\Breadcrumb;
use App\Libraries\PagesUtils;
use App\Libraries\Utils;
use App\Models\FonogrammaModel;
use App\Models\PersonaleOperativoModel;
use App\Models\SedeModel;
use CodeIgniter\Controller;
use Spipu\Html2Pdf\Html2Pdf;

class Fonogramma extends Controller
{

    protected $breadcrumb;
    protected $search;
    protected $sedi;

    public function __construct()
    {
        $this->breadcrumb = new Breadcrumb();
        $this->breadcrumb->add('Home', '/admin/dashboard');
        $this->breadcrumb->add('Elenco Fonogrammi', '/admin/dashboard/fonogramma/all');
        $this->breadcrumb->add('Crea Fonogramma', '/admin/dashboard/fonogramma');
        $page = new PagesUtils('/admin/dashboard/fonogramma', 'Crea Fonogramma');

        $this->breadcrumb = $this->breadcrumb->render();


        $results = $page->getAll();
        $counter = 0;
        foreach ($results as $result) {
            $this->search[$counter]['label'] = $result['title'];
            $this->search[$counter]['value'] = base_url($result['link']);
            $counter++;
        }

        $user = new PersonaleOperativoModel();
        $user = $user->select('nome, cognome, codice_fiscale')->get()->getResultArray();
        $this->usersList = array();
        $counter = 0;
        foreach ($user as $row) {
            $this->usersList[$counter]['label'] = $row['nome'] .' '. $row['cognome'] .' - '.$row['codice_fiscale'];
            $this->usersList[$counter]['value'] = $row['codice_fiscale'];
            $counter++;
        }

        $sedeSlave = new SedeModel();
        $this->sedi =$sedeSlave->select('codice_tc, sede_destinazione')->distinct()->orderBy('sede_destinazione', 'ASC')->get()->getResultArray();
    }
    public function index()
    {
        if (session()->get('level') >= 8) {
            $data = [
                'page_title' => 'Dashboard - Fonogramma',
                'breadcrumbs' => $this->breadcrumb,
                'searchList' => json_encode($this->search),
                'usersList' => json_encode($this->usersList),
                'sediList' => $this->sedi,
            ];
            return view("admin/pages/fonogramma", $data);
        } else {
            return redirect()->to('admin');
        }
    }
    public function getAll()
    {
        $this->breadcrumb = new Breadcrumb();
        $this->breadcrumb->add('Home', '/admin/dashboard');
        $this->breadcrumb->add('Elenco Fonogrammi', '/admin/dashboard/fonogramma/all');
        $page = new PagesUtils('/admin/dashboard/fonogramma/all', 'Elenco Fonogrammi');

        $this->breadcrumb = $this->breadcrumb->render();
        if (session()->get('level') >= 6) {
            $fonogramma = new FonogrammaModel();
            $fonogramma = $fonogramma->select('personale_operativo.nome, personale_operativo.cognome, sede.sede_destinazione, fonogramma.*')
                ->join('sede', 'fonogramma.user = sede.user', 'left')
                ->join('personale_operativo','fonogramma.user = personale_operativo.id', 'left')
                ->get()->getResultArray();

            $data = [
                'page_title' => 'Dashboard - Fonogramma',
                'breadcrumbs' => $this->breadcrumb,
                'searchList' => json_encode($this->search),
                'usersList' => json_encode($this->usersList),
                'sediList' => $this->sedi,
                'fonogramma' => $fonogramma,
            ];
            return view("admin/pages/fonogrammaList", $data);
        } else {
            return redirect()->to('admin');
        }
    }
    public function getData(){
        if ($this->request->getMethod() == 'post') {
            $user =  new PersonaleOperativoModel();
            $user = $user
                ->where('codice_fiscale', $this->request->getVar('codice_fiscale'))
                ->join('sede','sede.user = personale_operativo.id')
                ->get()
                ->getResultArray();



            return json_encode($user);
        }
    }
    public function getPdf(){
        if ($this->request->getMethod() == 'post') {
            $fonogramma = new FonogrammaModel();
            $fonogramma = $fonogramma->select('personale_operativo.nome, personale_operativo.cognome, fonogramma.*')
                ->where('fonogramma.id',$this->request->getVar('id'))
                ->join('personale_operativo','fonogramma.user = personale_operativo.id', 'left')
                ->first();
            $html2pdf = new Html2Pdf('P', 'A4', 'it',true, 'UTF-8');
            $html2pdf->writeHTML($fonogramma['testo']);
            $html2pdf->output($fonogramma['nome'].'_'.$fonogramma['cognome'].'_'.$fonogramma['id'].'.pdf','D');
        }
    }
    public function newEntry() {
        $error = null;
        $success = null;
        if ($this->request->getMethod() == 'post') {
            $rules = [
                'cf' => 'required|max_length[16]|alpha_numeric',
                'email' => 'required|max_length[45]|valid_email',
                'personale' => 'required',
                'comunicazione' => 'required',
                'phone' => 'required|numeric',
                'sede' => 'required',
                'textEditor' => 'required',

            ];
            $errors = [];
            if (!$this->validate($rules, $errors)) {
                $data = [
                    'page_title' => 'Dashboard - Fonogramma',
                    'breadcrumbs' => $this->breadcrumb,
                    'searchList' => json_encode($this->search),
                    'usersList' => json_encode($this->usersList),
                    'sediList' => $this->sedi,
                    'validation' => $this->validator,
                ];
                return view("admin/pages/fonogramma", $data);
            } else {
                $user = new PersonaleOperativoModel();
                $user = $user->select('id')
                    ->where('codice_fiscale',$this->request->getVar('cf'))
                    ->first();

                $fonogramma = new FonogrammaModel();
                $dataFonogramma = [
                    'user' => $user['id'],
                    'email' => $this->request->getVar('email'),
                    'phone' => $this->request->getVar('phone'),
                    'turno' => $this->request->getVar('turno'),
                    'comunicazione' =>$this->request->getVar('comunicazione'),
                    'sede'=>$this->request->getVar('sede'),
                    'testo' =>$this->request->getVar('textEditor'),
                ];
                if(!$fonogramma->insert($dataFonogramma)){
                    $error[] ="Errore nell'inserimento del fonogramma relativo a ".$this->request->getVar('cf');
                } else {
                    $success = "Fonogramma aggiunto con successo";
                }
                $data = [
                    'page_title' => 'Dashboard - Fonogramma',
                    'breadcrumbs' => $this->breadcrumb,
                    'searchList' => json_encode($this->search),
                    'usersList' => json_encode($this->usersList),
                    'sediList' => $this->sedi,
                    'validation' => $error,
                    'success' => $success,
                ];
                return view("admin/pages/fonogramma", $data);
            }
        }
    }
}