<?php
namespace App\Models;
use CodeIgniter\Model;
class UsuariosModel extends Model{
    protected $table='usuario';
    protected $primaryKey='idusuario';
    protected $returnType='array';
    protected $allowedFields = [
        'nombreusuario', 'contraseña', 'correo', 'dnitrabajador',
         'idrol'
    ];
}