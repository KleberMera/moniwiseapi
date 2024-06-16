<?php
class Usuarios_ctrl
{
    public $M_Usuarios = null;
    public function __construct()
    {
        $this->M_Usuarios = new M_Usuarios();
    }




    public function registrarUsuario($f3)
    {
        $mensaje = "";
        $newId = 0;

        // Obtener los datos del usuario desde la solicitud POST
        $usuario_usuario = $f3->get('POST.usuario_usuario');
        $usuario_clave = $f3->get('POST.usuario_clave');
        $usuario_nombre = $f3->get('POST.usuario_nombre');
        $usuario_cedula = $f3->get('POST.usuario_cedula');
        $usuario_telefono = $f3->get('POST.usuario_telefono');
        $usuario_correo = $f3->get('POST.usuario_correo');
        $tipo_usuario_id = $f3->get('POST.tipo_usuario_id'); // Ajustar según tu formulario y lógica
        $estado = 1; // Por defecto activo
        $fecha_creacion = date('Y-m-d H:i:s'); // Fecha actual

        // Verificar si el usuario ya existe
        $this->M_Usuarios->load(['usuario=?', $usuario_usuario]);
        if ($this->M_Usuarios->loaded() > 0) {
            $mensaje = "El usuario con ese nombre de usuario ya existe";
        } else {
            // Insertar el nuevo usuario en la base de datos
            $this->M_Usuarios->set('nombre', $usuario_nombre);
            $this->M_Usuarios->set('cedula', $usuario_cedula);
            $this->M_Usuarios->set('telefono', $usuario_telefono);
            $this->M_Usuarios->set('correo', $usuario_correo);
            $this->M_Usuarios->set('usuario', $usuario_usuario);
            $this->M_Usuarios->set('contraseña', $usuario_clave,); // Almacenar la contraseña de forma segura
            $this->M_Usuarios->set('tipo_usuario_id', $tipo_usuario_id);
            $this->M_Usuarios->set('estado', $estado);
            $this->M_Usuarios->set('fecha_creacion', $fecha_creacion);
            $this->M_Usuarios->save();

            $mensaje = "Usuario registrado correctamente";
            $newId = $this->M_Usuarios->get('id'); // Obtener el ID del nuevo usuario registrado
        }

        // Devolver la respuesta en formato JSON
        echo json_encode([
            'mensaje' => $mensaje,
            'id' => $newId
        ]);
    }





    //Ingreso con usuario y clave
    public function login($f3)
    {
        $usuario = new M_Usuarios();
        $mensaje = "";
        $newId = 0;


        $usuario->load(['usuario=?', $f3->get('POST.usuario_usuario')]);
        if ($usuario->loaded() > 0) {
            $usuario->load(['contraseña=?', $f3->get('POST.usuario_clave')]);
            if ($usuario->loaded() > 0) {
                //verificar si esta activo
                if ($usuario->get('estado') == 1) {
                    $mensaje = "Se ha ingresado correctamente";
                    $newId = $usuario->get('id');
                    $retorno = 1;
                } else {
                    $mensaje = "El usuario no esta activo";
                    $retorno = 0;
                }
            } else {
                $mensaje = "Clave incorrecta";
                $retorno = 0;
            }
        } else {
            $mensaje = "El usuario no existe";
            $retorno = 0;
        }
        echo json_encode([
            'mensaje' => $mensaje,
            'id' => $newId,
            'usuario_nombre' => $usuario->get('nombre'),
            'usuario_id' => $usuario->get('id'),
            'usuario_activo' => $usuario->get('estado'),
            'retorno' => $retorno
        ]);
    }
} //fin clase
