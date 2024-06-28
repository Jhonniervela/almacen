<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ProveedorModel;

class Proveedor extends Controller {

    public function index(){
        $model = new ProveedorModel();
        $proveedores = $model->findAll();
        
        if (!empty($proveedores)) {
            $data = [
                "Status" => 200, 
                "Total de proveedores" => count($proveedores),
                "Detalles" => $proveedores
            ];
        } else {
            $data = [
                "Status" => 404,
                "Total de proveedores" => 0,
                "Detalles" => "No hay proveedores"
            ];
        }
        
        return $this->response->setStatusCode(200)->setJSON($data);
    }
      
    public function show($id){
        $model = new ProveedorModel();
        $proveedor = $model->find($id);
        
        if (!empty($proveedor)) {
            $data = [
                "Status" => 200, 
                "Detalles" => $proveedor
            ];
        } else {
            $data = [
                "Status" => 404,
                "Detalles" => "El proveedor no existe"
            ];
        }
        
        return $this->response->setStatusCode(200)->setJSON($data);
    }

    public function create(){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();

        $datos = [
            "nombreproveedor" => $request->getVar("nombreproveedor"),
            "contacto" => $request->getVar("contacto"),
            "direccion" => $request->getVar("direccion")
        ];

        if (!empty($datos)) {
            $validation->setRules([
                "nombreproveedor" => 'required|string|max_length[255]',
                "contacto" => 'required|string|max_length[255]',
                "direccion" => 'required|string|max_length[255]'
            ]);
            $validation->withRequest($this->request)->run();

            if ($validation->getErrors()) {
                $errors = $validation->getErrors();
                $data = [
                    "Status" => 404, 
                    "Detalles" => $errors
                ];
            } else {
                $model = new ProveedorModel();
                $model->insert($datos);
                $data = [
                    "Status" => 200,
                    "Detalles" => "Proveedor creado exitosamente"
                ];
            }
        } else {
            $data = [
                "Status" => 400,
                "Detalles" => "Datos del proveedor vacíos"
            ];
        }
                    
        return $this->response->setStatusCode(200)->setJSON($data);
    }

    public function update($id){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $datos = $this->request->getRawInput();
                  
        if (!empty($datos)) {
            $validation->setRules([
                "nombreproveedor" => 'required|string|max_length[255]',
                "contacto" => 'required|string|max_length[255]',
                "direccion" => 'required|string|max_length[255]'
            ]);

            $validation->withRequest($this->request)->run();

            if ($validation->getErrors()) {
                $errors = $validation->getErrors();
                $data = [
                    "Status" => 404, 
                    "Detalles" => $errors
                ];
            } else {
                $model = new ProveedorModel();
                $proveedor = $model->find($id);
                           
                if (is_null($proveedor)) {
                    $data = [
                        "Status" => 404,
                        "Detalles" => "El proveedor no existe"
                    ];
                } else {
                    $model->update($id, $datos);
                    $data = [
                        "Status" => 200,
                        "Detalles" => "Datos del proveedor actualizados"
                    ];
                }
            }
        } else {
            $data = [
                "Status" => 400,
                "Detalles" => "Datos del proveedor vacíos"
            ];
        }
                        
        return $this->response->setStatusCode(200)->setJSON($data);   
    }

    public function delete($id){
        $model = new ProveedorModel();
        $proveedor = $model->find($id);
        
        if (!empty($proveedor)) {
            $model->delete($id);
            $data = [
                "Status" => 200, 
                "Detalles" => "Proveedor eliminado exitosamente"
            ];
        } else {
            $data = [
                "Status" => 404,
                "Detalles" => "El proveedor no existe"
            ];
        }
        
        return $this->response->setStatusCode(200)->setJSON($data);
    }
}
?>
