<?php
declare(strict_types=1);
namespace Devall\Company\Api\Data;

/**
 * Interface CompanySearchResultInterface
 * @package Devall\Company\Api\Data
 */
interface CompanySearchResultInterface extends SearchResultsInterface
{
    /**
     * @return CompanyInterface[]
     */
    public function getItems();

    /**
     * @param CompanyInterface[] $items
     * @return void
     */
    public function setItems(array $items);
}
