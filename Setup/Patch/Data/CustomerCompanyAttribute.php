<?php

namespace Devall\Company\Setup\Patch\Data;

use Magento\Customer\Api\CustomerMetadataInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Eav\Model\Config;

class CustomerCompanyAttribute
    implements DataPatchInterface,
    PatchRevertableInterface
{

    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * @var \Magento\Framework\Setup\ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @param \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(
        \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory,
        Config $eavConfig
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->eavConfig       = $eavConfig;
    }

    /**
     * {@inheritdoc}
     * @throws \Exception
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $attr = "company_attr";

        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $eavSetup->addAttribute(
            CustomerMetadataInterface::ENTITY_TYPE_CUSTOMER,
            $attr,
            [
                'type'         => 'int',
                'label'        => 'Company attr',
                'input'        => 'text',
                'required'     => false,
                'visible'      => true,
                'user_defined' => true,
                'position'     => 999,
                'system'       => 0,
            ]
        );
        $eavSetup->addAttributeToSet(
            CustomerMetadataInterface::ENTITY_TYPE_CUSTOMER,
            CustomerMetadataInterface::ATTRIBUTE_SET_ID_CUSTOMER,
            null,
            'company_attr');

        $companyAttribute = $this->eavConfig->getAttribute(CustomerMetadataInterface::ENTITY_TYPE_CUSTOMER, $attr)
            ->setData('used_in_forms', [
                'adminhtml_customer',
                'customer_account_create',
                'customer_account_edit'
            ]);

        $companyAttribute->save();

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies(): array
    {
        return [];
    }

    public function revert()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $eavSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, 'company_attr');

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases(): array
    {
        return [];
    }
}
