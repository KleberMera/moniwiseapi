
<?php
class Ingresos_ctrl
{
    public $M_Ingresos = null;
    public function __construct()
    {
        $this->M_Ingresos = new M_Ingresos();
    }

    
    public function verIngresos($f3)
    {
        $cadenaSql = "SELECT * FROM ingresos";

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

    //Ver ingresos por usuario_id
    public function verIngresosUsuario($f3)
    {
        $usuario_id = $f3->get('POST.usuario_id');
        $cadenaSql = "SELECT * FROM ingresos WHERE usuario_id = ?";
        $items = $f3->DB->exec($cadenaSql, [$usuario_id]);

        // Formatear la respuesta
        $response = [
            'cantidad' => count($items),
            'data' => $items
        ];

        // Devolver la respuesta en formato JSON
        echo json_encode($response);
    }

    public function registrarIngresos($f3)
    {
        //Los datos son, monto, fecha, descripcion, usuario_id, estado
        $mensaje = "";
        $newId = 0;
        $retorno = 0;

        // Obtener los datos del ingreso desde la solicitud POST
        $monto = $f3->get('POST.monto');
        $fecha = $f3->get('POST.fecha');
        $descripcion = $f3->get('POST.descripcion');
        $usuario_id = $f3->get('POST.usuario_id');
        $estado = $f3->get('POST.estado');

        // Validar datos
        if (empty($monto) || empty($fecha) || empty($descripcion) || empty($usuario_id)) {
            $mensaje = "Todos los campos son obligatorios.";
            $retorno = 0;
        } else {
            // Insertar el nuevo ingreso en la base de datos
            $this->M_Ingresos->set('monto', $monto);
            $this->M_Ingresos->set('fecha', $fecha);
            $this->M_Ingresos->set('descripcion', $descripcion);
            $this->M_Ingresos->set('usuario_id', $usuario_id);
            $this->M_Ingresos->set('estado', $estado);
            $this->M_Ingresos->save();

            $mensaje = "Ingreso registrado correctamente";
            $newId = $this->M_Ingresos->get('id'); // Obtener el ID del nuevo ingreso registrado
            $retorno = 1;
        }

        // Devolver la respuesta en formato JSON
        echo json_encode([
            'mensaje' => $mensaje,
            'id' => $newId,
            'retorno' => $retorno
        ]);


    }

    // Método para cambiar el monto por ID
    public function cambiarMontoPorId($f3)
    {
        $mensaje = "";
        $retorno = 0;
        
        $id = $f3->get('POST.id');
        $monto = $f3->get('POST.monto');

        if (empty($id) || empty($monto)) {
            $mensaje = "ID y nuevo monto son obligatorios.";
            $retorno = 0;
        } else {
            // Obtener el registro por ID
            $ingreso = $this->M_Ingresos->load(['id=?', $id]);
            if ($ingreso) {
                $ingreso->monto = $monto;
                $ingreso->save();
                $mensaje = "Monto actualizado correctamente";
                $retorno = 1;
            } else {
                $mensaje = "Ingreso no encontrado.";
                $retorno = 0;
            }
        }

        echo json_encode([
            'mensaje' => $mensaje,
            'retorno' => $retorno
        ]);
    }

   

}