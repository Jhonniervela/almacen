<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\ReporteModel;
use App\Models\UsuariosModel;

class Reporte extends Controller
{
    public function index()
    {
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();
        $model = new UsuariosModel();
           $usuario = $model->findAll();



           $model = new ReporteModel();
           $rol = $model->findAll();
           if(!empty($rol)){
               $data = array(
                   "Status"=>200, 
                   "Total de roles"=>count($rol),
                   "Detalle"=>$rol
               );
           }
           else{
               $data = array(
                   "Status"=>404,
                   "Total de roles"=>0,
                   "Detalles"=>"No hay roles"
               );
           }
           return json_encode($data, true);
       
}
    public function show($id)
    {
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();
        $model = new UsuariosModel();
           $usuario = $model->findAll();
        //var_dump($usuario); die;
        foreach ($usuario as $key => $value) {
            if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
                //var_dump($usuario); die;
                if ($request->getHeader('Authorization') == 'Authorization: Basic ' . base64_encode($value['nombreusuario'] . ':' . $value['contraseña'])) {
                    $model = new ReporteModel();
                    $reporte = $model->getId($id);
                    //var_dump($reporte); die;
                    if (!empty($reporte)) {
                        $data = array(
                            "Status" => 200,
                            "Detalles" => $reporte
                        );
                    } else {
                        $data = array(
                            "Status" => 404,
                            "Detalles" => "No hay usuario o tu c0digo está mal -_-"
                        );
                    }
                    return json_encode($data, true);
                } else {
                    $data = array(
                        "Status" => 404,
                        "Detalles" => "El token es incorrecto o tu cwdigo está mal -_-"
                    );
                }
            } else {
                $data = array(
                    "Status" => 404,
                    "Detalles" => "No posee autorización"
                );
            }
        }
        return json_encode($data, true);
    }
    public function create()
    {
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();
        $model = new UsuariosModel();
           $usuario = $model->findAll();
        // var_dump($usuario); die; 
        foreach ($usuario as $key => $value) {
            if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
                if ($request->getHeader('Authorization') == 'Authorization: Basic ' . base64_encode($value['nombreusuario'] . ':' . $value['contraseña'])) {
                    $datos = array(
                        
                        "fechasalida" => $request->getVar("fechasalida"),
                        "comentario" => $request->getVar("comentario"),
                        "idproducto" => $request->getVar("idproducto")
                    );
                    if (!empty($datos)) {
                        $validation->setRules([
                           
                            "fechasalida" => 'required|string|max_length[255]',
                            "comentario" => 'required|string|max_length[255]',
                            "idproducto" => 'required|integer'
                        ]);
                        $validation->withRequest($this->request)->run();
                        if ($validation->getErrors()) {
                            $errors = $validation->getErrors();
                            $data = array("Status" => 404, "Detalle" => $errors);
                            return json_encode($data, true);
                        } else {
                            $datos = array(
                              
                                "fechasalida" => $datos["fechasalida"],
                                "comentario" => $datos["comentario"],
                                "idproducto" => $datos["idproducto"]
                            );
                            $model = new ReporteModel();
                            $reporte = $model->insert($datos);
                            $data = array(
                                "Status" => 200,
                                "Detalle" => "usuario existoso"
                            );
                            return json_encode($data, true);
                        }
                    } else {
                        $data = array(
                            "Status" => 404,
                            "Detalle" => "usuario con errores"
                        );
                        return json_encode($data, true);
                    }
                } else {
                    $data = array(
                        "Status" => 404,
                        "Detalles" => "El token es incorrecto"
                    );
                }
            } else {
                $data = array(
                    "Status" => 404,
                    "Detalles" => "No posee autorización"
                );
            }
        }
        return json_encode($data, true);
    }
    public function update($id)
    {
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();
        $model = new UsuariosModel();
           $usuario = $model->findAll();

        // var_dump($usuario); die; 

        foreach($usuario as $key=>$value){
            if(array_key_exists('Authorization',$headers) && !empty($headers['Authorization'])){
                if($request->getHeader('Authorization')=='Authorization: Basic '.base64_encode($value['nombreusuario'].':'.$value['contraseña'])){
                        $datos =$this->request->getRawInput();// jala todo el bloque de datos  y lo valida
                        if(!empty($datos)){
                            $validation->setRules([
                               
                                "fechasalida" => 'required|string|max_length[255]',
                                "comentario" => 'required|string|max_length[255]',
                                "idproducto" => 'required|integer'
                            ]);
                            $validation->withRequest($this->request)->run();
                            if($validation->getErrors()){
                                $errors = $validation->getErrors();
                                $data = array("Status"=>404, "Detalle"=>$errors);
                                return json_encode($data, true);
                            }
                            else{
                              $model = new ReporteModel();
                              $reporte = $model->find($id);
                                if(is_null(($reporte))){
                                    
                                    $data = array (
                                        "Status" =>404,
                                        "Detalles"=> " usuario no existe"
                                    );
                                   
                                }else{
                                    $datos = array(
                                      
                                        "fechasalida" => $datos["fechasalida"],
                                        "comentario" => $datos["comentario"],
                                        "idproducto" => $datos["idproducto"]

                                    );
                                    $model =new ReporteModel();
                                    $reporte = $model ->update($id,$datos);
                                    $data=array(
                                        "Status"=>200,
                                        "Detalle"=> "Datos Actualizados"
                                    );
                                    return json_encode($data,true);

                                }  

                            }
                        }
                        else{
                            $data = array(
                                "Status"=>404,
                                "Detalle"=>"usuario con errores"
                            );
                            return json_encode($data, true);
                        }
                }
                else{
                    $data = array(
                        "Status"=>404,
                        "Detalles"=>"El token es incorrecto"
                    );
                }
            }
            else{
                $data = array(
                    "Status"=>404,
                    "Detalles"=>"No posee autorización"
                );
            }
        }
        return json_encode($data, true);
    }

    public function delete($id)
    {
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();
        $model = new UsuariosModel();
           $usuario = $model->findAll();
        //var_dump($usuario); die;
        foreach ($usuario as $key => $value) {
            if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
                //var_dump($usuario); die;
                if ($request->getHeader('Authorization') == 'Authorization: Basic ' . base64_encode($value['nombreusuario'] . ':' . $value['contraseña'])) {
                    $model = new ReporteModel();
                    $reporte = $model->find($id);
                    //var_dump($reporte); die;
                    if (!empty($reporte)) {
                        $model->delete($id);
                        $data = array(
                            "Status" => 200,
                            "Detalles" => "Se ha eliminado el usuario" 
                        );
                        return json_encode($data, true);
                    } 
                    else {
                        $data = array(
                            "Status" => 404,
                            "Detalles" => "No hay usuario -_-"
                        );
                    }
                    return json_encode($data, true);
                } else {
                    $data = array(
                        "Status" => 404,
                        "Detalles" => "El token es incorrecto o tu cwdigo está mal -_-"
                    );
                }
            } else {
                $data = array(
                    "Status" => 404,
                    "Detalles" => "No posee autorización"
                );
            }
        }
        return json_encode($data, true);
}
}
