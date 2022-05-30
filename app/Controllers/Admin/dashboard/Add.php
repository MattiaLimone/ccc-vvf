<?php


namespace App\Controllers\Admin\Dashboard;


use App\Libraries\Breadcrumb;
use App\Libraries\Pages;
use App\Libraries\PagesUtils;
use App\Libraries\Utils;
use App\Models\ComuniModel;
use App\Models\GradiModel;
use App\Models\PersonaleOperativoModel;
use App\Models\SedeModel;
use CodeIgniter\Controller;

class Add extends Controller
{
    protected $gradi;
    protected $province;
    protected $search;

    protected $breadcrumb;

    public function __construct(){
        $this->breadcrumb = new Breadcrumb();
        $this->breadcrumb->add('Home', '/admin/dashboard');
        $this->breadcrumb->add('Aggiungi Personale', '/admin/dashboard/add');

        $page = new PagesUtils('/admin/dashboard/add','Aggiungi Personale');

        $this->breadcrumb = $this->breadcrumb->render();

        $results = $page->getAll();
        $counter = 0;
        foreach ($results as $result) {
            $this->search[$counter]['label'] = $result['title'];
            $this->search[$counter]['value'] = base_url($result['link']);
            $counter++;
        }

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
    }

    public function index()
    {

        if(session()->get('level') >= 10){
            $data = [
                'page_title' => 'Dashboard - Aggiungi Personale',
                'breadcrumbs' => $this->breadcrumb,
                'gradi' => $this->gradi,
                'province' => $this->province,
                'searchList' => json_encode($this->search),
            ];

            return view("admin/pages/add", $data);
        } else {
            return redirect()->to('admin');
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

    public function newEntry(){

        if ($this->request->getMethod() == 'post') {

            $rules = [
                'nome' => 'required|max_length[45]|alpha_space',
                'cognome' => 'required|max_length[45]|alpha_space',
                'codice_fiscale' => 'required|min_length[16]|max_length[16]|alpha_numeric|validateDuplicate[codice_fiscale]',
                'sesso' => 'required|max_length[1]|alpha',
                'data_di_nascita' => 'required|regex_match[^(([0-9])|([0-2][0-9])|([3][0-1]))-(GEN|FEB|MAR|APR|MAG|GIU|LUG|AGO|SET|OTT|NOV|DIC)-\d{4}$]',
                'numero_iscrizione' => 'required|numeric',
                'codice_qualifica' => 'required|numeric',
                'ruolo_qualifica'  => 'required|alpha_numeric_space',
                'matricola' => 'required|numeric',
                'data_inizio' => 'required|regex_match[^(([0-9])|([0-2][0-9])|([3][0-1]))-(GEN|FEB|MAR|APR|MAG|GIU|LUG|AGO|SET|OTT|NOV|DIC)-\d{4}$]',
                'data_assunzione' => 'required|regex_match[^(([0-9])|([0-2][0-9])|([3][0-1]))-(GEN|FEB|MAR|APR|MAG|GIU|LUG|AGO|SET|OTT|NOV|DIC)-\d{4}$]',
                'codice_turnazione' => 'required|alpha_numeric',
                'indirizzo' => 'required',
                'provincia' => 'required|alpha_numeric_space',
                'cap' => 'required|numeric',
                'grado' =>'required|alpha_numeric',
                'comune' => 'required|alpha_numeric_space',
                'codice_comune' => 'required|numeric',
                'telefono' => 'required|numeric',
                'codice_sede' => 'required|alpha_numeric_space',
                'codice_tc' => 'required|alpha_numeric_space',
                'sede_destinazione' => 'required|alpha_numeric_space',
                'data_assegnazione' => 'required|regex_match[^(([0-9])|([0-2][0-9])|([3][0-1]))-(GEN|FEB|MAR|APR|MAG|GIU|LUG|AGO|SET|OTT|NOV|DIC)-\d{4}$]',
                'data_cessazione' => 'required|regex_match[^(([0-9])|([0-2][0-9])|([3][0-1]))-(GEN|FEB|MAR|APR|MAG|GIU|LUG|AGO|SET|OTT|NOV|DIC)-\d{4}$]',
                'data_reintegro' => 'required|regex_match[^(([0-9])|([0-2][0-9])|([3][0-1]))-(GEN|FEB|MAR|APR|MAG|GIU|LUG|AGO|SET|OTT|NOV|DIC)-\d{4}$]',
            ];

            $errors = [
                'codice_fiscale' => [
                    'validateDuplicate' => "L'utente è già presente nel sistema"
                ]
            ];

            if (!$this->validate($rules, $errors)) {
                $data = [
                    'page_title' => 'Dashboard - Aggiungi Personale',
                    'validation' => $this->validator,
                    'breadcrumbs' => $this->breadcrumb,
                    'gradi' => $this->gradi,
                    'province' => $this->province,
                    'searchList' => json_encode($this->search),
                ];
                return view('admin/pages/add', $data);
            } else {
                $qualifica = new GradiModel();
                $qualifica = $qualifica->select('id')
                    ->where('code', $this->request->getVar('grado'))
                    ->first();

                $operativo = new PersonaleOperativoModel();
                $datiOperativo =[
                    'nome' => $this->request->getVar('nome'),
                    'cognome' => $this->request->getVar('cognome'),
                    'codice_fiscale' => $this->request->getVar('codice_fiscale'),
                    'sesso' => $this->request->getVar('sesso'),
                    'data_di_nascita' => Utils::parseDate($this->request->getVar('data_di_nascita')),
                    'numero_iscrizione' => $this->request->getVar('numero_iscrizione'),
                    'codice_qualifica' => $this->request->getVar('codice_qualifica'),
                    'ruolo_qualifica' => $this->request->getVar('ruolo_qualifica'),
                    'matricola' => $this->request->getVar('matricola'),
                    'data_inizio_qualifica' => Utils::parseDate($this->request->getVar('data_inizio')),
                    'data_assunzione' => Utils::parseDate($this->request->getVar('data_assunzione')),
                    'codice_turnazione' => $this->request->getVar('codice_turnazione'),
                    'indirizzo' => $this->request->getVar('indirizzo'),
                    'cap' => $this->request->getVar('cap'),
                    'comune' => $this->request->getVar('codice_comune'),
                    'provincia' => $this->request->getVar('provincia'),
                    'qualifica' => $qualifica['id'],
                    'indirizzo_completo' => $this->request->getVar('indirizzo').' '.$this->request->getVar('cap').' - '.$this->request->getVar('comune'),
                    'numero_telefono' => $this->request->getVar('telefono'),
                    'assunzione_completo' => 'Data Assunzione: '.$this->request->getVar('data_assunzione')
                        .' Data inizio qualifica: '.$this->request->getVar('data_inizio')
                        .' Specializzazioni: '.$this->request->getVar('grado'),
                ];

                if(!$operativo->insert($datiOperativo)){
                    $data = [
                        'page_title' => 'Dashboard - Aggiungi Personale',
                        'validation' => "Errore nell'inserimento del personale operativo",
                        'breadcrumbs' => $this->breadcrumb,
                        'gradi' => $this->gradi,
                        'province' => $this->province,
                        'searchList' => json_encode($this->search),
                    ];
                    return view('admin/pages/add', $data);
                }


                $lastId = $operativo->getInsertID();

                $datiSede = [
                    'user' => $lastId,
                    'codice_sede' => $this->request->getVar('codice_sede'),
                    'codice_tc' => $this->request->getVar('codice_tc'),
                    'data_assegnazione' => Utils::parseDate($this->request->getVar('data_assegnazione')),
                    'data_cessazione' => Utils::parseDate($this->request->getVar('data_cessazione')),
                    'data_reintegro' => Utils::parseDate($this->request->getVar('data_reintegro')),
                    'sede_destinazione' => $this->request->getVar('sede_destinazione'),
                ];
                $sede = new SedeModel();

                if(!$sede->insert($datiSede)){
                    $data = [
                        'page_title' => 'Dashboard - Aggiungi Personale',
                        'validation' => "Errore nell'inserimento della sede",
                        'breadcrumbs' => $this->breadcrumb,
                        'gradi' => $this->gradi,
                        'province' => $this->province,
                        'searchList' => json_encode($this->search),
                    ];
                    return view('admin/pages/add', $data);
                }

                $data = [
                    'page_title' => 'Dashboard - Aggiungi Personale',
                    'success' => 'Utente aggiunto con successo',
                    'breadcrumbs' => $this->breadcrumb,
                    'gradi' => $this->gradi,
                    'province' => $this->province,
                    'searchList' => json_encode($this->search),
                ];

                return view('admin/pages/add', $data);
            }
        }
    }


}