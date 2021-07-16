<?php

namespace Devall\Company\Block\Account;

use Magento\Framework\View\Element\Template;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\Session as CustomerSession;
use Devall\Company\Model\CompanyRepository;
use Devall\Company\Model\ResourceModel\Company\Collection;
use Devall\Company\Model\Company as CompanyModel;

class CompanyData extends Template {

    const REST_API_URL = 'rest/V1/devall_company';

    /**
     * @var Collection
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
     * @param Collection $Collection
     * @param CompanyRepository $CompanyRepository
     * @param CustomerSession $CustomerSession
     * @param CustomerRepositoryInterface $CustomerRepositoryInterface
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        Collection $Collection,
        CompanyRepository $CompanyRepository,
        CustomerSession $CustomerSession,
        CustomerRepositoryInterface $CustomerRepositoryInterface,
        array $data = []
    ) {
        $this->companyRepository = $CompanyRepository;
        $this->customerSession = $CustomerSession;
        $this->collection = $Collection;
        $this->customerRepositoryInterface = $CustomerRepositoryInterface;
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

    public function getCustomerCompanyId()
    {
        $companyAttribute = $this->getCompanyAttribute();

        if (empty($companyAttribute)) return false;
        return $companyAttribute->getValue();
    }

    /**
     * @return int|null
     */
    public function getCustomerId(): ?int
    {
        return $this->customerSession->getId();
    }

    /**
     * @return Collection
     */
    public function getCompaniesCollection(): Collection
    {
        return $this->collection;
    }

    /**
     * @return \Devall\Company\Api\Data\CompanyInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getCompany(): \Devall\Company\Api\Data\CompanyInterface
    {
        $costumer = $this->customerRepositoryInterface->getById($this->getCustomerId());
        $companyid = $costumer->getCustomAttribute(CompanyModel::COMPANY_ATTRIBUTE_CODE)->getValue();
        return $this->companyRepository->getById($companyid);
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->getUrl('company/company/editpost');
    }

    public function getRestApiUrl() {
        return self::REST_API_URL;
    }
}
