<?php


namespace App\Libraries;


use App\Models\Pages;

class PagesUtils
{
    public function __construct($link, $title) {
        $builder =  new Pages();
        $row = $builder->select()->where('link',$link)->first();
        if(!$row){
            $data = [
                'link' => $link,
                'title' => $title,
            ];
            $builder->insert($data);
        } else {
            $data = [
                'id' => $row['id'],
                'link' => $link,
                'title' => $title,
            ];
            $builder->save($data);
        }
    }

    public function getAll() {
        $builder =  new Pages();
        return $builder->select()->get()->getResultArray();
    }
}