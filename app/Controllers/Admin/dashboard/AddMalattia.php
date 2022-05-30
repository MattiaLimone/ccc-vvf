<?php


namespace App\Controllers\Admin\Dashboard;


use App\Libraries\Breadcrumb;
use App\Libraries\PagesUtils;
use App\Libraries\Utils;
use App\Models\ComuniModel;
use App\Models\GradiModel;
use App\Models\PersonaleOperativoModel;
use App\Models\RegFerieModel;
use App\Models\RegMalattiaModel;
use App\Models\SedeModel;
use App\Models\UserModel;
use CodeIgniter\Controller;

class AddMalattia extends Controller
{
    protected $breadcrumb;
    protected $gradi;
    protected $province;
    protected $search;

    public function __construct(){
        $this->breadcrumb = new Breadcrumb();
        $this->breadcrumb->add('Home', '/admin/dashboard');
        $this->breadcrumb->add('Inserisci Malattia', '/admin/dashboard/addmalattia');
        $page = new PagesUtils( '/admin/dashboard/addmalattia','Inserisci Malattia');
        $this->breadcrumb = $this->breadcrumb->render();

        $listaGradi = new GradiModel();
        $listaGradi = $listaGradi->select('code, title')->get()->getResultArray();
        foreach ($listaGradi as $grado) {
            $this->gradi[] = [
                'code' => $grado['code'],
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
                'page_title' => 'Dashboard - Inserimento Malattia',
                'breadcrumbs' => $this->breadcrumb,
                'gradi' => $this->gradi,
                'province' => $this->province,
                'usersList' => json_encode($this->usersList),
                'searchList' => json_encode($this->search),
            ];

            return view("admin/pages/reg_malattia", $data);
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
                    'email' =>'required',
                    'tipo'=>'required',
                    'reason'=>'required',
                    'address'=>'required',
                    'telephone'=>'required|numeric',
                    'inizio_malattia' => 'required|regex_match[^(([0-9])|([0-2][0-9])|([3][0-1]))-(GEN|FEB|MAR|APR|MAG|GIU|LUG|AGO|SET|OTT|NOV|DIC)-\d{4}$]',
                    'fine_malattia' => 'required|regex_match[^(([0-9])|([0-2][0-9])|([3][0-1]))-(GEN|FEB|MAR|APR|MAG|GIU|LUG|AGO|SET|OTT|NOV|DIC)-\d{4}$]',
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
                return view('admin/pages/reg_malattia', $data);
            } else {
                $regMalattia = new RegMalattiaModel();
                $operativo = new PersonaleOperativoModel();
                $idOperativo = $operativo->select('id')->where('codice_fiscale',$this->request->getVar('codice_fiscale'))->first();

                $dati = [
                    'user' => $idOperativo['id'],
                    'email' =>$this->request->getVar('email'),
                    'tipo'=>$this->request->getVar('tipo'),
                    'reason'=>$this->request->getVar('reason'),
                    'address'=>$this->request->getVar('address'),
                    'telephone'=>$this->request->getVar('telephone'),
                    'from' => Utils::parseDate($this->request->getVar('inizio_malattia')),
                    'to' => Utils::parseDate($this->request->getVar('fine_malattia'))
                    ];

                if(!$regMalattia->save($dati)){
                    $data = [
                        'page_title' => 'Dashboard - Modifica Personale',
                        'validation' => "Errore nell'inserimento nel registro malattie",
                        'breadcrumbs' => $this->breadcrumb,
                        'gradi' => $this->gradi,
                        'province' => $this->province,
                        'usersList' => json_encode($this->usersList),
                        'searchList' => json_encode($this->search),
                    ];
                    return view('admin/pages/reg_malattia', $data);
                }
                $data = [
                    'page_title' => 'Dashboard - Inserimento Malattia',
                    'success' => 'Malattia inserita correttamente nel registro',
                    'breadcrumbs' => $this->breadcrumb,
                    'gradi' => $this->gradi,
                    'province' => $this->province,
                    'usersList' => json_encode($this->usersList),
                    'searchList' => json_encode($this->search),
                ];

                return view("admin/pages/reg_malattia", $data);
            }
        }
    }
    public function getComuni(){
        if ($this->request->getMethod() == 'post') {
            $listaComuni = new ComuniModel();
            $listaComuni = $listaComuni
                ->distinct()
                ->select('comune, codice_comune')
                ->where('codice_provincia', $this->request->getVar('code'))
                ->orderBy("provincia", "asc")
                ->get()
                ->getResultArray();
            $counter = 0;

            foreach ($listaComuni as $comune) {
                $list[$counter]['label'] = $comune['comune'];
                $list[$counter]['value'] = $comune['codice_comune'];
                $counter++;
            }

            return json_encode($list);
        } else {
            return null;
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

            $user[0]['data_di_nascita'] = Utils::explodeDate($user[0]['data_di_nascita'] );
            $user[0]['data_inizio_qualifica'] = Utils::explodeDate($user[0]['data_inizio_qualifica'] );
            $user[0]['data_assunzione'] = Utils::explodeDate($user[0]['data_assunzione'] );
            $user[0]['data_assegnazione'] = Utils::explodeDate($user[0]['data_assegnazione'] );
            $user[0]['data_cessazione'] = Utils::explodeDate($user[0]['data_cessazione'] );
            $user[0]['data_reintegro'] = Utils::explodeDate($user[0]['data_reintegro'] );

            return json_encode($user);
        }
    }
}