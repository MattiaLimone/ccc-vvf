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
                'page_title' => 'Dashboard - Ricerca Personale',
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
                $temp = file_get_contents($file);
                typeof($temp);
                die();

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
                echo $counter++;
                $qualifica = new GradiModel();
                $qualifica = $qualifica->select('id')
                    ->like('title', $user[16])
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
    private function remove_accents($string) {
        if ( !preg_match('/[\x80-\xff]/', $string) )
            return $string;

        $chars = array(
            // Decompositions for Latin-1 Supplement
            chr(195).chr(128) => 'A', chr(195).chr(129) => 'A',
            chr(195).chr(130) => 'A', chr(195).chr(131) => 'A',
            chr(195).chr(132) => 'A', chr(195).chr(133) => 'A',
            chr(195).chr(135) => 'C', chr(195).chr(136) => 'E',
            chr(195).chr(137) => 'E', chr(195).chr(138) => 'E',
            chr(195).chr(139) => 'E', chr(195).chr(140) => 'I',
            chr(195).chr(141) => 'I', chr(195).chr(142) => 'I',
            chr(195).chr(143) => 'I', chr(195).chr(145) => 'N',
            chr(195).chr(146) => 'O', chr(195).chr(147) => 'O',
            chr(195).chr(148) => 'O', chr(195).chr(149) => 'O',
            chr(195).chr(150) => 'O', chr(195).chr(153) => 'U',
            chr(195).chr(154) => 'U', chr(195).chr(155) => 'U',
            chr(195).chr(156) => 'U', chr(195).chr(157) => 'Y',
            chr(195).chr(159) => 's', chr(195).chr(160) => 'a',
            chr(195).chr(161) => 'a', chr(195).chr(162) => 'a',
            chr(195).chr(163) => 'a', chr(195).chr(164) => 'a',
            chr(195).chr(165) => 'a', chr(195).chr(167) => 'c',
            chr(195).chr(168) => 'e', chr(195).chr(169) => 'e',
            chr(195).chr(170) => 'e', chr(195).chr(171) => 'e',
            chr(195).chr(172) => 'i', chr(195).chr(173) => 'i',
            chr(195).chr(174) => 'i', chr(195).chr(175) => 'i',
            chr(195).chr(177) => 'n', chr(195).chr(178) => 'o',
            chr(195).chr(179) => 'o', chr(195).chr(180) => 'o',
            chr(195).chr(181) => 'o', chr(195).chr(182) => 'o',
            chr(195).chr(182) => 'o', chr(195).chr(185) => 'u',
            chr(195).chr(186) => 'u', chr(195).chr(187) => 'u',
            chr(195).chr(188) => 'u', chr(195).chr(189) => 'y',
            chr(195).chr(191) => 'y',
            // Decompositions for Latin Extended-A
            chr(196).chr(128) => 'A', chr(196).chr(129) => 'a',
            chr(196).chr(130) => 'A', chr(196).chr(131) => 'a',
            chr(196).chr(132) => 'A', chr(196).chr(133) => 'a',
            chr(196).chr(134) => 'C', chr(196).chr(135) => 'c',
            chr(196).chr(136) => 'C', chr(196).chr(137) => 'c',
            chr(196).chr(138) => 'C', chr(196).chr(139) => 'c',
            chr(196).chr(140) => 'C', chr(196).chr(141) => 'c',
            chr(196).chr(142) => 'D', chr(196).chr(143) => 'd',
            chr(196).chr(144) => 'D', chr(196).chr(145) => 'd',
            chr(196).chr(146) => 'E', chr(196).chr(147) => 'e',
            chr(196).chr(148) => 'E', chr(196).chr(149) => 'e',
            chr(196).chr(150) => 'E', chr(196).chr(151) => 'e',
            chr(196).chr(152) => 'E', chr(196).chr(153) => 'e',
            chr(196).chr(154) => 'E', chr(196).chr(155) => 'e',
            chr(196).chr(156) => 'G', chr(196).chr(157) => 'g',
            chr(196).chr(158) => 'G', chr(196).chr(159) => 'g',
            chr(196).chr(160) => 'G', chr(196).chr(161) => 'g',
            chr(196).chr(162) => 'G', chr(196).chr(163) => 'g',
            chr(196).chr(164) => 'H', chr(196).chr(165) => 'h',
            chr(196).chr(166) => 'H', chr(196).chr(167) => 'h',
            chr(196).chr(168) => 'I', chr(196).chr(169) => 'i',
            chr(196).chr(170) => 'I', chr(196).chr(171) => 'i',
            chr(196).chr(172) => 'I', chr(196).chr(173) => 'i',
            chr(196).chr(174) => 'I', chr(196).chr(175) => 'i',
            chr(196).chr(176) => 'I', chr(196).chr(177) => 'i',
            chr(196).chr(178) => 'IJ',chr(196).chr(179) => 'ij',
            chr(196).chr(180) => 'J', chr(196).chr(181) => 'j',
            chr(196).chr(182) => 'K', chr(196).chr(183) => 'k',
            chr(196).chr(184) => 'k', chr(196).chr(185) => 'L',
            chr(196).chr(186) => 'l', chr(196).chr(187) => 'L',
            chr(196).chr(188) => 'l', chr(196).chr(189) => 'L',
            chr(196).chr(190) => 'l', chr(196).chr(191) => 'L',
            chr(197).chr(128) => 'l', chr(197).chr(129) => 'L',
            chr(197).chr(130) => 'l', chr(197).chr(131) => 'N',
            chr(197).chr(132) => 'n', chr(197).chr(133) => 'N',
            chr(197).chr(134) => 'n', chr(197).chr(135) => 'N',
            chr(197).chr(136) => 'n', chr(197).chr(137) => 'N',
            chr(197).chr(138) => 'n', chr(197).chr(139) => 'N',
            chr(197).chr(140) => 'O', chr(197).chr(141) => 'o',
            chr(197).chr(142) => 'O', chr(197).chr(143) => 'o',
            chr(197).chr(144) => 'O', chr(197).chr(145) => 'o',
            chr(197).chr(146) => 'OE',chr(197).chr(147) => 'oe',
            chr(197).chr(148) => 'R',chr(197).chr(149) => 'r',
            chr(197).chr(150) => 'R',chr(197).chr(151) => 'r',
            chr(197).chr(152) => 'R',chr(197).chr(153) => 'r',
            chr(197).chr(154) => 'S',chr(197).chr(155) => 's',
            chr(197).chr(156) => 'S',chr(197).chr(157) => 's',
            chr(197).chr(158) => 'S',chr(197).chr(159) => 's',
            chr(197).chr(160) => 'S', chr(197).chr(161) => 's',
            chr(197).chr(162) => 'T', chr(197).chr(163) => 't',
            chr(197).chr(164) => 'T', chr(197).chr(165) => 't',
            chr(197).chr(166) => 'T', chr(197).chr(167) => 't',
            chr(197).chr(168) => 'U', chr(197).chr(169) => 'u',
            chr(197).chr(170) => 'U', chr(197).chr(171) => 'u',
            chr(197).chr(172) => 'U', chr(197).chr(173) => 'u',
            chr(197).chr(174) => 'U', chr(197).chr(175) => 'u',
            chr(197).chr(176) => 'U', chr(197).chr(177) => 'u',
            chr(197).chr(178) => 'U', chr(197).chr(179) => 'u',
            chr(197).chr(180) => 'W', chr(197).chr(181) => 'w',
            chr(197).chr(182) => 'Y', chr(197).chr(183) => 'y',
            chr(197).chr(184) => 'Y', chr(197).chr(185) => 'Z',
            chr(197).chr(186) => 'z', chr(197).chr(187) => 'Z',
            chr(197).chr(188) => 'z', chr(197).chr(189) => 'Z',
            chr(197).chr(190) => 'z', chr(197).chr(191) => 's'
        );

        $string = strtr($string, $chars);

        return $string;
    }
}