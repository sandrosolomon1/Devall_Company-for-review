<?php
namespace Devall\Company\Model;

use Magento\Framework\Api\SortOrder;
use Devall\Company\Api\Data\CompanyInterface;
use Devall\Company\Model\CompanySearchResultFactory;
use Devall\Company\Model\ResourceModel\Company\Collection;
use Devall\Company\Model\ResourceModel\Company\CollectionFactory;
use Devall\Company\Model\ResourceModel\Company as CompanyResourceModel;
use Devall\Company\Model\CompanyFactory;

class CompanyRepository implements \Devall\Company\Api\CompanyRepositoryInterface
{
    /**
     * @var CompanyFactory
     */
    private $companyFactory;

    /**
     * @var CompanyResourceModel
     */
    private $companyResourceModel;

    /**
     * @var Collection
     */
    private $collection;

    /**
     * @var CompanySearchResultFactory
     */
    private $companySearchResultFactory;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * CompanyRepository constructor.
     * @param CompanyFactory $companyFactory
     * @param Collection $collection
     * @param CompanyResourceModel $companyResourceModel
     * @param CompanySearchResultFactory $companySearchResultFactory
     * @param CollectionFactory $collectionFactory
     */
    public function __construct
    (
        CompanyFactory $companyFactory,
        Collection $collection,
        CompanyResourceModel $companyResourceModel,
        CompanySearchResultFactory $companySearchResultFactory,
        CollectionFactory $collectionFactory
    )
    {
        $this->companyFactory = $companyFactory;
        $this->collection = $collection;
        $this->companyResourceModel = $companyResourceModel;
        $this->companySearchResultFactory = $companySearchResultFactory;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @inheridoc
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $id)
    {
        $company = $this->companyFactory->create();
        $this->companyResourceModel->load($company, $id);
        if (!$company->getId()) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(__('Unable to find company with ID "%1"', $id));
        }
        return $company;
    }

    /**
     * @inheridoc
     */
    public function getByIdApi(int $id) {
        return $this->getById($id);
    }

    /**
     * @inheridoc
     */
    public function save(CompanyInterface $company)
    {
        $this->companyResourceModel->save($company);
        return $company;
    }

    /**
     * @inheridoc
     */
    public function delete(CompanyInterface $company)
    {
        $this->companyResourceModel->delete($company);
    }

    /**
     * @inheridoc
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->collectionFactory->create();

        $this->addFiltersToCollection($searchCriteria, $collection);
        $this->addSortOrdersToCollection($searchCriteria, $collection);
        $this->addPagingToCollection($searchCriteria, $collection);

        $collection->load();

        return $this->buildSearchResult($searchCriteria, $collection);
    }

    /**
     * @inheridoc
     */
    public function getListApi()
    {
        return $this->collection->getData();
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     */
    private function addFiltersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection): void
    {
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            $fields = $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $fields[] = $filter->getField();
                $conditions[] = [$filter->getConditionType() => $filter->getValue()];
            }
            $collection->addFieldToFilter($fields, $conditions);
        }
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     */
    private function addSortOrdersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection): void
    {
        foreach ((array) $searchCriteria->getSortOrders() as $sortOrder) {
            $direction = $sortOrder->getDirection() === SortOrder::SORT_ASC ? 'asc' : 'desc';
            $collection->addOrder($sortOrder->getField(), $direction);
        }
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     */
    private function addPagingToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection): void
    {
        $collection->setPageSize($searchCriteria->getPageSize());
        $collection->setCurPage($searchCriteria->getCurrentPage());
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     * @return mixed
     */
    private function buildSearchResult(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        $searchResults = $this->companySearchResultFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

}
