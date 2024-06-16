
<?php
class CategoriasPredefinidas_ctrl
{
    public $M_CategoriasPredefinidas = null;
    public function __construct()
    {
        $this->M_CategoriasPredefinidas = new M_CategoriasPredefinidas();
    }

    public function verCategoriasPredefinidas($f3)
    {
        $cadenaSql = "SELECT * FROM CategoriasPredefinidas";

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