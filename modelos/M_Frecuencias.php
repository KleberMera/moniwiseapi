
<?php

class M_Frecuencias extends \DB\SQL\Mapper
{
    public function __construct()
    {
        parent::__construct(\Base::instance()->get('DB'), 'Frecuencias');
    }    
}