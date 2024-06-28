<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\CategoriaModel;
use App\Models\UsuariosModel;

class Categorias extends Controller {

    public function index(){
        $model = new UsuariosModel();
        $usuario = $model->findAll();

        $model = new CategoriaModel();
        $categoria = $model->findAll();

        if (!empty($categoria)) {
            $data = [
                "Status" => 200,
                "Total de categorias" => count($categoria),
                "Detalles" => $categoria
            ];
        } else {
            $data = [
                "Status" => 404,
                "Total de categorias" => 0,
                "Detalles" => "No hay categorias"
            ];
        }

        return $this->response->setJSON($data);
    }

    public function show($id){
        $model = new CategoriaModel();
        $categoria = $model->find($id);

        if (!empty($categoria)) {
            $data = [
                "Status" => 200,
                "Detalles" => $categoria
            ];
        } else {
            $data = [
                "Status" => 404,
                "Detalles" => "La Categoria no existe"
            ];
        }

        return $this->response->setJSON($data);
    }

    public function create(){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();

        $datos = [
            "nombrecategoria" => $request->getVar("nombrecategoria")
        ];

        if (!empty($datos)) {
            $validation->setRules([
                "nombrecategoria" => 'required|string|max_length[255]'
            ]);

            if ($validation->withRequest($this->request)->run() === FALSE) {
                $errors = $validation->getErrors();
                $data = [
                    "Status" => 404,
                    "Detalles" => $errors
                ];
            } else {
                $model = new CategoriaModel();
                try {
                    $model->insert($datos);
                    $data = [
                        "Status" => 200,
                        "Detalles" => "Categoria creada exitosamente"
                    ];
                } catch (\Exception $e) {
                    $data = [
                        "Status" => 500,
                        "Detalles" => "Error al crear la categoria: " . $e->getMessage()
                    ];
                }
            }
        } else {
            $data = [
                "Status" => 400,
                "Detalles" => "Datos de categoría vacíos"
            ];
        }

        return $this->response->setJSON($data);
    }

    public function update($id){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();

        $datos = $this->request->getRawInput();

        if (!empty($datos)) {
            $validation->setRules([
                "nombrecategoria" => 'required|string|max_length[255]'
            ]);

            if ($validation->withRequest($this->request)->run() === FALSE) {
                $errors = $validation->getErrors();
                $data = [
                    "Status" => 404,
                    "Detalles" => $errors
                ];
            } else {
                $model = new CategoriaModel();
                $categoria = $model->find($id);

                if (is_null($categoria)) {
                    $data = [
                        "Status" => 404,
                        "Detalles" => "La categoria no existe"
                    ];
                } else {
                    $model->update($id, ["nombrecategoria" => $datos["nombrecategoria"]]);
                    $data = [
                        "Status" => 200,
                        "Detalles" => "Datos de la categoria actualizados"
                    ];
                }
            }
        } else {
            $data = [
                "Status" => 400,
                "Detalles" => "Datos de la categoria vacíos"
            ];
        }

        return $this->response->setJSON($data);
    }

    public function delete($id){
        $model = new CategoriaModel();
        $categoria = $model->find($id);

        if (!empty($categoria)) {
            $model->delete($id);
            $data = [
                "Status" => 200,
                "Detalles" => "Se ha eliminado la categoria"
            ];
        } else {
            $data = [
                "Status" => 404,
                "Detalles" => "No hay categorias"
            ];
        }

        return $this->response->setJSON($data);
    }
}
?>
