<?php
namespace App\Models;
use CodeIgniter\Model;
class ReporteModel extends Model{
    protected $table='reporte';
    protected $primaryKey='idreporte';
    protected $returnType='array';
    protected $allowedFields =[
        'fechasalida', 'comentario','idproducto'
    ];

    //como es una tabla que tiene llaves forañeas vamos a crear la relacion de modelo//
    public function getReportes(){
        return $this->db->table('losreportes c')
        ->where('c.estado',1)
        ->join('producto tp', 'c.idproducto = tp.idproducto')
        ->get()->getResultArray();
    }
    public function getId($id){
        return $this->db->table('losreportes c')
        ->where('c.idreporte', $id)
        ->where('c.estado', 1)
        ->join('producto', 'c.idproducto = tp.idproducto')
        ->get()->getResultArray();
    }
    public function getProductos(){
        return $this->db->table('producto')
        ->where('tp.estado',1)
        ->get()->getResultArray();
    }
    }