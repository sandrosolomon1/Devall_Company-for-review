<?php

namespace Devall\Company\Block;

use Magento\Framework\View\Element\Template;
use Devall\Company\Model\Company;
use Devall\Company\Model\CompanyRepository;

class Display extends Template
{
    /**
     * @var Company
     */
    private $company;

    /**
     * @var CompanyRepository
     */
    private $companyrepository;

    public function __construct(
        Template\Context $context,
        Company $Company,
        CompanyRepository $companyRepository,
        array $data = []
    )
    {
        $this->company = $Company;
        $this->companyrepository = $companyRepository;
        parent::__construct($context, $data);
    }

    public function GetCompanyCollection()
    {
        return $this->company->getCollection();
    }

    public function GetCompanyById($id) {
        return $this->companyrepository->getById($id);
    }
}
