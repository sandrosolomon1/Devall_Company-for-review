<?php

namespace Devall\Company\Model\ResourceModel\Company;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Devall\Company\Model\Company',
            'Devall\Company\Model\ResourceModel\Company');
    }
}
