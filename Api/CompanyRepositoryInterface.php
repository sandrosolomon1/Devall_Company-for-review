<?php
declare(strict_types=1);
namespace Devall\Company\Api;

use Devall\Company\Api\Data\CompanySearchResultInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Devall\Company\Api\Data\CompanyInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Interface CompanyRepositoryInterface
 * @package Devall\Company\Api
 */
interface CompanyRepositoryInterface
{

    /**
     * @param int $id
     * @return CompanyInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): CompanyInterface;

    /**
     * @param int $id
     * @return CompanyInterface
     * @throws NoSuchEntityException
     */
    public function getByIdApi(int $id): CompanyInterface;

    /**
     * @param CompanyInterface $company
     * @return CompanyInterface
     */
    public function save(CompanyInterface $company): CompanyInterface;

    /**
     * @param CompanyInterface $company
     * @return void
     */
    public function delete(CompanyInterface $company): void;

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return CompanySearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): CompanySearchResultInterface;

    /**
     * @return CompanyInterface[]
     * @throws NoSuchEntityException
     */
    public function getListApi(): array;
}
