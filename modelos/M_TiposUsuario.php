<?php

class M_TiposUsuario extends \DB\SQL\Mapper
{
    public function __construct()
    {
        parent::__construct(\Base::instance()->get('DB'), 'tiposusuario');
    }
}
