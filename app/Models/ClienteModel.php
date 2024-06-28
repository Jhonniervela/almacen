<?php
namespace App\Models;
use CodeIgniter\Model;
class ClienteModel extends Model{
    protected $table='cliente';
    protected $primaryKey='clienteid';
    protected $returnType='array';
    protected $allowedFields =[
        'DNI', 'Nombre','ApellidoPaterno','ApellidoMaterno','Telefono'
    ]; 
    }