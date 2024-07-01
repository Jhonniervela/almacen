<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UsuariosModel;

class Usuarios extends Controller {

    public function index(){
        $model = new UsuariosModel();
        $usuarios = $model->findAll();
        
        if (!empty($usuarios)) {
            $data = [
                "Status" => 200, 
                "Total de usuarios" => count($usuarios),
                "Detalles" => $usuarios
            ];
        } else {
            $data = [
                "Status" => 404,
                "Total de usuarios" => 0,
                "Detalles" => "No hay usuarios"
            ];
        }
        
        return $this->response->setStatusCode(200)->setJSON($data);
    }
      
    public function show($id){
        $model = new UsuariosModel();
        $usuario = $model->find($id);
        
        if (!empty($usuario)) {
            $data = [
                "Status" => 200, 
                "Detalles" => $usuario
            ];
        } else {
            $data = [
                "Status" => 404,
                "Detalles" => "El usuario no existe"
            ];
        }
        
        return $this->response->setStatusCode(200)->setJSON($data);
    }

    public function create(){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();

        $datos = [
           
            "nombreusuario" => $request->getVar("nombreusuario"),
            "contraseña" => $request->getVar("contraseña"),
            "correo" => $request->getVar("correo"),
            "dnitrabajador" => $request->getVar("dnitrabajador"),
            "idrol" => $request->getVar("idrol")
        ];

        if (!empty($datos)) {
            $validation->setRules([
               
                "nombreusuario" => 'required|string|max_length[255]',
                "contraseña" => 'required|string|max_length[255]',
                "correo" => 'required|string|valid_email|max_length[255]',
                "dnitrabajador" => 'required|string|max_length[255]',
                "idrol" => 'required|integer'
            ]);
            $validation->withRequest($this->request)->run();

            if ($validation->getErrors()) {
                $errors = $validation->getErrors();
                $data = [
                    "Status" => 404, 
                    "Detalles" => $errors
                ];
            } else {
                $model = new UsuariosModel();
                $model->insert($datos);
                $data = [
                    "Status" => 200,
                    "Detalles" => "Usuario creado exitosamente"
                ];
            }
        } else {
            $data = [
                "Status" => 400,
                "Detalles" => "Datos del usuario vacíos"
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
               
                "nombreusuario" => 'required|string|max_length[255]',
                "contraseña" => 'required|string|max_length[255]',
                "correo" => 'required|string|valid_email|max_length[255]',
                "dnitrabajador" => 'required|string|max_length[255]',
                "idrol" => 'required|integer'
            ]);

            $validation->withRequest($this->request)->run();

            if ($validation->getErrors()) {
                $errors = $validation->getErrors();
                $data = [
                    "Status" => 404, 
                    "Detalles" => $errors
                ];
            } else {
                $model = new UsuariosModel();
                $usuario = $model->find($id);
                           
                if (is_null($usuario)) {
                    $data = [
                        "Status" => 404,
                        "Detalles" => "El usuario no existe"
                    ];
                } else {
                    $model->update($id, $datos);
                    $data = [
                        "Status" => 200,
                        "Detalles" => "Datos del usuario actualizados"
                    ];
                }
            }
        } else {
            $data = [
                "Status" => 400,
                "Detalles" => "Datos del usuario vacíos"
            ];
        }
                        
        return $this->response->setStatusCode(200)->setJSON($data);   
    }

    public function delete($id){
        $model = new UsuariosModel();
        $usuario = $model->find($id);
        
        if (!empty($usuario)) {
            $model->delete($id);
            $data = [
                "Status" => 200, 
                "Detalles" => "Usuario eliminado exitosamente"
            ];
        } else {
            $data = [
                "Status" => 404,
                "Detalles" => "El usuario no existe"
            ];
        }
        
        return $this->response->setStatusCode(200)->setJSON($data);
    }
}
?>
