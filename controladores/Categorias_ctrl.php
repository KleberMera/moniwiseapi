
<?php
class Categorias_ctrl
{
    public $M_Categorias = null;
    public function __construct()
    {
        $this->M_Categorias = new M_Categorias();
    }

    public function verCategorias($f3)
    {
        $cadenaSql = "SELECT * FROM categorias";

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


    public function verTodasCategoriasConNombreUsuario($f3)
    {
        $cadenaSql = "
        SELECT c.id, c.nombre, c.descripcion, c.estado, c.usuario_id, u.nombre AS nombre_usuario 
        FROM categorias c
        JOIN usuarios u ON c.usuario_id = u.id
    ";


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



    //Obtener Categoria por ID
    public function verCategoriaPorId($f3)
    {
        $usuario_id = $f3->get('POST.usuario_id');

        if (empty($usuario_id)) {
            echo json_encode([
                'mensaje' => 'El ID no puede estar vacio.',
                'data' => [],
                'retorno' => 0
            ]);
            return;
        }

        // Ejecuta la consulta
        $item = $f3->DB->exec("SELECT * FROM categorias WHERE usuario_id = ?", [$usuario_id]);

        // Formatear la respuesta
        $response = [
            'cantidad' => count($item),
            'data' => $item
        ];

        // Devolver la respuesta en formato JSON
        echo json_encode($response);
    }

    //Registrar Categoria 
    public function registrarCategoria($f3)
    {
        /*Nombre, Descripcion, usuario_id, estado*/
        $nombre = $f3->get('POST.nombre');
        $descripcion = $f3->get('POST.descripcion');
        $usuario_id = $f3->get('POST.usuario_id');
        $estado = $f3->get('POST.estado');


        if (empty($nombre) || empty($descripcion) || empty($usuario_id)) {
            echo json_encode([
                'mensaje' => 'Todos los campos son obligatorios.',
                'data' => [],
                'retorno' => 0
            ]);
            return;
        }

        // Insertar el nuevo categoria en la base de datos
        $this->M_Categorias->set('nombre', $nombre);
        $this->M_Categorias->set('descripcion', $descripcion);
        $this->M_Categorias->set('usuario_id', $usuario_id);
        $this->M_Categorias->set('estado', $estado);


        $this->M_Categorias->save();

        $mensaje = "Categoria registrada correctamente";
        $newId = $this->M_Categorias->get('id'); // Obtener el ID del nuevo categoria registrado
        $retorno = 1;

        // Devolver la respuesta en formato JSON
        echo json_encode([
            'mensaje' => $mensaje,
            'id' => $newId,
            'retorno' => $retorno
        ]);
    }
}
