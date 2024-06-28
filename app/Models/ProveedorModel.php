<?php
namespace App\Models;
use CodeIgniter\Model;
class ProveedorModel extends Model{
    protected $table='proveedor';
    protected $primaryKey='idproveedor';
    protected $returnType='array';
    protected $allowedFields =[
        'nombreproveedor', 'contacto', 'direccion'
    ];
}