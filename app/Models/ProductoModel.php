<?php
namespace App\Models;

use CodeIgniter\Model;

class ProductoModel extends Model
{
    protected $table = 'producto';
    protected $primaryKey = 'idproducto';
    protected $returnType = 'array';
    protected $allowedFields = [
        'nombreproducto','precioventa', 'ubicacionproducto',
        'codigobarras', 'idcategoria', 'idproveedor'
    ];

    // Retrieve products with their corresponding provider
    public function getProductoWithProveedor()
    {
        return $this->db->table('producto c')
            ->join('proveedor p', 'c.idproveedor = p.idproveedor')
            ->get()->getResultArray();
    }

    // Retrieve a product by its ID with its corresponding provider
    public function getProductoByIdWithProveedor($id)
    {
        return $this->db->table('producto c')
            ->where('c.idproducto', $id)
            ->join('proveedor p', 'c.idproveedor = p.idproveedor')
            ->get()->getResultArray();
    }

    // Retrieve providers
    public function getProveedores()
    {
        return $this->db->table('proveedor')
            ->get()->getResultArray();
    }

    // Retrieve products with their corresponding category
    public function getProductoWithCategoria()
    {
        return $this->db->table('producto c')
            ->join('categoria cat', 'c.idcategoria = cat.idcategoria')
            ->get()->getResultArray();
    }

    // Retrieve a product by its ID with its corresponding category
    public function getProductoByIdWithCategoria($id)
    {
        return $this->db->table('producto c')
            ->where('c.idproducto', $id)
            ->join('categoria cat', 'c.idcategoria = cat.idcategoria')
            ->get()->getResultArray();
    }

    // Retrieve categories
    public function getCategorias()
    {
        return $this->db->table('categoria')
            ->get()->getResultArray();
    }
}
