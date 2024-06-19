
<?php

class M_SueldoFijo extends \DB\SQL\Mapper
{
    public function __construct()
    {
        parent::__construct(\Base::instance()->get('DB'), 'sueldofijo');
    }
}