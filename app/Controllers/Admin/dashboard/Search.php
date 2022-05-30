<?php


namespace App\Controllers\Admin\Dashboard;


use App\Libraries\Breadcrumb;
use App\Libraries\PagesUtils;
use App\Libraries\Utils;
use App\Models\PersonaleOperativoModel;
use App\Models\SedeModel;
use CodeIgniter\Controller;
use function PHPUnit\Framework\isEmpty;

class Search extends Controller
{
    protected $breadcrumb;
    protected $usersList;
    protected $fieldList;
    protected $gradiList;
    protected $sediList;
    protected $search;

    public function __construct() {
        $this->breadcrumb = new Breadcrumb();
        $this->breadcrumb->add('Home', '/admin/dashboard');
        $this->breadcrumb->add('Ricerca Personale', '/admin/dashboard/search');
        $page = new PagesUtils( '/admin/dashboard/search','Ricerca Personale');
        $this->breadcrumb = $this->breadcrumb->render();

        $usersList = new PersonaleOperativoModel();
        $usersList = $usersList
            ->select('personale_operativo.nome, personale_operativo.cognome, 
            sede.sede_destinazione, gradi_operativi.title AS qualifica,
            personale_operativo.sesso,personale_operativo.data_di_nascita,personale_operativo.matricola,
            personale_operativo.provincia, personale_operativo.comune, personale_operativo.indirizzo,
            personale_operativo.cap, personale_operativo.numero_telefono AS telefono, 
            personale_operativo.assunzione_completo AS specifica operatore')
            ->join('sede','sede.user = personale_operativo.id')
            ->join('gradi_operativi', 'gradi_operativi.id = personale_operativo.qualifica' )
            ->get()
            ->getResultArray();

        foreach ($usersList as $user){
            unset($user['id']);
            unset($user['created_at']);
            unset($user['updated_at']);
            unset($user['user']);
            if($user['data_di_nascita'])
                $user['data_di_nascita'] = Utils::explodeDate($user['data_di_nascita']);

            $this->usersList[] = $user;
        }
        if(!empty($this->usersList)){
            $this->fieldList =array_keys($this->usersList[0]);
            $this->gradiList = Utils::getGradiList();
            $this->sediList = Utils::getSediList();
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
        if(session()->get('level') >= 6){
            $data = [
                'page_title' => 'Dashboard - Ricerca Personale',
                'breadcrumbs' => $this->breadcrumb,
                'usersList' => $this->usersList,
                'fieldList' => $this->fieldList,
                'gradiList' => $this->gradiList,
                'sediList' => $this->sediList,
                'searchList' => json_encode($this->search),
            ];
            return view("admin/pages/search", $data);
        } else {
            return redirect()->to('admin');
        }
    }

    public function filter() {
        if ($this->request->getMethod() == 'post') {

            $grado = $this->request->getVar('grado');
            $sede = $this->request->getVar('sede');


            $usersList = new PersonaleOperativoModel();
            $usersList ->select('personale_operativo.nome, personale_operativo.cognome, 
            sede.sede_destinazione, gradi_operativi.title AS qualifica,
            personale_operativo.sesso,personale_operativo.data_di_nascita,personale_operativo.matricola,
            personale_operativo.provincia, personale_operativo.comune, personale_operativo.indirizzo,
            personale_operativo.cap, personale_operativo.numero_telefono AS telefono, 
            personale_operativo.assunzione_completo AS specifica operatore')
                ->join('sede','sede.user = personale_operativo.id')
                ->join('gradi_operativi', 'gradi_operativi.id = personale_operativo.qualifica');
            if(isset($grado) && $grado != '0')
                $usersList = $usersList->where('personale_operativo.qualifica', $grado)->get()->getResultArray();
            else
                $usersList = $usersList->get()->getResultArray();

            $this->usersList = [];
            foreach ($usersList as $user){
                unset($user['id']);
                unset($user['created_at']);
                unset($user['updated_at']);
                unset($user['user']);
                $user['data_di_nascita'] = Utils::explodeDate($user['data_di_nascita']);
                if(isset($sede) && $sede != '0'){
                    if($sede == $user['sede_destinazione']){
                        $this->usersList[] = $user;
                    }
                }
                else{
                    $this->usersList[] = $user;
                }


            }
            

            if(session()->get('level') >= 6){
                $data = [
                    'page_title' => 'Dashboard - Ricerca Personale',
                    'breadcrumbs' => $this->breadcrumb,
                    'usersList' => $this->usersList,
                    'fieldList' => $this->fieldList,
                    'gradiList' => $this->gradiList,
                    'sediList' => $this->sediList,
                    'searchList' => json_encode($this->search),
                ];
                return view("admin/pages/search", $data);
            } else {
                return redirect()->to('admin');
            }
        }
    }
}