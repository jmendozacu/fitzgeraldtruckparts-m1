<?php

class BroSolutions_SmartSlides_Model_Resource_Smartslides_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{

    protected function _construct()
    {
        $this->_init('smartslides/smartslides');
    }
}