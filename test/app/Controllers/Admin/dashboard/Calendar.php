<?php

namespace App\Controllers\Admin\Dashboard;


use App\Libraries\Breadcrumb;
use App\Libraries\PagesUtils;
use App\Libraries\Utils;
use App\Models\PersonaleOperativoModel;
use App\Models\RegFerieModel;
use App\Models\RegMalattiaModel;
use App\Models\SedeModel;
use CodeIgniter\Controller;

class Calendar extends Controller
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
        $this->breadcrumb->add('Calendario', '/admin/dashboard/calendar');
        $page = new PagesUtils('/admin/dashboard/calendar', 'Calendario');
        $this->breadcrumb = $this->breadcrumb->render();


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
                'page_title' => 'Dashboard - Calendario',
                'breadcrumbs' => $this->breadcrumb,
                'searchList' => json_encode($this->search),
                'usersList' => json_encode($this->usersList),
                'turnazione' => json_encode($this->getTurni()),
            ];
            return view("admin/pages/calendar", $data);
        } else {
            return redirect()->to('admin');
        }
    }
    public function getData() {
        if ($this->request->getMethod() == 'post' && !empty($this->request->getVar('day'))) {

            $day = substr($this->request->getVar('day'), 0,10);
            $orario = substr($this->request->getVar('day'), 11,2);
            $turno = $this->request->getVar('turno');
            $codice_turno = substr($turno, 0,1);
            $userSlave = new PersonaleOperativoModel();
            $ferieSlave = new RegFerieModel();
            $malattiaSlave = new RegMalattiaModel();
            $turnazione = array();
            $turnazione['codice'] = $turno;

            if($orario == '08')
                $turnazione['orario'] = '08:00 - 20:00';
            else
                $turnazione['orario'] = '20:00 - 08:00';

            $userList = $userSlave
                ->select()
                ->where('codice_turnazione !=',  $turno)
                ->like('codice_turnazione',$codice_turno)
                ->get()
                ->getResultArray();

            $ferie = $ferieSlave
                ->select(' personale_operativo.nome, personale_operativo.cognome, reg_ferie.user, reg_ferie.from, reg_ferie.to')
                ->where('from <=', date('Y-m-d H:m:s',strtotime($day)))
                ->where('to >=', date('Y-m-d H:m:s',strtotime($day)))
                ->join('personale_operativo','personale_operativo.id = reg_ferie.user', 'LEFT')
                ->get()
                ->getResultArray();

            $malattia = $malattiaSlave
                ->select(' personale_operativo.nome, personale_operativo.cognome, 
                reg_malattia.id, reg_malattia.user, reg_malattia.email, reg_malattia.tipo, reg_malattia.reason, 
                reg_malattia.address, reg_malattia.telephone, reg_malattia.from, reg_malattia.to,')
                ->where('from <=', date('Y-m-d H:m:s',strtotime($day)))
                ->where('to >=', date('Y-m-d H:m:s',strtotime($day)))
                ->join('personale_operativo','personale_operativo.id = reg_malattia.user', 'LEFT')
                ->get()
                ->getResultArray();

            foreach ($userList as $key => $user) {
                foreach($malattia as $checkMalattia) {
                    if ($user['id'] == $checkMalattia['user'])
                        unset($userList[$key]);
                }
                foreach($ferie as $checkFerie) {
                    if ($user['id'] == $checkFerie['user'])
                        unset($userList[$key]);
                }
            }
            $return = array(
                'operativo' => $userList,
                'ferie' => $ferie,
                'malattia' => $malattia,
                'turno' => $turnazione,
            );
            return json_encode($return);
        }
    }

    public function getTurni() {
        $day = date('01-01-Y');
        $mese = array(
            '01'=>'GEN',
            '02'=>'FEB',
            '03'=>'MAR',
            '04'=>'APR',
            '05'=>'MAG',
            '06'=>'GIU',
            '07'=>'LUG',
            '08'=>'AGO',
            '09'=>'SET',
            '10'=>'OTT',
            '11'=>'NOV',
            '12'=>'DIC');
        $letter1= 'D';
        $number1 = 5;

        $letter2= 'C';
        $number2 = 5;
        $date = array();
        for ($i = 1; $i <= 1825; $i++) {

            $day_array = Utils::explodeDateCalendar($day);
            $date[$day]['primo_turno'] = $letter1.$number1;
            if($letter1 == 'D') {
                $letter1 = 'A';
                $number1++;
                if($number1 == 9) {
                    $number1 = 1;
                }
            } else {
                $letter1++;
            }

            $date[$day]['secondo_turno'] = $letter2.$number2;
            if($letter2 == 'D') {
                $letter2 = 'A';
                $number2++;
                if($number2 == 9) {
                    $number2 = 1;
                }
            } else {
                $letter2++;
            }
            $day = date("d-m-Y", strtotime("$day +1 day"));

        }
        return json_encode($date);
    }

    public function getCalendarEvents () {
        $start = substr($this->request->getVar('start'),0,10);
        $end = substr($this->request->getVar('end'),0,10);
        $day = date('2021-01-01');
        $events = array();
        $letter1= 'D';
        $counter = 0;
        $number1 = 5;
        $letter2= 'C';
        $number2 = 5;

        $date = array();
        for ($i = 1; $i <= 1825; $i++) {
            $event1['title'] =$letter1 . $number1;
            $event1['description'] = "08:00 - 20:00";
            $event1['start'] = $day.'T08:00:00';
            $events[] = $event1;
            if($letter1 == 'D') {
                $letter1 = 'A';
                $number1++;
                if($number1 == 9) {
                    $number1 = 1;
                }
            } else {
                $letter1++;
            }

            $event2['title'] = $letter2.$number2;
            $event2['start'] = $day.'T20:00:00';
            $event2['description'] = "20:00 - 08:00";
            $events[] = $event2;
            if($letter2 == 'D') {
                $letter2 = 'A';
                $number2++;
                if($number2 == 9) {
                    $number2 = 1;
                }
            } else {
                $letter2++;
            }
            $day = date("Y-m-d", strtotime("$day +1 day"));


        }
        return json_encode($events);
    }
}