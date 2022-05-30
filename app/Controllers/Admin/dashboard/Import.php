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

class Import extends Controller
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
        $this->breadcrumb->add('Importa Personale', '/admin/dashboard/import');
        $page = new PagesUtils( '/admin/dashboard/import','Importa Personale');
        $this->breadcrumb = $this->breadcrumb->render();

        $fieldList = new PersonaleOperativoModel();
        $fieldList = array_merge($fieldList->db->getFieldNames('personale_operativo'),$fieldList->db->getFieldNames('sede'));

        $this->fieldList = array_values(array_diff( $fieldList, ['id','user','created_at','updated_at']));

        //$this->gradiList = Utils::getGradiList();
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
        if(session()->get('level') >= 10){
            $data = [
                'page_title' => 'Dashboard - Importa Personale',
                'breadcrumbs' => $this->breadcrumb,
                'gradiList' => $this->gradiList,
                'fieldList' => $this->fieldList,
                'sediList' => $this->sediList,
                'searchList' => json_encode($this->search),
            ];
            return view("admin/pages/import", $data);
        } else {
            return redirect()->to('admin');
        }
    }

    public function do_upload()
    {
        if ($this->request->getMethod() == 'post') {
            $file = array();
            $rules = [
                'xmlFile' => 'uploaded[xmlFile]|mime_in[xmlFile,text/xml,application/xml]|max_size[xmlFile,10240]',
            ];

            $errors = [];
            if (!$this->validate($rules, $errors)) {
                $data = [
                    'page_title' => 'Dashboard - Importa Personale',
                    'breadcrumbs' => $this->breadcrumb,
                    'fieldList' => $this->fieldList,
                    'gradiList' => $this->gradiList,
                    'sediList' => $this->sediList,
                    'importValidation' => $this->validator,
                    'searchList' => json_encode($this->search),
                ];

                return view("admin/pages/import", $data);
            } else {
                $file = $this->request->getFile('xmlFile');

                $xmlList = json_decode(json_encode(simplexml_load_file($file->getTempName())),TRUE);

                if(!array_key_exists(0,$xmlList['LIST_G_CGNDIP']['G_CGNDIP']))
                    $xml['G_CGNDIP'][0] = $xmlList['LIST_G_CGNDIP']['G_CGNDIP'];
                else
                    $xml = $xmlList['LIST_G_CGNDIP'];


                if(session()->get('level') >= 6){
                    $data = [
                        'page_title' => 'Dashboard - Importa Personale',
                        'breadcrumbs' => $this->breadcrumb,
                        'fieldList' => $this->fieldList,
                        'gradiList' => $this->gradiList,
                        'sediList' => $this->sediList,
                        'xmlList' => $xml,
                        'searchList' => json_encode($this->search),
                    ];

                    return view("admin/pages/import", $data);
                } else {
                    return redirect()->to('admin');
                }
            }
        }
        $data = [
            'page_title' => 'Dashboard - Importa Personale',
            'breadcrumbs' => $this->breadcrumb,
            'fieldList' => $this->fieldList,
            'gradiList' => $this->gradiList,
            'sediList' => $this->sediList,
            'searchList' => json_encode($this->search),
        ];

        return view("admin/pages/import", $data);
    }

    public function import() {
        $counter = 0;
        $error = array();
        $success = array();

        foreach ($this->request->getPost() as $user) {
            if($this->checkPreImport($user[2])) {

                $qualifica = new GradiModel();
                $qualifica = $qualifica->select('id')
                    ->where('title', Utils::toCamelCase($user[16]))
                    ->first();

                if($user[4] == 'NULL')
                    $user[4] = '01-GEN-90';
                if($user[5] == 'NULL')
                    $user[5] = '01-GEN-90';
                $specializzazione = new SpecsModel();
                $operativo = new PersonaleOperativoModel();
                $sede = new SedeModel();
                $datiOperativo =[
                    'nome' => $user[0],
                    'cognome' => $user[1],
                    'codice_fiscale' => $user[2],
                    'sesso' => $user[3],
                    'data_di_nascita' => Utils::parseDate($user[4]),
                    'numero_iscrizione' => $user[5],
                    'codice_qualifica' => $user[6],
                    'ruolo_qualifica' => $user[7],
                    'matricola' => $user[8],
                    'data_inizio_qualifica' => Utils::parseDate($user[9]),
                    'data_assunzione' => Utils::parseDate($user[10]),
                    'codice_turnazione' => $user[11],
                    'indirizzo' => $user[12],
                    'cap' => $user[13],
                    'comune' => $user[14],
                    'provincia' => $user[15],
                    'qualifica' => $qualifica['id'],
                    'indirizzo_completo' => $user[17],
                    'numero_telefono' => $user[18],
                    'assunzione_completo' => $user[19],
                ];
                preg_match('([^:]+$)',$user[19],$specs);
                $specs = explode(',', $specs[0]);

                if(!$operativo->insert($datiOperativo)){
                    $error[] ="Errore nell'inserimento di ".$user[2]." nel database del personale";
                } else {
                    $lastId = $operativo->getInsertID();
                    foreach ($specs as  $spec) {
                        $datiSpec = [
                            'user' => $lastId,
                            'qualifica' => $spec,
                        ];

                        if(!$specializzazione->insert($datiSpec)){
                            $error[] ="Errore nell'inserimento della qualifica ".$spec." di ".$user[2]." nel database formazione";
                        }
                    }
                    if($user[22] == 'NULL')
                        $user[22] = '01-GEN-90';
                    if($user[23] == 'NULL')
                        $user[23] = '01-GEN-90';
                    if($user[24] == 'NULL')
                        $user[24] = '01-GEN-90';

                    $datiSede = [
                        'user' => $lastId,
                        'codice_sede' => $user[20],
                        'codice_tc' => $user[21],
                        'data_assegnazione' => Utils::parseDate($user[22]),
                        'data_cessazione' => Utils::parseDate($user[23]),
                        'data_reintegro' => Utils::parseDate($user[24]),
                        'sede_destinazione' => $user[25],
                    ];

                    if(!$sede->insert($datiSede)){
                        $error[] = "Errore nell'inserimento della sede di ".$user[2]." nel database";
                    } else {
                        $success[] = $user[2]." caricato con successo nel sistema";
                    }
                }
            } else {
                $error[] = $user[2]." è già presente nel sistema";
            }
        }
        $data = [
            'page_title' => 'Dashboard - Ricerca Personale',
            'validation' => $error,
            'success' => $success,
            'breadcrumbs' => $this->breadcrumb,
            'gradiList' => $this->gradiList,
            'fieldList' => $this->fieldList,
            'searchList' => json_encode($this->search),
            'sediList' => $this->sediList,
        ];
        return view("admin/pages/import", $data);


    }

    public function checkPreImport($cf) {
        $user = new PersonaleOperativoModel();
        $user = $user->where('codice_fiscale', $cf)
            ->first();

        if(!$user)
            return true;

        return false;

    }
    private function replaceAccents($str)
    {
        $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ');
        $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o');
        return str_replace($a, $b, $str);
    }
}