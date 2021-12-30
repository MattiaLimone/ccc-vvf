<?php

namespace App\Controllers\Admin\Dashboard;


use App\Libraries\PagesUtils;
use App\Models\PermissionModel;
use App\Models\UserModel;
use CodeIgniter\Controller;
use App\Libraries\Breadcrumb;

class Permissions extends Controller
{
    protected $breadcrumb;
    protected $usersList;
    protected $search;

    public function __construct() {
        $this->breadcrumb = new Breadcrumb();
        $this->breadcrumb->add('Home', '/admin/dashboard');
        $this->breadcrumb->add('Modifica Permessi', '/admin/dashboard/permissions');
        $page = new PagesUtils( '/admin/dashboard/permissions','Modifica Permessi');
        $this->breadcrumb = $this->breadcrumb->render();

        $user = new UserModel();
        $user = $user->select('name, surname, codice_fiscale')->get()->getResultArray();
        $this->usersList = array();
        $counter = 0;
        foreach ($user as $row) {
            $this->usersList[$counter]['label'] = $row['name'] .' '. $row['surname'] .' - '.$row['codice_fiscale'];
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
        if(session()->get('level') >= 10){
            $data = [
                'page_title' => 'Dashboard - Modifica Permessi',
                'breadcrumbs' => $this->breadcrumb,
                'usersList' => json_encode($this->usersList),
                'searchList' => json_encode($this->search),
            ];
            return view("admin/pages/permissions", $data);
        } else {
            return redirect()->to('admin');
        }
    }
    public function update()
    {
        $data = [];

        if ($this->request->getMethod() == 'post') {
            $rules = [
                'codice_fiscale' => 'required|min_length[16]|max_length[50]|alpha_numeric|validateCodiceFiscale[codice_fiscale]',
                'permissionsList' => 'required|numeric',
            ];

            $errors = [
                'codice_fiscale' => [
                    'validateCodiceFiscale' => "Utente non trovato"
                ]
            ];
            if (!$this->validate($rules, $errors)) {
                $data = [
                    'page_title' => 'Login Dashboard',
                    'validation' => $this->validator,
                    'breadcrumbs' => $this->breadcrumb,
                    'usersList' => json_encode($this->usersList),
                    'searchList' => json_encode($this->search),
                ];
                return view("admin/pages/permissions", $data);

            } else {
                $user = new UserModel();
                $user = $user = $user->select('id')->where('codice_fiscale', $this->request->getVar('codice_fiscale'))
                    ->first();

                $permission = new PermissionModel();
                $permission->set('level', $this->request->getVar('permissionsList'), false);
                $permission->where('id', $user['id']);
                $permission->update();
                $data = [
                    'page_title' => 'Login Dashboard',
                    'success' => 'Permessi Modificati con successo',
                    'breadcrumbs' => $this->breadcrumb,
                    'usersList' => json_encode($this->usersList),
                    'searchList' => json_encode($this->search),
                ];
                return view("admin/pages/permissions", $data);
            }
        }
    }
}