
<?php
class MetasAhorro_ctrl
{
    public $M_MetasAhorro = null;
    public function __construct()
    {
        $this->M_MetasAhorro = new M_MetasAhorro();
    }

   
    //Ver metas ahorro
    public function verMetasAhorro($f3)
    {
        $cadenaSql = "SELECT * FROM metasahorro";

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


    public function registrarMetasAhorro($f3)
    {
        $mensaje = "";
        $newId = 0;
        $retorno = 0;

        // Obtener los datos del metas ahorro desde la solicitud POST
       
        $nombre = $f3->get('POST.nombre');
        $monto_objetivo = $f3->get('POST.monto_objetivo');
        $frecuencia_id = $f3->get('POST.frecuencia_id');
        $fecha_creacion = date('Y-m-d H:i:s'); // Fecha actual
        $fecha_inicio = $f3->get('POST.fecha_inicio');
        $fecha_final = $f3->get('POST.fecha_final');
        $usuario_id = $f3->get('POST.usuario_id');
        $estado = $f3->get('POST.estado');

        // Validar datos
        if (empty($nombre) || empty($monto_objetivo) || empty($frecuencia_id) || empty($fecha_creacion) || empty($usuario_id) || empty($estado)) {
            $mensaje = "Todos los campos son obligatorios.";
            $retorno = 0;
        } else {
            // Insertar el nuevo metas ahorro en la base de datos
            $this->M_MetasAhorro->set('nombre', $nombre);
            $this->M_MetasAhorro->set('monto_objetivo', $monto_objetivo);
            $this->M_MetasAhorro->set('frecuencia_id', $frecuencia_id);
          //Fecha de creacion actual
            $this->M_MetasAhorro->set('fecha_creacion', $fecha_creacion);
            $this->M_MetasAhorro->set('fecha_inicio', $fecha_inicio);
            $this->M_MetasAhorro->set('fecha_final', $fecha_final);
            $this->M_MetasAhorro->set('usuario_id', $usuario_id);
            $this->M_MetasAhorro->set('estado', $estado);
            $this->M_MetasAhorro->save();

            $mensaje = "Metas ahorro registrado correctamente";
            $newId = $this->M_MetasAhorro->get('id'); // Obtener el ID del nuevo metas ahorro registrado
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