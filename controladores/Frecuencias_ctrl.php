
<?php
class Frecuencias_ctrl
{
    public $M_Frecuencias = null;
    public function __construct()
    {
        $this->M_Frecuencias = new M_Frecuencias();
    }

    public function verFrecuencias($f3)
    {
        $cadenaSql = "SELECT * FROM Frecuencias";

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


}