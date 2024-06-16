<?php
class TipoUsuarios_ctrl
{
    public $M_TipoUsuarios = null;
    public function __construct()
    {
        $this->M_TipoUsuarios = new M_TipoUsuarios();
    }


    public function verTiposUsuario($f3) {
        $cadenaSql = "SELECT * FROM Tiposusuario";

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


    public function obtenerMenusPorTipoUsuario($f3)
    {
        // Obtener el id del tipo de usuario desde la solicitud POST
        $tipo_usuario_id = $f3->get('POST.tipo_usuario_id');

        // Validar que el id del tipo de usuario se haya recibido
        if (!isset($tipo_usuario_id)) {
            echo json_encode([
                'mensaje' => 'No se proporcionó el id del tipo de usuario',
                'menus' => []
            ]);
            return;
        }

        // Consulta SQL para obtener los menús por tipo de usuario
        $cadenaSql = "SELECT nombre, icono, pagina, estado 
                      FROM Menu 
                      WHERE tipo_usuario_id = :tipo_usuario_id";

        // Parámetros para la consulta preparada
        $params = [
            ':tipo_usuario_id' => $tipo_usuario_id
        ];

        // Ejecutar la consulta preparada
        $items = $f3->DB->exec($cadenaSql, $params);

        // Formatear la respuesta
        $response = [
            'cantidad' => count($items),
            'menus' => $items
        ];

        // Devolver la respuesta en formato JSON
        echo json_encode($response);
    }
   

   
} //fin clase
