
<?php
class SueldoFijo_ctrl
{
    public $M_SueldoFijo = null;
    public function __construct()
    {
        $this->M_SueldoFijo = new M_SueldoFijo();
    }

    public function verSueldoFijo($f3)
    {
        $cadenaSql = "SELECT * FROM sueldofijo";

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


    public function verSueldoFijoPorUsuario($f3)
    {
        $usuario_id = $f3->get('POST.usuario_id');

        if (empty($usuario_id)) {
            echo json_encode([
                'mensaje' => 'El usuario_id es obligatorio.',
                'data' => [],
                'retorno' => 0
            ]);
            return;
        }

        $cadenaSql = "SELECT * FROM sueldofijo WHERE usuario_id = ?";

        // Ejecuta la consulta
        $items = $f3->DB->exec($cadenaSql, $usuario_id);

        // Formatear la respuesta
        $response = [
            'cantidad' => count($items),
            'data' => $items,
            'retorno' => 1
        ];

        // Devolver la respuesta en formato JSON
        echo json_encode($response);
    }




    public function registrarSueldoFijo($f3)
    {
        $mensaje = "";
        $newId = 0;
        $retorno = 0;

        // Obtener los datos del sueldo fijo desde la solicitud POST
        $monto = $f3->get('POST.monto');
        $frecuencia_id = $f3->get('POST.frecuencia_id');
        $fecha_inicio = $f3->get('POST.fecha_inicio');
        $fecha_final = $f3->get('POST.fecha_final');
        $usuario_id = $f3->get('POST.usuario_id');
        $estado = $f3->get('POST.estado');

        // Validar datos
        if (empty($monto) || empty($frecuencia_id) || empty($fecha_inicio) || empty($usuario_id) || empty($estado)) {
            $mensaje = "Todos los campos son obligatorios.";
            $retorno = 0;
        } else {
            // Insertar el nuevo sueldo fijo en la base de datos
            $this->M_SueldoFijo->set('monto', $monto);
            $this->M_SueldoFijo->set('frecuencia_id', $frecuencia_id);
            $this->M_SueldoFijo->set('fecha_inicio', $fecha_inicio);
            $this->M_SueldoFijo->set('fecha_final', $fecha_final);
            $this->M_SueldoFijo->set('usuario_id', $usuario_id);
            $this->M_SueldoFijo->set('estado', $estado);
            $this->M_SueldoFijo->save();

            $mensaje = "Sueldo fijo registrado correctamente";
            $newId = $this->M_SueldoFijo->get('id'); // Obtener el ID del nuevo sueldo fijo registrado
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