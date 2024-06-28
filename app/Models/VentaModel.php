<?php
namespace App\Models;
use CodeIgniter\Model;
class VentaModel extends Model{
    protected $table='venta';
    protected $primaryKey='idventa';
    protected $returnType='array';
    protected $allowedFields =[
        'clienteid', 'nombrecliente','fechaventa'
    ];

      // Retrieve products with their corresponding provider
      public function getVentaWithCliente()
      {
          return $this->db->table('venta c')
              ->join('cliente p', 'c.clienteid = p.clienteid')
              ->get()->getResultArray();
      }
  
      // Retrieve a product by its ID with its corresponding provider
      public function getVentaByIdWithCliente($id)
      {
          return $this->db->table('venta c')
              ->where('c.idventa', $id)
              ->join('cliente p', 'c.clienteid = p.clienteid')
              ->get()->getResultArray();
      }
  
      // Retrieve providers
      public function getCliente()
      {
          return $this->db->table('cliente')
              ->get()->getResultArray();
      }
   
    }



