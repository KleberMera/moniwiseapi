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


   

   
} //fin clase
