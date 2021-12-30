<?php


namespace App\Controllers\Admin\Dashboard;


use App\Libraries\Breadcrumb;
use App\Libraries\PagesUtils;
use App\Libraries\Utils;
use App\Models\PersonaleOperativoModel;
use App\Models\SedeModel;
use CodeIgniter\Controller;

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
            ->join('sede','sede.user = personale_operativo.id')
            ->get()
            ->getResultArray();

        foreach ($usersList as $user){
            unset($user['id']);
            unset($user['created_at']);
            unset($user['updated_at']);
            unset($user['user']);
            $user['data_di_nascita'] = Utils::explodeDate($user['data_di_nascita']);
            $user['data_inizio_qualifica'] = Utils::explodeDate($user['data_inizio_qualifica']);
            $user['data_assunzione'] = Utils::explodeDate($user['data_assunzione']);
            $user['data_assegnazione'] = Utils::explodeDate($user['data_assegnazione']);
            $user['data_cessazione'] = Utils::explodeDate($user['data_cessazione']);
            $user['data_reintegro'] = Utils::explodeDate($user['data_reintegro']);
            $this->usersList[] = $user;
        }
        $this->fieldList =array_keys($this->usersList[0]);

        $this->gradiList = Utils::getGradiList();
        $this->sediList = Utils::getSediList();

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
                'page_title' => 'Dashboard - Importa Personale',
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
            if(isset($grado) && $grado != '0')
                $usersList = $usersList->where('qualifica', $grado)->join('sede','sede.user = personale_operativo.id')->get()->getResultArray();
            else
                $usersList = $usersList->join('sede','sede.user = personale_operativo.id')->get()->getResultArray();

            $this->usersList = [];
            foreach ($usersList as $user){
                unset($user['id']);
                unset($user['created_at']);
                unset($user['updated_at']);
                unset($user['user']);
                $user['data_di_nascita'] = Utils::explodeDate($user['data_di_nascita']);
                $user['data_inizio_qualifica'] = Utils::explodeDate($user['data_inizio_qualifica']);
                $user['data_assunzione'] = Utils::explodeDate($user['data_assunzione']);
                $user['data_assegnazione'] = Utils::explodeDate($user['data_assegnazione']);
                $user['data_cessazione'] = Utils::explodeDate($user['data_cessazione']);
                $user['data_reintegro'] = Utils::explodeDate($user['data_reintegro']);
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