<?php

namespace Devall\Company\Controller\Company;

use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\Result\Redirect;
use Devall\Company\Model\Company as CompanyModel;
use Exception;
use Magento\Customer\Model\AddressRegistry;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\App\Action\Context;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Customer\Model\Session;

class EditPost extends Action {
    /**
     * @var Session
     */
    protected $session;

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var Validator
     */
    protected $formKeyValidator;

    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepositoryInterface;

    /**
     * @var AddressRegistry
     */
    private $addressRegistry;


    /**
     * EditPost constructor.
     * @param Context $context
     * @param CustomerRepositoryInterface $customerRepositoryInterface
     * @param Validator $formKeyValidator
     * @param Session $customerSession
     * @param PageFactory $resultPageFactory
     * @param AddressRegistry|null $addressRegistry
     */
    public function __construct(
        Context $context,
        CustomerRepositoryInterface $customerRepositoryInterface,
        Validator $formKeyValidator,
        Session $customerSession,
        PageFactory $resultPageFactory,
        AddressRegistry $addressRegistry = null
    ) {
        $this->customerRepositoryInterface = $customerRepositoryInterface;
        $this->formKeyValidator = $formKeyValidator;
        $this->session = $customerSession;
        $this->resultPageFactory = $resultPageFactory;
        $this->addressRegistry = $addressRegistry;
        parent::__construct($context);
    }

    public function execute()
    {
        $validFormKey = $this->formKeyValidator->validate($this->getRequest());

        if ($validFormKey && $this->getRequest()->isPost()) {
            try {
                $data = $this->_request->getParam('company');

                $customerId = $this->session->getCustomerId();
                $customer = $this->customerRepositoryInterface->getById($customerId);

                foreach ($customer->getAddresses() as $address) {
                    $addressModel = $this->addressRegistry->retrieve($address->getId());
                    $addressModel->setShouldIgnoreValidation(true);
                }

                $customer->setCustomAttribute(CompanyModel::COMPANY_ATTRIBUTE_CODE, $data);
                $this->customerRepositoryInterface->save($customer);

                $this->messageManager->addSuccessMessage(__("Data Saved."));
            } catch (Exception $e) {
                $this->messageManager->addErrorMessage($e, __("We can\'t submit your request, Please try again."));
            }
        }

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('customer/account');

        return $resultRedirect;
    }
}
