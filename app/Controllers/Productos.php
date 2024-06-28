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

        if (!empty($productos)) {
            $data = array(
                "Status" => 200,
                "Total de productos" => count($productos),
                "Detalles" => $productos
            );
        } else {
            $data = array(
                "Status" => 200,
                "Total de productos" => 0,
                "Detalles" => "No hay productos -_-"
            );
        }
        
        return json_encode($data, true);
    }

    public function show($id)
    {
        $model = new ProductoModel();
        $producto = $model->getProductoByIdWithCategoria($id);
        
        if (!empty($producto)) {
            $data = array(
                "Status" => 200,
                "Detalles" => $producto
            );
        } else {
            $data = array(
                "Status" => 404,
                "Detalles" => "No hay producto o tu código está mal -_-"
            );
        }
        
        return json_encode($data, true);
    }

    public function create()
    {
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        
        $datos = array(
            "nombreproducto" => $request->getVar("nombreproducto"),
            "precioventa" => $request->getVar("precioventa"),
            "ubicacionproducto" => $request->getVar("ubicacionproducto"),
            "codigobarras" => $request->getVar("codigobarras"),
            "idcategoria" => $request->getVar("idcategoria"),
            "idproveedor" => $request->getVar("idproveedor")
        );

        if (!empty($datos)) {
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
                $data = array("Status" => 404, "Detalle" => $errors);
            } else {
                $model = new ProductoModel();
                $model->insert($datos);
                $data = array(
                    "Status" => 200,
                    "Detalle" => "Producto creado exitosamente"
                );
            }
        } else {
            $data = array(
                "Status" => 404,
                "Detalle" => "Producto con errores"
            );
        }
        
        return json_encode($data, true);
    }

    public function update($id)
    {
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        
        $datos = $request->getRawInput();

        if (!empty($datos)) {
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
                $data = array("Status" => 404, "Detalle" => $errors);
            } else {
                $model = new ProductoModel();
                $producto = $model->find($id);

                if (is_null($producto)) {
                    $data = array(
                        "Status" => 404,
                        "Detalles" => "Producto no existe"
                    );
                } else {
                    $model->update($id, $datos);
                    $data = array(
                        "Status" => 200,
                        "Detalle" => "Datos actualizados"
                    );
                }
            }
        } else {
            $data = array(
                "Status" => 404,
                "Detalle" => "Producto con errores"
            );
        }

        return json_encode($data, true);
    }

    public function delete($id)
    {
        $model = new ProductoModel();
        $producto = $model->find($id);

        if (!empty($producto)) {
            $model->delete($id);
            $data = array(
                "Status" => 200,
                "Detalles" => "Se ha eliminado el producto"
            );
        } else {
            $data = array(
                "Status" => 404,
                "Detalles" => "No hay producto -_-"
            );
        }

        return json_encode($data, true);
    }
}
