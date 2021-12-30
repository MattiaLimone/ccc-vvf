<?php


namespace App\Libraries;


use App\Models\GradiModel;
use App\Models\PersonaleOperativoModel;
use App\Models\SedeModel;

class Utils
{

    public static function parseDate($date) {
        $dateArray = explode("-", $date);
        $day = $dateArray[0];
        $month = $dateArray[1];
        $year = $dateArray[2];

        if (strlen($year) == 2){
            if($year > 45)
                $year = '19'.$year;
            else
                $year = '20'.$year;
        }

        switch ($month) {
            case 'GEN':
                $month = "01";
                break;
            case 'FEB':
                $month = "02";
                break;
            case 'MAR':
                $month = "03";
                break;
            case 'APR':
                $month = "04";
                break;
            case 'MAG':
                $month = "05";
                break;
            case 'GIU':
                $month = "06";
                break;
            case 'LUG':
                $month = "07";
                break;
            case 'AGO':
                $month = "08";
                break;
            case 'SET':
                $month = "09";
                break;
            case 'OTT':
                $month = "10";
                break;
            case 'NOV':
                $month = "11";
                break;
            case 'DIC':
                $month = "12";
                break;
        }

        return $year.'-'.$month.'-'.$day;
    }
    public static function explodeDate($date) {

        $dateArray = explode("-", $date);
        $year = $dateArray[0];
        $month = $dateArray[1];
        $day = $dateArray[2];

        switch ($month) {
            case '01':
                $month = "GEN";
                break;
            case '02':
                $month = "FEB";
                break;
            case '03':
                $month = "MAR";
                break;
            case '04':
                $month = "APR";
                break;
            case '05':
                $month = "MAG";
                break;
            case '06':
                $month = "GIU";
                break;
            case '07':
                $month = "LUG";
                break;
            case '08':
                $month = "AGO";
                break;
            case '09':
                $month = "SET";
                break;
            case '10':
                $month = "OTT";
                break;
            case '11':
                $month = "NOV";
                break;
            case '12':
                $month = "DIC";
                break;
        }

        return $day.'-'.$month.'-'.$year;
    }
    public static function explodeDateCalendar($date) {

        $dateArray = explode("-", $date);
        $day = $dateArray[0];
        $month = $dateArray[1];
        $year = $dateArray[2];


        switch ($month) {
            case '01':
                $month = "GEN";
                break;
            case '02':
                $month = "FEB";
                break;
            case '03':
                $month = "MAR";
                break;
            case '04':
                $month = "APR";
                break;
            case '05':
                $month = "MAG";
                break;
            case '06':
                $month = "GIU";
                break;
            case '07':
                $month = "LUG";
                break;
            case '08':
                $month = "AGO";
                break;
            case '09':
                $month = "SET";
                break;
            case '10':
                $month = "OTT";
                break;
            case '11':
                $month = "NOV";
                break;
            case '12':
                $month = "DIC";
                break;
        }

        return $day.'-'.$month.'-'.$year;
    }
    public static function getSediList() {
        $sediList = new SedeModel();
        return $sediList->distinct()->select('sede_destinazione')->get()->getResultArray();
    }

    public static function getGradiList() {
        $userList = new PersonaleOperativoModel();
        $gradiList = new GradiModel();
        $userList = $userList->distinct()->select('qualifica')->get()->getResultArray();

        foreach ($userList as $qualifica) {
            $gradi[] = $gradiList->select('id, code, title')->where('id',$qualifica['qualifica'])->first();
        }
        return $gradi;
    }

    public static function pp($array) {
        echo "<pre>";
        print_r ($array);
        echo "</pre>";
    }
}