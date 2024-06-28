<?php
namespace App\Models;
use CodeIgniter\Model;

class DetalleModel extends Model {
    protected $table = 'detalleventa';
    protected $primaryKey = 'iddetalle';
    protected $returnType = 'array';
    protected $allowedFields = [
        'cantidad', 'preciototal', 'idventa', 'idproducto'
    ];

    // Retrieve detalleventa with product details filtered by idventa
    public function getDetalleProducto($idventa) {
        return $this->db->table('detalleventa c')
            ->join('producto tp', 'c.idproducto = tp.idproducto')
            ->where('c.idventa', $idventa)
            ->get()->getResultArray();
    }

    // Retrieve all detalleventa records
    public function getAllDetalleVenta() {
        return $this->db->table('detalleventa')
            ->get()->getResultArray();
    }

    // Retrieve detalleventa with their corresponding venta details
    public function getDetalleConVenta() {
        return $this->db->table('detalleventa c')
            ->join('venta v', 'c.idventa = v.idventa')
            ->get()->getResultArray();
    }

    // Retrieve a detalleventa by idproducto with its corresponding venta details
    public function getDetalleByProducto($idproducto) {
        return $this->db->table('detalleventa c')
            ->join('venta v', 'c.idventa = v.idventa')
            ->where('c.idproducto', $idproducto)
            ->get()->getResultArray();
    }

    // Retrieve all venta records
    public function getAllVentas() {
        return $this->db->table('venta')
            ->get()->getResultArray();
    }
}
?>
