<?php
namespace App\Models;

use CodeIgniter\Model;

class CategoriaModel extends Model {
    protected $table = 'categoria';
    protected $primaryKey = 'idcategoria';
    protected $returnType = 'array';
    protected $allowedFields = [
        'nombrecategoria'
    ];
}
?>
