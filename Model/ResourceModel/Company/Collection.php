<?php
declare(strict_types=1);
namespace Devall\Company\Model\ResourceModel\Company;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package Devall\Company\Model\ResourceModel\Company
 */
class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Devall\Company\Model\Company',
            'Devall\Company\Model\ResourceModel\Company');
    }
}
