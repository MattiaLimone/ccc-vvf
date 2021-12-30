<?php

namespace App\Validation;

use App\Models\PermissionModel;
use App\Models\PersonaleOperativoModel;
use App\Models\UserModel;

class UserRules{

    public function validateUser(string $str, string $fields, array $data){
        $user = new UserModel();
        $user = $user->where('codice_fiscale', $data['codice_fiscale'])
            ->first();

        if(!$user)
            return false;

        return password_verify($data['password'], $user['password']);
    }

    public function validateDuplicate(string $str, string $fields, array $data){
        $user = new PersonaleOperativoModel();
        $user = $user->where('codice_fiscale', $data['codice_fiscale'])
            ->first();

        if(!$user)
            return true;

        return false;
    }

    public function validateExist(string $str, string $fields, array $data){
        $user = new PersonaleOperativoModel();
        $user = $user->where('codice_fiscale', $data['codice_fiscale'])
            ->first();

        if(!$user)
            return false;

        return true;
    }


    public function validatePermissions(string $str, string $fields, array $data){
        $user = new UserModel();
        $user = $user->where('codice_fiscale', $data['codice_fiscale'])
            ->first();

        $permission = new PermissionModel();
        $permission = $permission->where('user', $user['id'])
            ->first();

        if(!$permission || $permission['level'] < 6)
            return false;

        return true;
    }
    public function validateCodiceFiscale(string $str, string $fields, array $data){
        $user = new UserModel();
        $user = $user->where('codice_fiscale', $data['codice_fiscale'])
            ->first();

        if(!$user)
            return false;

        return true;
    }
}
