
<?php
class PagosAhorro_ctrl
{
    public $M_PagosAhorro = null;
    public function __construct()
    {
        $this->M_PagosAhorro = new M_PagosAhorro();
    }

    public function verPagosAhorro($f3)
    {
        $cadenaSql = "SELECT * FROM pagosahorro";

        // Ejecuta la consulta
        $items = $f3->DB->exec($cadenaSql);

        // Formatear la respuesta
        $response = [
            'cantidad' => count($items),
            'data' => $items
        ];

        // Devolver la respuesta en formato JSON
        echo json_encode($response);
    }


    //Registrar pagos ahorro
    public function registrarPagosAhorro($f3)
    {
        $mensaje = "";
        $newId = 0;
        $retorno = 0;

        // Obtener los datos del pagos ahorro desde la solicitud POST
        $monto = $f3->get('POST.monto');
        $fecha = $f3->get('POST.fecha');
        $meta_id = $f3->get('POST.meta_id');
        $usuario_id = $f3->get('POST.usuario_id');
        $estado_pago = $f3->get('POST.estado_pago');

        // Validar datos
        if (empty($monto) || empty($fecha) || empty($meta_id) || empty($usuario_id)) {
            $mensaje = "Todos los campos son obligatorios.";
            $retorno = 0;
        } else {
            // Insertar el nuevo pagos ahorro en la base de datos
            $this->M_PagosAhorro->set('monto', $monto);
            $this->M_PagosAhorro->set('fecha', $fecha);
            $this->M_PagosAhorro->set('meta_id', $meta_id);
            $this->M_PagosAhorro->set('usuario_id', $usuario_id);
            $this->M_PagosAhorro->set('estado_pago', $estado_pago);
            $this->M_PagosAhorro->save();

            $mensaje = "Pagos ahorro registrado correctamente";
            $newId = $this->M_PagosAhorro->get('id'); // Obtener el ID del nuevo pagos ahorro registrado
            $retorno = 1;
        }

        // Devolver la respuesta en formato JSON
        echo json_encode([
            'mensaje' => $mensaje,
            'id' => $newId,
            'retorno' => $retorno
        ]);
    }
}
