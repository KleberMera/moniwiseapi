
<?php
class Gastos_ctrl
{
    public $M_Gastos = null;
    public function __construct()
    {
        $this->M_Gastos = new M_Gastos();
    }

    public function verGastos($f3)
    {
        $cadenaSql = "SELECT * FROM gastos";

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






    public function registrarGastos($f3)
    {

        $monto = $f3->get('POST.monto');
        $fecha = $f3->get('POST.fecha');
        $descripcion = $f3->get('POST.descripcion');
        $categoria_id  = $f3->get('POST.categoria_id');
        $usuario_id = $f3->get('POST.usuario_id');
        $estado_pago = $f3->get('POST.estado_pago');
        $retorno = 0;

        //Validar el ingreso de todos los campos
        if (empty($monto) || empty($fecha) || empty($descripcion) || empty($categoria_id) || empty($usuario_id)) {
            echo json_encode(
                [
                    'mensaje' => 'Los campos no pueden estar vacíos',
                    'retorno' => 0
                ]
            );
        } else {
            //Insertar el nuevo ingreso en la base de datos
            $cadenaSql = "INSERT INTO gastos (monto, fecha, descripcion, categoria_id, usuario_id, estado_pago) VALUES (:monto, :fecha, :descripcion, :categoria_id, :usuario_id, :estado_pago)";

            // Ejecuta la consulta
            $f3->DB->exec($cadenaSql, [
                'monto' => $monto,
                'fecha' => $fecha,
                'descripcion' => $descripcion,
                'categoria_id' => $categoria_id,
                'usuario_id' => $usuario_id,
                'estado_pago' => $estado_pago
            ]);

            // Devolver la respuesta en formato JSON
            echo json_encode(
                [
                    'mensaje' => 'Gasto registrado con éxito',
                    'retorno' => 1

                ]
            );
        }
    }

    public function actualizarSueldoFijo($f3)
    {
        // Obtener los parámetros desde $_POST
        $usuario_id = $_POST['usuario_id'] ?? null;
        $monto = $_POST['monto'] ?? null;

        // Depurar para verificar los valores de $usuario_id y $monto
        error_log('Usuario ID: ' . $usuario_id);
        error_log('Monto: ' . $monto);

        if (isset($usuario_id) && isset($monto)) {
            // Obtener el sueldo fijo actual del usuario desde la base de datos
            $cadenaSqlSueldo = "SELECT monto FROM sueldofijo WHERE usuario_id = :usuario_id";
            $sueldoResult = $f3->DB->exec($cadenaSqlSueldo, ['usuario_id' => $usuario_id]);

            if (count($sueldoResult) > 0) {
                $sueldoFijo = $sueldoResult[0]['monto'];
                $nuevoSueldoFijo = $sueldoFijo - $monto;

                // Actualizar el sueldo fijo en la base de datos
                $cadenaSqlActualizarSueldo = "UPDATE sueldofijo SET monto = :nuevo_sueldo WHERE usuario_id = :usuario_id";
                $f3->DB->exec($cadenaSqlActualizarSueldo, [
                    'nuevo_sueldo' => $nuevoSueldoFijo,
                    'usuario_id' => $usuario_id
                ]);

                // Devolver una respuesta como JSON
                echo json_encode([
                    'mensaje' => 'Sueldo fijo actualizado correctamente',
                    'retorno' => 1
                ]);
            } else {
                // Devolver una respuesta de error como JSON si el usuario no tiene sueldo fijo registrado
                echo json_encode([
                    'mensaje' => 'Usuario no encontrado o sueldo fijo no disponible',
                    'retorno' => 0
                ]);
            }
        } else {
            // Devolver una respuesta de error como JSON si los parámetros no están definidos correctamente
            echo json_encode([
                'mensaje' => 'Parámetros incorrectos',
                'retorno' => 0
            ]);
        }
    }


    //Cambiar el estado de un gasto
    public function cambiarEstadoGasto($f3)
    {
        $id = $f3->get('POST.id');
        $estado_pago = $f3->get('POST.estado_pago');

        $this->M_Gastos->load(['id=?', $id]);

        if ($this->M_Gastos->loaded() > 0) {
            $this->M_Gastos->set('estado_pago', $estado_pago);
            $this->M_Gastos->save();

            $mensaje = "Estado cambiado correctamente";
            $retorno = 1;
        } else {
            $mensaje = "El gasto no está registrado.";
            $retorno = 0;
        }

        echo json_encode([
            'mensaje' => $mensaje,
            'retorno' => $retorno
        ]);
    }






}
