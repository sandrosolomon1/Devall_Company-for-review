<?php
declare(strict_types=1);
namespace Devall\Company\Block\Account;

use Devall\Company\Api\Data\CompanyInterface;
use Devall\Company\Model\ResourceModel\Company\Collection;
use Magento\Framework\Api\AttributeInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\Session as CustomerSession;
use Devall\Company\Model\CompanyRepository;
use Devall\Company\Model\ResourceModel\Company\CollectionFactory;
use Devall\Company\Model\Company as CompanyModel;

/**
 * Class CompanyData
 * @package Devall\Company\Block\Account
 */
class CompanyData extends Template
{

    const REST_API_URL = '/rest/V1/devall_company';

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;
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
     * @param CollectionFactory $collectionFactory
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
        $this->collectionFactory = $collectionFactory;
        $this->customerRepositoryInterface = $customerRepositoryInterface;
        parent::__construct($context, $data);
    }

    /**
     * @return AttributeInterface|null
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function getCompanyAttribute(): ?AttributeInterface
    {
        $customerId = $this->getCustomerId();
        $customer = $this->customerRepositoryInterface->getById($customerId);
        return $customer->getCustomAttribute(CompanyModel::COMPANY_ATTRIBUTE_CODE);
    }

    /**
     * @return int|null
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function getCustomerCompanyId(): ?int
    {
        $companyAttribute = $this->getCompanyAttribute();

        if (isset($companyAttribute)) {
            return (int)$companyAttribute->getValue();
        }
        return null;
    }

    /**
     * @return int|null
     */
    public function getCustomerId(): ?int
    {
        return (int)$this->customerSession->getId();
    }

    /**
     * @return Collection
     */
    public function getCompaniesCollection(): Collection
    {
        return $this->collectionFactory->create();
    }

    /**
     * @return CompanyInterface|null
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function getCompany(): ?CompanyInterface
    {
        $companyId = $this->getCustomerCompanyId();
        if (isset($companyId)) {
            return $this->companyRepository->getById($companyId);
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
    public function getRestApiUrl(): string
    {
        return self::REST_API_URL;
    }
}
