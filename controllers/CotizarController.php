<?php
include_once 'dao/clsPlanesDAOImp.php';
class CotizarController {

    public function cotizar($data) {
        // Validar placa: 3 letras + 3 dígitos
        if (empty($data['placa']) || !preg_match('/^[A-Z]{3}\d{3}$/', strtoupper($data['placa']))) {
            return [
                'status' => 400,
                'data' => 'Placa inválida. Debe tener el formato ABC123.'
            ];
        }
        // Normalizar placa (por si viene en minúsculas)
        $placa = strtoupper($data['placa']);
        // Consulta a la tabla planes por placa exacta
        $planes = PlanesDAOImp::getInstance()->getAll(null,  " placa = '$placa'");

        if (empty($planes)) {
            return [
                'status' => 404,
                'data' => 'No hay planes para esta placa'
            ];
        }
        // Generar respuesta
        $cotizacion = [];
        foreach ($planes as $plan) {
            $cotizacion[] = [
                'noCotizacion' => uniqid(),
                'placa' => $placa,
                'valor' => '$ ' . number_format($plan->getPlanValor(), 0, ',', '.'),
                'nombreProducto' => $plan->getPlanDescripcion(),
            ];
        }
        return [
            'status' => 200,
            'data' => $cotizacion
        ];
    }
}
