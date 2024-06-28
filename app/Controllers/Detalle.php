<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\DetalleModel;

class Detalle extends Controller
{
    public function index()
    {
        $model = new DetalleModel();
        $detalle = $model->findAll();

        $data = (!empty($detalle)) ? [
            "Status" => 200,
            "Total de detalleventa" => count($detalle),
            "Detalles" => $detalle
        ] : [
            "Status" => 200,
            "Total de detalleventa" => 0,
            "Detalles" => "No hay detalleventa -_-"
        ];

        return $this->response->setJSON($data);
    }

    public function show($id)
    {
        $model = new DetalleModel();
        $detalle = $model->find($id);

        $data = (!empty($detalle)) ? [
            "Status" => 200,
            "Detalles" => $detalle
        ] : [
            "Status" => 404,
            "Detalles" => "No hay detalleventa o tu código está mal -_-"
        ];

        return $this->response->setJSON($data);
    }

    public function create()
    {
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();

        $datos = [
            "cantidad" => $request->getVar("cantidad"),
            "preciototal" => $request->getVar("preciototal"),
            "idventa" => $request->getVar("idventa"),
            "idproducto" => $request->getVar("idproducto")
        ];

        $validation->setRules([
            "cantidad" => 'required|string|max_length[255]',
            "preciototal" => 'required|numeric',
            "idventa" => 'required|integer',
            "idproducto" => 'required|integer'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            $errors = $validation->getErrors();
            $data = ["Status" => 404, "Detalle" => $errors];
        } else {
            $model = new DetalleModel();
            $model->insert($datos);
            $data = ["Status" => 200, "Detalle" => "detalleventa exitoso"];
        }

        return $this->response->setJSON($data);
    }

    public function update($id)
    {
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();

        $datos = $this->request->getRawInput();

        $validation->setRules([
            "cantidad" => 'required|string|max_length[255]',
            "preciototal" => 'required|numeric',
            "idventa" => 'required|integer',
            "idproducto" => 'required|integer'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            $errors = $validation->getErrors();
            $data = ["Status" => 404, "Detalle" => $errors];
        } else {
            $model = new DetalleModel();
            $detalle = $model->find($id);

            if (is_null($detalle)) {
                $data = ["Status" => 404, "Detalles" => "detalleventa no existe"];
            } else {
                $model->update($id, $datos);
                $data = ["Status" => 200, "Detalle" => "Datos Actualizados"];
            }
        }

        return $this->response->setJSON($data);
    }

    public function delete($id)
    {
        $model = new DetalleModel();
        $detalle = $model->find($id);

        if (!empty($detalle)) {
            $model->delete($id);
            $data = ["Status" => 200, "Detalles" => "Se ha eliminado detalleventa"];
        } else {
            $data = ["Status" => 404, "Detalles" => "No hay detalleventa -_-"];
        }

        return $this->response->setJSON($data);
    }
}
?>
