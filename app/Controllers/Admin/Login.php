<?php


namespace App\Controllers\Admin;


use App\Models\PermissionModel;
use App\Models\UserModel;
use App\Validation\UserRules;
use CodeIgniter\Controller;

class Login extends Controller
{
    public function index()
    {
        $data = [
            'page_title' => 'Login Dashboard',
            'searchList' => ''
        ];
        return view("admin/login", $data);
    }

    public function login()
    {
        $data = [];

        if ($this->request->getMethod() == 'post') {

            $rules = [
                'codice_fiscale' => 'required|min_length[16]|max_length[16]|alpha_numeric|validatePermissions[codice_fiscale]',
                'password' => 'required|min_length[6]|max_length[72]|validateUser[codice_fiscale,password]',
            ];

            $errors = [
                'codice_fiscale' => [
                    'validatePermissions' => "Non disponi delle autorizzazioni per accedere!"
                ],
                'password' => [
                    'validateUser' => "Codice Fiscale o Password errata",
                ],
            ];

            if (!$this->validate($rules, $errors)) {
                $data = [
                    'page_title' => 'Login Dashboard',
                    'validation' => $this->validator,
                ];
                return view('admin/login', $data);
            } else {
                $user = new UserModel();

                $user = $user->where('codice_fiscale', $this->request->getVar('codice_fiscale'))
                    ->first();
                $permission = new PermissionModel();
                $permission = $permission->where('user', $user['id'])
                    ->first();
                // Salvo la sessione
                $this->setUserSession($user, $permission);
                // Reindirizzamento al pannello di amministrazione
                return redirect()->to(base_url('admin/dashboard'));

            }
        }
        $data = [
            'page_title' => 'Login Dashboard',
            'validation' => $this->validator,
        ];
        return view('admin/login', $data);
    }

    private function setUserSession($user,  $permission)
    {
        $data = [
            'id' => $user['id'],
            'name' => $user['name'],
            'surname' => $user['surname'],
            'codice_fiscale' => $user['codice_fiscale'],
            'email' => $user['email'],
            'level' => $permission['level'],
            'isLoggedIn' => true,
        ];

        session()->set($data);
        return true;
    }
}
