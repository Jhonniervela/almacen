<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ClienteModel;

class Cliente extends Controller {

    public function index(){
        $model = new ClienteModel();
        $clientes = $model->findAll();
        
        if (!empty($clientes)) {
            $data = [
                "Status" => 200, 
                "Total de clientes" => count($clientes),
                "Detalles" => $clientes
            ];
        } else {
            $data = [
                "Status" => 404,
                "Total de clientes" => 0,
                "Detalles" => "No hay clientes"
            ];
        }
        
        return $this->response->setStatusCode(200)->setJSON($data);
    }
      
    public function show($id){
        $model = new ClienteModel();
        $cliente = $model->find($id);
        
        if (!empty($cliente)) {
            $data = [
                "Status" => 200, 
                "Detalles" => $cliente
            ];
        } else {
            $data = [
                "Status" => 404,
                "Detalles" => "El cliente no existe"
            ];
        }
        
        return $this->response->setStatusCode(200)->setJSON($data);
    }

    public function create(){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();

        $datos = [
            "DNI" => $request->getVar("DNI"),
            "Nombre" => $request->getVar("Nombre"),
            "ApellidoPaterno" => $request->getVar("ApellidoPaterno"),
            "ApellidoMaterno" => $request->getVar("ApellidoMaterno"),
            "Telefono" => $request->getVar("Telefono")
        ];

        if (!empty($datos)) {
            $validation->setRules([
                "DNI" => 'required|string|max_length[255]',
                "Nombre" => 'required|string|max_length[255]',
                "ApellidoMaterno" => 'required|string|max_length[255]',
                "Telefono" => 'required|string|max_length[255]',
                "ApellidoPaterno" => 'required|string|max_length[255]'
            ]);
            $validation->withRequest($this->request)->run();

            if ($validation->getErrors()) {
                $errors = $validation->getErrors();
                $data = [
                    "Status" => 404, 
                    "Detalles" => $errors
                ];
            } else {
                $model = new ClienteModel();
                $model->insert($datos);
                $data = [
                    "Status" => 200,
                    "Detalles" => "cliente creado exitosamente"
                ];
            }
        } else {
            $data = [
                "Status" => 400,
                "Detalles" => "Datos del cliente vacíos"
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
                "DNI" => 'required|string|max_length[255]',
                "Nombre" => 'required|string|max_length[255]',
                "ApellidoMaterno" => 'required|string|max_length[255]',
                "Telefono" => 'required|string|max_length[255]',
                "ApellidoPaterno" => 'required|string|max_length[255]'
            ]);

            $validation->withRequest($this->request)->run();

            if ($validation->getErrors()) {
                $errors = $validation->getErrors();
                $data = [
                    "Status" => 404, 
                    "Detalles" => $errors
                ];
            } else {
                $model = new ClienteModel();
                $cliente = $model->find($id);
                           
                if (is_null($cliente)) {
                    $data = [
                        "Status" => 404,
                        "Detalles" => "El cliente no existe"
                    ];
                } else {
                    $model->update($id, $datos);
                    $data = [
                        "Status" => 200,
                        "Detalles" => "Datos del cliente actualizados"
                    ];
                }
            }
        } else {
            $data = [
                "Status" => 400,
                "Detalles" => "Datos del cliente vacíos"
            ];
        }
                        
        return $this->response->setStatusCode(200)->setJSON($data);   
    }

    public function delete($id){
        $model = new ClienteModel();
        $cliente = $model->find($id);
        
        if (!empty($cliente)) {
            $model->delete($id);
            $data = [
                "Status" => 200, 
                "Detalles" => "cliente eliminado exitosamente"
            ];
        } else {
            $data = [
                "Status" => 404,
                "Detalles" => "El cliente no existe"
            ];
        }
        
        return $this->response->setStatusCode(200)->setJSON($data);
    }
}
?>
