<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ProductoModel;

class Productos extends Controller
{
    public function index()
    {
        $model = new ProductoModel();
        $productos = $model->getProductoWithCategoria();

        $data = [
            "status" => 200,
            "total_productos" => count($productos),
            "detalles" => $productos ?: "No hay productos disponibles"
        ];
        
        return $this->response->setJSON($data);
    }

    public function show($id)
    {
        $model = new ProductoModel();
        $producto = $model->getProductoByIdWithCategoria($id);

        if ($producto) {
            $data = [
                "status" => 200,
                "detalles" => $producto
            ];
        } else {
            $data = [
                "status" => 404,
                "detalles" => "Producto no encontrado"
            ];
        }
        
        return $this->response->setJSON($data);
    }

    public function create()
    {
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        
        $datos = [
            "nombreproducto" => $request->getVar("nombreproducto"),
            "precioventa" => $request->getVar("precioventa"),
            "ubicacionproducto" => $request->getVar("ubicacionproducto"),
            "codigobarras" => $request->getVar("codigobarras"),
            "idcategoria" => $request->getVar("idcategoria"),
            "idproveedor" => $request->getVar("idproveedor")
        ];

        $validation->setRules([
            "nombreproducto" => 'required|string|max_length[255]',
            "precioventa" => 'required|string|max_length[255]',
            "ubicacionproducto" => 'required|string|max_length[255]',
            "codigobarras" => 'required|string|max_length[255]',
            "idcategoria" => 'required|integer',
            "idproveedor" => 'required|integer'
        ]);

        if ($validation->withRequest($request)->run() === false) {
            $errors = $validation->getErrors();
            $data = [
                "status" => 400,
                "detalle" => $errors
            ];
        } else {
            $model = new ProductoModel();
            $model->insert($datos);
            $data = [
                "status" => 201,
                "detalle" => "Producto creado exitosamente"
            ];
        }
        
        return $this->response->setJSON($data);
    }

    public function update($id)
    {
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        
        $datos = $request->getRawInput();

        $validation->setRules([
            "nombreproducto" => 'required|string|max_length[255]',
            "precioventa" => 'required|string|max_length[255]',
            "ubicacionproducto" => 'required|string|max_length[255]',
            "codigobarras" => 'required|string|max_length[255]',
            "idcategoria" => 'required|integer',
            "idproveedor" => 'required|integer'
        ]);

        if ($validation->withRequest($request)->run() === false) {
            $errors = $validation->getErrors();
            $data = [
                "status" => 400,
                "detalle" => $errors
            ];
        } else {
            $model = new ProductoModel();
            $producto = $model->find($id);

            if (is_null($producto)) {
                $data = [
                    "status" => 404,
                    "detalle" => "Producto no encontrado"
                ];
            } else {
                $model->update($id, $datos);
                $data = [
                    "status" => 200,
                    "detalle" => "Datos actualizados"
                ];
            }
        }

        return $this->response->setJSON($data);
    }

    public function delete($id)
    {
        $model = new ProductoModel();
        $producto = $model->find($id);

        if (!empty($producto)) {
            $model->delete($id);
            $data = [
                "status" => 200,
                "detalle" => "Producto eliminado correctamente"
            ];
        } else {
            $data = [
                "status" => 404,
                "detalle" => "Producto no encontrado"
            ];
        }

        return $this->response->setJSON($data);
    }
}
