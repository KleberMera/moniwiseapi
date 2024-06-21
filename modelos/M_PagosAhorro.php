
<?php

class M_PagosAhorro extends \DB\SQL\Mapper
{
    public function __construct()
    {
        parent::__construct(\Base::instance()->get('DB'), 'pagosahorro');
    }
}