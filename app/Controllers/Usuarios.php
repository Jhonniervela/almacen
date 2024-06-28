<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\UsuariosModel;
class Usuarios extends Controller {


    public function index(){
        $model = new UsuariosModel();
        // Busca todos los usuarios sin filtrar por el campo 'estado'
        $usuarios = $model->findAll();
    
        if(empty($usuarios)){
            $respuesta = array(
                "error" => true,
                "mensaje" => 'No hay elementos'
            );
            return $this->response->setStatusCode(404)
                                  ->setJSON($respuesta);
        } else {
            return $this->response->setStatusCode(200)
                                  ->setJSON($usuarios);
        }
    }
    

    public function create(){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $datos = array(
            "correo" => $request->getVar("correo"),
            "dnitrabajador" => $request->getVar("dnitrabajador"), // Corrected variable name
            "idrol" => $request->getVar("idrol")
        );
        if(!empty($datos)){
           $validation->setRules([
            "correo" => 'required|string|max_length[255]',
            "dnitrabajador" => 'required|string|max_length[255]', // Corrected variable name
            "idrol" => 'required|string|max_length[255]'
           ]);
           $validation->withRequest($this->request)->run();
           if($validation->getErrors()){
            $error = $validation->getErrors();
            $data = array("Status" => 404, "Detalle" => $error);
            return json_encode($data, true);
           }
           else{
            $nombreusuario = crypt($datos["dnitrabajador"].$datos["correo"].$datos["idrol"], '$2a$07$dfhdfrexfhgdfhdferttgsad$');
            $contraseña = crypt($datos["correo"].$datos["dnitrabajador"].$datos["idrol"], '$2a$07$dfhdfrexfhgdfhdferttgsad$');
            $datos = array(
                "dnitrabajador" => $datos["dnitrabajador"], // Corrected variable name
                "correo" => $datos["correo"],
                "idrol" => $datos["idrol"],
                "nombreusuario" => str_replace('$','a',$nombreusuario),
                "contraseña" => str_replace('$','o',$contraseña)
            );
            $model = new UsuariosModel();
            $usuario = $model->insert($datos);
            $data = array(
                "Status" => 200,
                "Detalle" => "Registro Ok, guarde sus credenciales",
                "credenciales" => array(
                    "nombreusuario" => str_replace('$','a',$nombreusuario),
                    "contraseña" => str_replace('$','o',$contraseña)
                )
            );
            return json_encode($data, true);
        }
    }
        else{
            $data = array(
                "Status" => 400,
                "Detalle" => "Registro con errores"
            );
            return json_encode($data, true);
        }
    }
}

