<?php
class Usuarios_ctrl{
    public $M_Usuarios=null;
    public function __construct(){
       $this->M_Usuarios=new M_Usuarios();
    }
    
   


    public function registrarUsuario($f3) {
        $mensaje = "";
        $newId = 0;
        
        // Obtener los datos del usuario desde la solicitud POST
        $usuario_usuario = $f3->get('POST.usuario_usuario');
        $usuario_clave = $f3->get('POST.usuario_clave');
        $usuario_nombre = $f3->get('POST.usuario_nombre');
        $usuario_telefono = $f3->get('POST.usuario_telefono');
        $usuario_correo = $f3->get('POST.usuario_correo');
        $usuario_activo = $f3->get('POST.usuario_activo');
        $perfil_id = $f3->get('POST.perfil_id');

        // Verificar si el usuario ya existe
        $this->M_Usuarios->load(['usu_usuario=?', $usuario_usuario]);
        if ($this->M_Usuarios->loaded() > 0) {
            $mensaje = "El usuario con ese nombre ya existe";
        } else {
            // Insertar el nuevo usuario en la base de datos
            $this->M_Usuarios->set('usu_usuario', $usuario_usuario);
            $this->M_Usuarios->set('usu_clave', $usuario_clave);
            $this->M_Usuarios->set('usu_nombre', $usuario_nombre);
            $this->M_Usuarios->set('usu_telefono', $usuario_telefono);
            $this->M_Usuarios->set('usu_correo', $usuario_correo);
            $this->M_Usuarios->set('usu_activo', $usuario_activo);
            $this->M_Usuarios->set('per_id', $perfil_id);
            $this->M_Usuarios->save();

            $mensaje = "Usuario registrado correctamente";
            $newId = $this->M_Usuarios->get('usu_id'); // Ajusta según tu modelo
        }

        // Devolver la respuesta en formato JSON
        echo json_encode(
            [
                'mensaje' => $mensaje,
                'id' => $newId
            ]
        );
    }


    public function login($f3) {
        $mensaje = "";
        $newId = 0;
        $retorno = 0;
        
        // Obtener las credenciales del usuario desde la solicitud POST
        $usuario_usuario = $f3->get('POST.usuario_usuario');
        $usuario_clave = $f3->get('POST.usuario_clave');
        
        // Verificar si el usuario existe y la contraseña es correcta
        $this->M_Usuarios->load(['usu_usuario=? AND usu_clave=?', $usuario_usuario, $usuario_clave]);
        if ($this->M_Usuarios->loaded() > 0) {
            // Verificar si el usuario está activo
            if ($this->M_Usuarios->get('usu_activo') == 1) {
                $mensaje = "Se ha ingresado correctamente";
                $newId = $this->M_Usuarios->get('usu_id');
                $retorno = 1;
            } else {
                $mensaje = "El usuario no está activo";
            }
        } else {
            $mensaje = "Usuario o clave incorrecta";
        }

        // Devolver la respuesta en formato JSON
        echo json_encode([
            'mensaje' => $mensaje,
            'id' => $newId,
            'usuario' => $this->M_Usuarios->get('usu_nombre'),
            'usuario_id' => $this->M_Usuarios->get('usu_id'),
            'usuario_clave' => $this->M_Usuarios->get('usu_clave'),
            'usuario_nombre' => $this->M_Usuarios->get('usu_nombre'),
            'usuario_telefono' => $this->M_Usuarios->get('usu_telefono'),
            'usuario_correo' => $this->M_Usuarios->get('usu_correo'),
            'usuario_activo' => $this->M_Usuarios->get('usu_activo'),
            'perfil_id' => $this->M_Usuarios->get('per_id'),
            'retorno' => $retorno
        ]);
    }
}//fin clase
?>