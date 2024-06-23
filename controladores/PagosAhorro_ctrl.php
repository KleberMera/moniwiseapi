
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

    //ver pagos ahorro por usuario
    public function verPagosAhorroUsuario($f3)
    {
        $cadenaSql = "SELECT * FROM pagosahorro WHERE usuario_id = ?";
        $usuario_id = $f3->get('POST.usuario_id');
        $f3->set('usuario_id', $usuario_id);
        $items = $f3->DB->exec($cadenaSql, [$usuario_id]);

        // Formatear la respuesta
        $response = [
            'cantidad' => count($items),
            'data' => $items
        ];

        // Devolver la respuesta en formato JSON
        echo json_encode($response);
    }

    public function cambiarEstadoPagosAhorro($f3)
    {
        $id = $f3->get('POST.id');
        $estado_pago = $f3->get('POST.estado_pago');

        // Cargar el pagos ahorro por su ID
        $this->M_PagosAhorro->load(['id=?', $id]);

        if ($this->M_PagosAhorro->loaded() > 0) {
            // Actualizar el estado del pagos ahorro
            $this->M_PagosAhorro->set('estado_pago', $estado_pago);
            $this->M_PagosAhorro->save();

            $mensaje = "Estado del pagos ahorro actualizado correctamente.";
            $retorno = 1;
        } else {
            $mensaje = "Pagos ahorro no encontrado.";
            $retorno = 0;
        }

        // Devolver la respuesta en formato JSON
        echo json_encode([
            'mensaje' => $mensaje,
            'retorno' => $retorno
        ]); 
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


    public function verPagosAhorroUsuarioDatos($f3)
    {
        $usuario_id = $f3->get('POST.usuario_id');
        $cadenaSql = "
            SELECT 
                usuario_id,
                COUNT(*) AS total_pagos,
                SUM(CASE WHEN estado_pago = 1 THEN 1 ELSE 0 END) AS pagos_realizados,
                SUM(CASE WHEN estado_pago = 0 OR estado_pago IS NULL THEN 1 ELSE 0 END) AS pagos_pendientes,
                SUM(monto) AS monto_total,
                SUM(CASE WHEN estado_pago = 1 THEN monto ELSE 0 END) AS monto_pagado,
                SUM(CASE WHEN estado_pago = 0 OR estado_pago IS NULL THEN monto ELSE 0 END) AS monto_pendiente
            FROM 
                pagosahorro
            WHERE 
                usuario_id = ?
            GROUP BY 
                usuario_id";
        
        // Ejecuta la consulta
        $items = $f3->DB->exec($cadenaSql, [$usuario_id]);

        // Formatear la respuesta
        $response = [
            'data' => $items
        ];

        // Devolver la respuesta en formato JSON
        echo json_encode($response);
    }


    
    public function gastosPorCategoriaUsuario($f3)
    {
        $usuario_id = $f3->get('POST.usuario_id');

       $cadenaSql = "SELECT c.nombre, SUM(g.monto) as total_gasto
            FROM gastos g
            JOIN categorias c ON g.categoria_id = c.id
            WHERE g.usuario_id = ?
            GROUP BY c.nombre";

        $items = $f3->DB->exec($cadenaSql, [$usuario_id]);

        // Formatear la respuesta
        $response = [
            'data' => $items
        ];

        // Devolver la respuesta en formato JSON
        echo json_encode($response);
    }
}
