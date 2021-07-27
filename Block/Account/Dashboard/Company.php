<?php
declare(strict_types=1);
namespace Devall\Company\Block\Account\Dashboard;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Devall\Company\Model\CompanyRepository;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Devall\Company\Model\Company as CompanyModel;
use Devall\Company\Api\Data\CompanyInterface;

/**
 * Class Company
 * @package Devall\Company\Block\Account\Dashboard
 */
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
    ) {
        $this->customerRepositoryInterface = $CustomerRepositoryInterface;
        $this->customerSession = $CustomerSession;
        $this->companyRepository = $CompanyRepository;
        parent::__construct($context, $data);
    }

    /**
     * @return CompanyInterface|null
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function getCompany(): ?CompanyInterface
    {
        $customer = $this->customerRepositoryInterface->getById($this->getCustomerId());
        $attr = $customer->getCustomAttribute(CompanyModel::COMPANY_ATTRIBUTE_CODE);

        if (isset($attr)) {
            return $this->companyRepository->getById((int)$attr->getValue());
        }
        return null;
    }

    /**
     * @return int|null
     */
    private function getCustomerId(): ?int
    {
        return (int)$this->customerSession->getId();
    }
}
