<?php
namespace App\Models;
use CodeIgniter\Model;
class RolModel extends Model{
    protected $table='rol';
    protected $primaryKey='idrol';
    protected $returnType='array';
    protected $allowedFields =[
        'nombrerol'
    ];
}