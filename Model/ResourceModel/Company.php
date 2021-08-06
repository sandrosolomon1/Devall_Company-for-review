<?php
declare(strict_types=1);
namespace Devall\Company\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Company
 * @package Devall\Company\Model\ResourceModel
 */
class Company extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('devall_company','entity_id');
    }
}
