
<?php

class M_Categorias extends \DB\SQL\Mapper
{
    public function __construct()
    {
        parent::__construct(\Base::instance()->get('DB'), 'Categorias');    
    }    
}   