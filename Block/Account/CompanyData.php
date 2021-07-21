<?php

namespace Devall\Company\Block\Account;

use Magento\Framework\View\Element\Template;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\Session as CustomerSession;
use Devall\Company\Model\CompanyRepository;
use Devall\Company\Model\ResourceModel\Company\CollectionFactory;
use Devall\Company\Model\Company as CompanyModel;

class CompanyData extends Template {

    const REST_API_URL = '/rest/V1/devall_company';

    /**
     * @var Devall\Company\Model\ResourceModel\Company\Collection
     */
    private $collection;
    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepositoryInterface;
    /**
     * @var CompanyRepository
     */
    private $companyRepository;
    /**
     * @var CustomerSession
     */
    private $customerSession;

    /**
     * CompanyData constructor.
     * @param Template\Context $context
     * @param Collection $collection
     * @param CompanyRepository $companyRepository
     * @param CustomerSession $customerSession
     * @param CustomerRepositoryInterface $customerRepositoryInterface
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        CollectionFactory $collectionFactory,
        CompanyRepository $companyRepository,
        CustomerSession $customerSession,
        CustomerRepositoryInterface $customerRepositoryInterface,
        array $data = []
    ) {
        $this->companyRepository = $companyRepository;
        $this->customerSession = $customerSession;
        $this->collection = $collectionFactory->create();
        $this->customerRepositoryInterface = $customerRepositoryInterface;
        parent::__construct($context, $data);
    }

    /**
     * @return \Magento\Framework\Api\AttributeInterface|null
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCompanyAttribute(): ?\Magento\Framework\Api\AttributeInterface
    {
        $customerId = $this->getCustomerId();
        $customer = $this->customerRepositoryInterface->getById($customerId);
        return $customer->getCustomAttribute(CompanyModel::COMPANY_ATTRIBUTE_CODE);
    }

    /**
     * @return mixed|null
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCustomerCompanyId()
    {
        $companyAttribute = $this->getCompanyAttribute();

        if (isset($companyAttribute)) {
            return $companyAttribute->getValue();
        }
        return null;
    }

    /**
     * @return int|null
     */
    public function getCustomerId(): ?int
    {
        return $this->customerSession->getId();
    }

    /**
     * @return Devall\Company\Model\ResourceModel\Company\Collection|\Devall\Company\Model\ResourceModel\Company\Collection
     */
    public function getCompaniesCollection()
    {
        return $this->collection;
    }

    /**
     * @return \Devall\Company\Api\Data\CompanyInterface|CompanyModel|null
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCompany()
    {
        $companyId = $this->getCustomerCompanyId();
        if(isset($companyId)) {
            $this->companyRepository->getById($companyId);
        }
        return null;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->getUrl('devall/company/editpost');
    }

    /**
     * @return string
     */
    public function getRestApiUrl() {
        return self::REST_API_URL;
    }
}
