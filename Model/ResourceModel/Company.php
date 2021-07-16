<?php

namespace Devall\Company\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Company extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('devall_company','entity_id');
    }
}
