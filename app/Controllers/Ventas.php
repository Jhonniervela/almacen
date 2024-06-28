<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\VentaModel;

class Ventas extends Controller
{
    public function index()
    {
        $model = new VentaModel();
        $ventas = $model->getVentaWithCliente(); // Utiliza la función para obtener ventas con clientes

        if (!empty($ventas)) {
            $data = [
                "Status" => 200,
                "Total de ventas" => count($ventas),
                "Detalles" => $ventas
            ];
        } else {
            $data = [
                "Status" => 200,
                "Total de ventas" => 0,
                "Detalles" => "No hay ventas"
            ];
        }
        return $this->response->setJSON($data);
    }

    public function show($id)
    {
        $model = new VentaModel();
        $venta = $model->getVentaByIdWithCliente($id); // Utiliza la función para obtener una venta con cliente por ID

        if (!empty($venta)) {
            $data = [
                "Status" => 200,
                "Detalles" => $venta
            ];
        } else {
            $data = [
                "Status" => 404,
                "Detalles" => "La venta no existe"
            ];
        }
        
        return $this->response->setJSON($data);
    }

    public function create()
    {
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();

        $datos = [
            "clienteid" => $request->getVar("clienteid"),
            "fechaventa" => $request->getVar("fechaventa")
        ];

        if (!empty($datos)) {
            $validation->setRules([
                "clienteid" => 'required|integer', // Asegúrate de que clienteid sea válido según tu base de datos
                "fechaventa" => 'required|string|max_length[255]'
            ]);
            $validation->withRequest($this->request)->run();

            if ($validation->getErrors()) {
                $errors = $validation->getErrors();
                $data = [
                    "Status" => 404,
                    "Detalle" => $errors
                ];
            } else {
                $model = new VentaModel();
                $model->insert($datos);
                $data = [
                    "Status" => 200,
                    "Detalle" => "Venta creada exitosamente"
                ];
            }
        } else {
            $data = [
                "Status" => 400,
                "Detalle" => "Datos de la venta vacíos"
            ];
        }
                    
        return $this->response->setJSON($data);
    }

    public function update($id)
    {
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();

        $datos = $this->request->getRawInput();

        if (!empty($datos)) {
            $validation->setRules([
                "clienteid" => 'required|integer', // Asegúrate de que clienteid sea válido según tu base de datos
                "fechaventa" => 'required|string|max_length[255]'
            ]);
            $validation->withRequest($this->request)->run();

            if ($validation->getErrors()) {
                $errors = $validation->getErrors();
                $data = [
                    "Status" => 404,
                    "Detalle" => $errors
                ];
            } else {
                $model = new VentaModel();
                $venta = $model->find($id);

                if (is_null($venta)) {
                    $data = [
                        "Status" => 404,
                        "Detalles" => "La venta no existe"
                    ];
                } else {
                    $model->update($id, $datos);
                    $data = [
                        "Status" => 200,
                        "Detalles" => "Datos de la venta actualizados"
                    ];
                }
            }
        } else {
            $data = [
                "Status" => 400,
                "Detalle" => "Datos de la venta vacíos"
            ];
        }
                        
        return $this->response->setJSON($data);
    }

    public function delete($id)
    {
        $model = new VentaModel();
        $venta = $model->find($id);

        if (!empty($venta)) {
            $model->delete($id);
            $data = [
                "Status" => 200,
                "Detalles" => "Venta eliminada exitosamente"
            ];
        } else {
            $data = [
                "Status" => 404,
                "Detalles" => "La venta no existe"
            ];
        }
        
        return $this->response->setJSON($data);
    }
}
?>
