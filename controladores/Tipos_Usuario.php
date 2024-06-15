<?php
class TiposUsuario_ctrl
{
    public $M_TipoUsuario;
    public function __construct()
    {
        $this->M_TipoUsuario = new M_TiposUsuario();
    }



    public function listarPerfilCliente($f3) {
        $cadenaSql = "";
        $cadenaSql = $cadenaSql . "SELECT * ";
        $cadenaSql = $cadenaSql . "FROM perfil ";
        $cadenaSql = $cadenaSql . "WHERE per_descripcion = 'Cliente'";

        // Ejecuta la consulta
        $items = $f3->DB->exec($cadenaSql);

        echo json_encode(
            [
                'cantidad' => count($items),
                'data' => $items
            ]
        );
    }


    public function listarMenusPorPerfil($f3) {
        $per_id = $f3->get('POST.per_id'); // Obtener el per_id desde la solicitud POST

        $cadenaSql = "";
        $cadenaSql = $cadenaSql . "SELECT m.* ";
        $cadenaSql = $cadenaSql . "FROM menu m ";
        $cadenaSql = $cadenaSql . "INNER JOIN accesos a ON m.men_id = a.men_id ";
        $cadenaSql = $cadenaSql . "WHERE a.per_id = ?";

        // Ejecuta la consulta con el parámetro
        $items = $f3->DB->exec($cadenaSql, $per_id);

        echo json_encode(
            [
                'cantidad' => count($items),
                'data' => $items
            ]
        );
    }


    public function listarPedidosPorFecha($f3)
    {
        

        // Construir la consulta SQL
        $cadenaSql = "
            SELECT p.ped_id, c.cli_nombre, p.ped_fecha, pd.det_precio
            FROM pedidos p
            JOIN clientes c ON p.cli_id = c.cli_id
            JOIN pedidos_detalle pd ON p.ped_id = pd.ped_id ";

        // Ejecutar la consulta
        $items = $f3->DB->exec($cadenaSql);

        // Retornar los resultados en formato JSON
        echo json_encode([
            'cantidad' => count($items),
            'data' => $items
        ]);
    }

} //fin clase
