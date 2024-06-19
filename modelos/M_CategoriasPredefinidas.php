

<?php

class M_CategoriasPredefinidas extends \DB\SQL\Mapper
{
    public function __construct()
    {
        parent::__construct(\Base::instance()->get('DB'), 'categoriaspredefinidas');
    }    
}