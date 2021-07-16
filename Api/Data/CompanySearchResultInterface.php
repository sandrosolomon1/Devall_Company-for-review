<?php

namespace Devall\Company\Api\Data;

use Devall\Company\Api\Data\CompanyInterface;
use Magento\Framework\Api\SearchResultsInterface;

interface CompanySearchResultInterface extends SearchResultsInterface
{
    /**
     * @return \Devall\Company\Api\Data\CompanyInterface[]
     */
    public function getItems();

    /**
     * @param \Devall\Company\Api\Data\CompanyInterface[] $items
     * @return void
     */
    public function setItems(array $items);
}
