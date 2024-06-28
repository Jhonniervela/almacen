<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\RolModel;

class Rol extends Controller {
    public function index(){
        $model = new RolModel();
        $rol = $model->findAll();
        
        if(!empty($rol)){
            $data = [
                "Status" => 200, 
                "Total de roles" => count($rol),
                "Detalle" => $rol
            ];
        } else {
            $data = [
                "Status" => 404,
                "Total de roles" => 0,
                "Detalles" => "No hay roles"
            ];
        }
        
        return json_encode($data, true);
    }

    public function show($id){
        $model = new RolModel();
        $rol = $model->find($id);
        
        if(!empty($rol)){
            $data = [
                "Status" => 200, 
                "Detalle" => $rol
            ];
        } else {
            $data = [
                "Status" => 404,
                "Detalles" => "El rol no existe"
            ];
        }
        
        return json_encode($data, true);
    }

    public function create(){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        
        $datos = [
            "nombrerol" => $request->getVar("nombrerol")
        ];
        
        if(!empty($datos)){
            $validation->setRules([
                "nombrerol" => 'required|string|max_length[255]'
            ]);
            
            $validation->withRequest($this->request)->run();
            
            if($validation->getErrors()){
                $errors = $validation->getErrors();
                $data = [
                    "Status" => 404, 
                    "Detalle" => $errors
                ];
            } else {
                $model = new RolModel();
                $rol = $model->insert($datos);
                $data = [
                    "Status" => 200,
                    "Detalle" => "Rol creado exitosamente"
                ];
            }
        } else {
            $data = [
                "Status" => 400,
                "Detalle" => "Datos de rol vacíos"
            ];
        }
        
        return json_encode($data, true);
    }

    public function update($id){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        
        $datos = $this->request->getRawInput();
        
        if(!empty($datos)){
            $validation->setRules([
                "nombrerol" => 'required|string|max_length[255]'
            ]);
            
            $validation->withRequest($this->request)->run();
            
            if($validation->getErrors()){
                $errors = $validation->getErrors();
                $data = [
                    "Status" => 404, 
                    "Detalle" => $errors
                ];
            } else {
                $model = new RolModel();
                $rol = $model->find($id);
                
                if(is_null($rol)){
                    $data = [
                        "Status" => 404,
                        "Detalles" => "El rol no existe"
                    ];
                } else {
                    $datos = [
                        "nombrerol" => $datos["nombrerol"]
                    ];
                    
                    $model->update($id, $datos);
                    $data = [
                        "Status" => 200,
                        "Detalles" => "Datos del rol actualizados"
                    ];
                }
            }
        } else {
            $data = [
                "Status" => 400,
                "Detalle" => "Datos de rol vacíos"
            ];
        }
        
        return json_encode($data, true);
    }

    public function delete($id){
        $model = new RolModel();
        $rol = $model->find($id);
        
        if(!empty($rol)){
            $model->delete($id);
            $data = [
                "Status" => 200, 
                "Detalle" => "Se ha eliminado el rol"
            ];
        } else {
            $data = [
                "Status" => 404,
                "Detalles" => "No hay roles"
            ];
        }
        
        return json_encode($data, true);
    }
    
}
