
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
}
