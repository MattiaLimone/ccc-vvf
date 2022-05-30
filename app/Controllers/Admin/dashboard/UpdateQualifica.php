<?php


namespace App\Controllers\Admin\Dashboard;


use App\Libraries\Breadcrumb;
use App\Libraries\PagesUtils;
use App\Libraries\Utils;
use App\Models\ComuniModel;
use App\Models\GradiModel;
use App\Models\PersonaleOperativoModel;
use App\Models\RegFerieModel;
use App\Models\SedeModel;
use App\Models\UserModel;
use CodeIgniter\Controller;

class UpdateQualifica extends Controller
{
    protected $breadcrumb;
    protected $gradi;
    protected $province;
    protected $search;

    public function __construct(){
        $this->breadcrumb = new Breadcrumb();
        $this->breadcrumb->add('Home', '/admin/dashboard');
        $this->breadcrumb->add('Modifica Qualifica', '/admin/dashboard/updatequalifica');
        $page = new PagesUtils( '/admin/dashboard/updatequalifica','Modifica Qualifica');
        $this->breadcrumb = $this->breadcrumb->render();

        $listaGradi = new GradiModel();
        $listaGradi = $listaGradi->select('id, title')->get()->getResultArray();
        foreach ($listaGradi as $grado) {
            $this->gradi[] = [
                'id' => $grado['id'],
                'title' => $grado['title'],
            ];
        }

        $listaComuni = new ComuniModel();
        $listaComuni = $listaComuni
            ->distinct()
            ->select('provincia, codice_provincia')
            ->orderBy("provincia", "asc")
            ->get()
            ->getResultArray();

        foreach ($listaComuni as $comune){
            $this->province[] = [
                'codice_provincia' => $comune['codice_provincia'],
                'provincia' => $comune['provincia'],
            ];
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
        if(session()->get('level') >= 8){
            $data = [
                'page_title' => 'Dashboard - Modifica Qualifica',
                'breadcrumbs' => $this->breadcrumb,
                'gradi' => $this->gradi,
                'province' => $this->province,
                'usersList' => json_encode($this->usersList),
                'searchList' => json_encode($this->search),
            ];

            return view("admin/pages/update_qualifica", $data);
        } else {
            return redirect()->to('admin');
        }
    }
    public function insert()
    {
        if(session()->get('level') >= 8) {
            if ($this->request->getMethod() == 'post') {
                $rules = [
                    'codice_fiscale' => 'required|min_length[16]|max_length[16]|alpha_numeric|validateExist[codice_fiscale]',
                    'grado' => 'required|numeric',
                ];
                $errors = [
                    'codice_fiscale' => [
                        'validateExist' => "L'utente non è presente nel sistema"
                    ]
                ];
            }
            if (!$this->validate($rules, $errors)) {
                $data = [
                    'page_title' => 'Dashboard - Modifica Personale',
                    'validation' => $this->validator,
                    'breadcrumbs' => $this->breadcrumb,
                    'gradi' => $this->gradi,
                    'province' => $this->province,
                    'usersList' => json_encode($this->usersList),
                    'searchList' => json_encode($this->search),
                ];
                return view('admin/pages/update_qualifica', $data);
            } else {
                $operativo = new PersonaleOperativoModel();
                $idOperativo = $operativo->select('id')->where('codice_fiscale',$this->request->getVar('codice_fiscale'))->first();


                $operativo->set('qualifica', $this->request->getVar('grado'), false);
                $operativo->where('id', $idOperativo['id']);
                if(!$operativo->update()){
                    $data = [
                        'page_title' => 'Dashboard - Modifica Personale',
                        'validation' => "Errore nella modifica della qualifica",
                        'breadcrumbs' => $this->breadcrumb,
                        'gradi' => $this->gradi,
                        'province' => $this->province,
                        'usersList' => json_encode($this->usersList),
                        'searchList' => json_encode($this->search),
                    ];
                    return view('admin/pages/update_qualifica', $data);
                }
                $data = [
                    'page_title' => 'Dashboard - Modifica Personale',
                    'success' => 'Qualifica modificata correttamente',
                    'breadcrumbs' => $this->breadcrumb,
                    'gradi' => $this->gradi,
                    'province' => $this->province,
                    'usersList' => json_encode($this->usersList),
                    'searchList' => json_encode($this->search),
                ];

                return view("admin/pages/update_qualifica", $data);
            }
        }
    }
}