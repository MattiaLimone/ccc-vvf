<?php


namespace App\Models;


use CodeIgniter\Model;

class PersonaleOperativoModel extends Model
{
    protected $table                = 'personale_operativo';
    protected $primaryKey           = 'id';

    protected $useAutoIncrement     = true;

    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;

    protected $allowedFields        = [
        'id',
        'nome',
        'cognome' ,
        'codice_fiscale' ,
        'sesso',
        'data_di_nascita',
        'numero_iscrizione',
        'codice_qualifica',
        'ruolo_qualifica',
        'matricola',
        'data_inizio_qualifica',
        'data_assunzione',
        'codice_turnazione',
        'indirizzo',
        'cap',
        'comune',
        'provincia',
        'qualifica',
        'indirizzo_completo',
        'numero_telefono',
        'assunzione_completo'
    ];

    // Dates
    protected $useTimestamps        = false;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'created_at';
    protected $updatedField         = 'updated_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks       = true;
    protected $beforeInsert         = [];
    protected $afterInsert          = [];
    protected $beforeUpdate         = [];
    protected $afterUpdate          = [];
    protected $beforeFind           = [];
    protected $afterFind            = [];
    protected $beforeDelete         = [];
    protected $afterDelete          = [];
}