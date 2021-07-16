<?php

namespace Devall\Company\Block\Account\Dashboard;

use Magento\Framework\View\Element\Template;
use Devall\Company\Model\CompanyRepository;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Devall\Company\Model\Company as CompanyModel;

class Company extends Template
{
    /**
     * @var CompanyRepository
     */
    private $companyRepository;

    /**
     * @var CustomerSession
     */
    protected $customerSession;

    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepositoryInterface;

    /**
     * Company constructor.
     * @param Template\Context $context
     * @param CompanyRepository $CompanyRepository
     * @param CustomerSession $CustomerSession
     * @param CustomerRepositoryInterface $CustomerRepositoryInterface
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        CompanyRepository $CompanyRepository,
        CustomerSession $CustomerSession,
        CustomerRepositoryInterface $CustomerRepositoryInterface,
        array $data = []
    )
    {
        $this->customerRepositoryInterface = $CustomerRepositoryInterface;
        $this->customerSession = $CustomerSession;
        $this->companyRepository = $CompanyRepository;
        parent::__construct($context, $data);
    }

    /**
     * @return object
     */
    public function getCompanyData(): object
    {
        $company = $this->getCompany();

        return (object) [
            "Id" => $company->getId(),
            "Name" => $company->getName(),
            "Country" => $company->getCountry(),
            "Street" => $company->getStreet(),
            "Number" => $company->getNumber(),
            "Size" => $company->getSize()
        ];
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
     * @return int|null
     */
    private function getCustomerId(): ?int
    {
        return $this->customerSession->getId();
    }
}
